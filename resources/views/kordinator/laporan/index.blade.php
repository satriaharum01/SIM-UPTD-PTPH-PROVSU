@extends('backend.app')
@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                    <div class="card-options align-items-center">
                    <button class="btn btn-success btn-filter mx-2"  data-target="#filterModal" data-toggle="modal"><i class="fa fa-filter"></i> Filter</button>   
                    </div>
                  </div>
                  <div class="card-body " id="card-main">
                      <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary">Petugas</th>
                                <th class="text-primary">Wilayah Kerja</th>
                                <th class="text-primary">Tanaman</th>
                                <th class="text-primary">OPT</th>
                                <th class="text-primary">Periode</th>
                                <th class="text-primary">Luas Terserang</th>
                                <th class="text-primary">Luas Pengendalian</th>
                                <th class="text-primary">status</th>
                                <th class="text-primary" width="20%">Action</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                      </div>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                      <div>
                        {{env('APP_NAME')}} - {{$title}}
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header flex-row">
                <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Cari Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            
            <form action="" method="post" id="filterForm">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Petugas</label>
                    <select value="0" class="form-control" name="petugas_id" id="petugas_id">
                        <option value="0">Semua Petugas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Wilayah Kerja</label>
                    <select value="0" class="form-control" name="wilayah_kerja_id" id="wilayah_kerja_id">
                        <option value="0">Semua Wilayah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-terapkan btn-primary" data-dismiss="modal">Terapkan</button>
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@include('models.verify')
@endsection
@section('js')
<script>
  let icon = 'check';
  
  $("body").on("click", ".btn-terapkan", function () {
    let formData = $("#filterForm").serialize();
    let url = `{{ Request::url() }}/filter?${formData}`;
    table.ajax.url(url).load();
  })

  $(function () {
    //Petugas
    $.ajax({
        url: "{{ url('/get/petugas/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              $('#petugas_id').append('<option value="' + row.id + '">' + row.name + '</option>');
            })
        }
    });

    //Wilayah Kerja
    $.ajax({
        url: "{{ url('/get/wilayah/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              $('#wilayah_kerja_id').append('<option value="' + row.id + '">' + row.nama_daerah + '</option>');
            })
        }
    });
    
      table = $("#data-width").DataTable({
        searching: true,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
          },
          {
            data: "nama_petugas",
            className: "text-left",
          },
          {
            data: "wilayah_kerja",
            className: "text-left",
          },
          {
            data: "tanaman",
            className: "text-left",
          },
          {
            data: "jenis_opt",
            className: "text-left",
          },
          {
            data: "periode",
            className: "text-left",
          },
          {
            data: "luas_terserang",
            className: "text-left", render: function(data){return data +' ha';}
          },
          {
            data: "luas_pengendalian",
            className: "text-left", render: function(data){return data +' ha';}
          },
          {
            data: "status",
            className: "text-center",
            render: function(data){
              if(data == 'Menunggu'){ icon = 'check';}else{icon = 'edit';}
              return data;
            }
          },
          {
            data: "id",
            className: "text-center",
            render: function (data, type, row) {
              return '<button type="button" class="btn btn-primary btn-show" data-id="' + data +'"><i class="fa fa-eye"></i> </button>\
                  <button type="button" class="btn btn-success btn-'+icon+'" data-id="' + data +'"><i class="fa fa-'+icon+'"></i> </button>';
            },
          },
        ],
      });
  });
    
</script>
<script>
  
  $("body").on("click", ".btn-show", function () {
    var Id = $(this).attr("data-id");
    var url = "{{ route('kordinator.laporan.show', ':id') }}".replace(':id', Id);
    window.location.href = url;
  })

  $("body").on("click", ".btn-edit", function () {
    var Id = $(this).attr("data-id");
    
    find_data(Id);
    jQuery("#verifyForm").attr("action", "{{ url ($page) }}/verifikasi/"+Id);
    jQuery("#verifyModal").modal("toggle");
  })
  $("body").on("click", ".btn-check", function () {
    var Id = $(this).attr("data-id");
    
    jQuery("#verifyForm input[name=laporan_id]").val(Id);
    kosongkan();
    jQuery("#verifyForm").attr("action", "{{ url ($page) }}/verifikasi/"+Id);
    jQuery("#verifyModal").modal("toggle");
  })
  
  function kosongkan() {
    jQuery("#verifyForm textarea[name=catatan]").val("");
    jQuery("#verifyForm select[name=status]").val("menunggu");
  }

  function find_data(id){
      $.ajax({
          url: '{{ url("$page") }}/find/'+id,
          type: "GET",
          cache: false,
          dataType: 'json',
          success: function (dataResult) { 
              console.log(dataResult);
              set_value(dataResult);
              console.log('Edit Data :', dataResult);
          }
      });
  }
  
  function set_value(value) {
    jQuery("#verifyForm input[name=laporan_id]").val(value.laporan_id);
    jQuery("#verifyForm textarea[name=catatan]").val(value.catatan);
    jQuery("#verifyForm select[name=status]").val(value.status);
  }
</script>
@endsection