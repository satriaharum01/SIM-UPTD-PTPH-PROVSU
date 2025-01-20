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
                      <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                  </div>
                  <div class="card-body " id="card-main">
                      <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary">Status</th>
                                <th class="text-primary">Kecamatan</th>
                                <th class="text-primary">Wilayah Kerja</th>
                                <th class="text-primary">Tanaman</th>
                                <th class="text-primary">Jenis OPT</th>
                                <th class="text-primary">Periode</th>
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
@endsection
@section('modal')
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header flex-row">
                <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Verifikasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            <form action="" method="post" id="verifyForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">ID Laporan</label>
                    <input type="text" class="form-control" name="laporan_id" value="" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Verikator</label>
                    <input type="text" class="form-control d-none" name="verifikator_id" readonly/>
                    <input readonly type="text" class="form-control" name="verifikator_name" />
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Verifikasi</label>
                    <input readonly type="date" class="form-control" name="tanggal_verifikasi" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select readonly class="form-control" name="status" id="status">
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea readonly class="form-control" name="catatan" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
  function btnFind(status) {
    if (status === 'diterima') {
        return 'btn-success';
    } else if (status === 'ditolak') {
        return 'btn-danger';
    } else {
        return 'btn-primary';
    }
}

  $(function () {
      table = $("#data-width").DataTable({
        searching: true,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: null, 
            name: 'status',
            className: 'text-center',
            render: function (data, type, row) {
                let status = data.status || 'Menunggu';
                let verificationId = data.id || '0';
                let buttonClass = btnFind(status);
                return `<button class="btn ${buttonClass} btn-eye" data-id="${verificationId}">${status.toUpperCase()}</button>`;
            },
        },
          {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
          },
          {
            data: "nama_kecamatan",
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
            data: "id",
            className: "text-center",
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
              return (
                  '<button type="button" class="btn btn-primary btn-show" data-id="' + data +'"><i class="fa fa-eye"></i> </button>\
                  <button type="button" class="btn btn-success btn-edit" data-id="' + data +'"><i class="fa fa-edit"></i> </button>\
                  <a class="btn btn-danger btn-hapus" data-id="' + data +'" data-handler="data" href="delete/'+data +'">\
                  <i class="fa fa-trash"></i> </a> \
				  	      <form id="delete-form-' +data +'-data" action="{{ Request::url()  }}/delete/'+data+'" method="GET" style="display: none;">\
                  </form>'
              );
            },
          },
        ],
      });
    });
    
  $("body").on("click", ".btn-add", function () {
    window.location.href = "{{route('petugas.laporan.new')}}";
  })

  $("body").on("click", ".btn-edit", function () {
    var Id = $(this).attr("data-id");
    var url = "{{ route('petugas.laporan.edit', ':id') }}".replace(':id', Id);
    window.location.href = url;
  })

  $("body").on("click", ".btn-show", function () {
    var Id = $(this).attr("data-id");
    var url = "{{ route('petugas.laporan.show', ':id') }}".replace(':id', Id);
    window.location.href = url;
  })
  
  $("body").on("click", ".btn-eye", function () {
    var Id = $(this).attr("data-id");
    kosongkan();
    find_data(Id);
  })
  function find_data(id){
      $.ajax({
          url: '{{ Request::url() }}/verifikasi/'+id,
          type: "GET",
          cache: false,
          dataType: 'json',
          success: function (dataResult) { 
            if(dataResult != null)
            {
              set_value(dataResult);
              jQuery("#verifyModal").modal("toggle");
            }else{
              Swal.fire(
                    'Data Tidak Ditemukan!',
                    '',
                    'warning'
                );
            }
          }
      });
  }
  
  function set_value(value) {
    jQuery("#verifyForm input[name=laporan_id]").val(value.laporan_id);
    jQuery("#verifyForm input[name=verifikator_id]").val(value.verifikator_id);
    jQuery("#verifyForm input[name=verifikator_name]").val(value.verifikator_name);
    jQuery("#verifyForm input[name=tanggal_verifikasi]").val(value.tanggal_verifikasi);
    jQuery("#verifyForm textarea[name=catatan]").val(value.catatan);
    jQuery("#verifyForm select[name=status]").val(value.status);
  }
  function kosongkan()
  {
    jQuery("#verifyForm input[name=laporan_id]").val("");
    jQuery("#verifyForm input[name=verifikator_id]").val("");
    jQuery("#verifyForm input[name=verifikator_name]").val("");
    jQuery("#verifyForm input[name=tanggal_verifikasi]").val("");
    jQuery("#verifyForm textarea[name=catatan]").val("");
    jQuery("#verifyForm select[name=status]").val("");
  }
</script>
@endsection