<?php
error_reporting(0);
if(!empty($_GET['download'] == 'doc')) {
    header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.doc");
}
if(!empty($_GET['download'] == 'xls')) {
    header("Content-Type: application/force-download");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header("content-disposition: attachment;filename=" . date('d-m-Y') . "_laporan_rekam_medis.xls");
}
?>
<?php
$tgla = $start;
$tglk = $periode;
$bulan = array(
    '01' =>
'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei',
'06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' =>
'Oktober', '11' => 'November', '12' => 'Desember', );
$array1 = explode(
    "-",
    $tgla
);
$tahun = $array1[0];
$bulan1 = $array1[1];
$hari = $array1[2];
$bl1 =
$bulan[$bulan1];
$tgl1 = $hari . ' ' . $bl1 . ' ' . $tahun;
$no = 1;
$array2 =
explode("-", $tglk);
$tahun2 = $array2[0];
$bulan2 = $array2[1];
$hari2 =
$array2[2];
$bl2 = $bulan[$bulan2];
$tgl2 =  $bl2 . ' ' . $tahun2;
$total = 0;
$total1 = 0; ?>

<!DOCTYPE html>
<html>
    <head>
        <link
            rel="stylesheet"
            href="{{asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}"
        />
        <link
            rel="stylesheet"
            href="{{asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}"
        />
        <link
            rel="stylesheet"
            href="{{asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}}"
        />
        <title><?= $title;?></title>
        <style>
            body {
                background: rgba(0, 0, 0, 0.2);
            }
            page[size="A4"] {
                background: white;
                height: auto;
                width: 29.7cm;
                display: block;
                margin: 0 auto;
                margin-bottom: 0.5pc;
                box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
                padding-left: 2.54cm;
                padding-right: 2.54cm;
                padding-top: 1.54cm;
                padding-bottom: 1.54cm;
            }
            @media print {
                body,
                page[size="A4"] {
                    margin: 0;
                    box-shadow: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br />
            <div class="pull-left">
                Cetak Laporan - Preview HTML to PDF [ size paper A4 ]
            </div>
            <div class="pull-right">
                <button
                    type="button"
                    class="btn btn-success btn-md"
                    onclick="printDiv('printableArea')"
                >
                    <i class="fa fa-print"> </i> Print File
                </button>
            </div>
        </div>
        <br />
        <div id="printableArea">
            <page size="A4">
                <div class="">
                    <div class="panel-body">
                        <h4 class="text-center">
                            LAPORAN PREDIKSI METODE ABC
                            <br />{{strtoupper(env('APP_NAME'))}}
                        </h4>
                        <br>
                        Periode : {{$tgl2}}
                        <br>
                        <br />
                        <div class="row">
                            <div class="table-responsive pt-5">
                                <table
                                    class="display table table-bordered table-hover"
                                    id="data-width"
                                    width="100%"
                                >
                                    <thead
                                        class="text-center bg-primary text-white"
                                    >
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Nama Item</th>
                                            <th>Harga</th>
                                            <th>Jumlah Barang Keluar</th>
                                            <th>Nilai Konsumsi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">
                                                Total Nilai Konsumsi
                                            </th>
                                            <th id="total_nilai">0</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <p></p>
                            <div class="table-responsive pt-5">
                                <table
                                    class="display table table-bordered table-hover"
                                    id="data-width-1"
                                    width="100%"
                                >
                                    <thead
                                        class="text-center bg-primary text-white"
                                    >
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Nama Item</th>
                                            <th>Persentase</th>
                                            <th>Persentase Akumulatif</th>
                                            <th>Klasifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </page>
        </div>
    </body>
    <!-- jQuery 3 -->
    <script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('assets/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
    <!-- DataTables -->
    <script src="{{asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <!-- Money Format plugins -->
    <script src="{{asset('assets/js/dashboard-chart-area.js')}}"></script>

    <script>
        var total;
        $(function () {
            table = $("#data-width").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                lengthchange: false,
                ordering: false,
                ajax: {
                    url: '{{url("$page/json/$periode")}}',
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "nama",
                        className: "text-center",
                    },
                    {
                        data: "harga",
                        className: "text-center",
                        render: function (data) {
                            return (
                                '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>' +
                                number_format(data) +
                                "</span></div>"
                            );
                        },
                    },
                    {
                        data: "qty",
                        className: "text-center",
                    },
                    {
                        data: "nilai_konsumsi",
                        className: "text-center",
                        render: function (data) {
                            return (
                                '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>' +
                                number_format(data) +
                                "</span></div>"
                            );
                        },
                    },
                ],
            });

            table1 = $("#data-width-1").DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                lengthchange: false,
                ordering: false,
                ajax: {
                    url: '{{url("$page/json/$periode")}}',
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: "nama",
                        className: "text-center",
                    },
                    {
                        data: "persentase",
                        className: "text-center",
                    },
                    {
                        data: "akumulatif",
                        className: "text-center",
                    },
                    {
                        data: "klasifikasi",
                        className: "text-center",
                    },
                ],
            });

            $.ajax({
                url: '{{url("admin/metode/json/$periode")}}/',
                type: "GET",
                cache: false,
                dataType: "json",
                success: function (dataResult) {
                    console.log(dataResult);
                    var resultData = dataResult.data;
                    total = 0;
                    $.each(resultData, function (index, row) {
                        total = total + row.nilai_konsumsi;
                    });

                    $("#total_nilai").html(
                        '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>' +
                            number_format(total) +
                            "</span></div>"
                    );
                },
            });
        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</html>
