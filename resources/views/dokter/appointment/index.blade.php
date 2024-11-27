@extends('template.master')
@section('content')
<!-- awal isi halaman -->
<div class="app-title">
  <div>
    <h1><i class="bi bi-table"></i> {{$title}}</h1>
  </div>
  <ul class="app-breadcrumb breadcrumb side">
    <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
    <li class="breadcrumb-item active"><a href="#">{{$title}}</a></li>
  </ul>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered" id="data-width" width="100%">
            <thead>
              <tr>
                <th style="text-align: center" width="10%">No</th>
                <th>Waktu</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Status</th>
                <th style="text-align: center" width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- akhir isi halaman -->
@endsection
@section('modal')


<!-- ============ MODAL DATA  =============== -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="justify-content-center modal-header">
              <center><b>
              <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4></b></center>    
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <label>Catatan</label>
                  <div>
                    <textarea name="notes" class="form-control"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
    </div>
  </div>
</div>
<!--- END MODAL DATA --->
@endsection
@section('custom_script')
<script>
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
  $(function () {
    let cls;
    table = $("#data-width").DataTable({
      searching: false,
      ajax: '{{ url("$page/json") }}',
      columns: [
        {
          data: "DT_RowIndex",
          name: "DT_RowIndex",
          className: "text-center",
        },
        {
          data: "waktu",
          className: "text-center",
        },
        {
          data: "pasien",
          className: "text-center",
        },
        {
          data: "dokter",
          className: "text-center",
        },
        {
          data: "status",
          className: "text-center",render: function(data){
            if(data === 'Completed')
            {
              cls = 'btn-primary';
            }else if(data === 'Canceled'){
              cls = 'btn-danger';
            }else{
              cls = 'btn-warning';
            }
          return '<button type="button" class="btn '+cls+'">'+data+'</button>'
          }
        },
        {
          data: "id",
          className: "text-center",
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            return (
                '<button type="button" class="btn btn-primary btn-note" data-id="' + data +'"><i class="fa fa-comments"></i> </button>\
                <button type="button" class="btn btn-success btn-confirm" data-handler="data" data-id="' + data +'"><i class="fa fa-check"></i> </button>\
                <a class="btn btn-danger btn-reject" data-id="' + data +'" data-handler="data" href="reject/'+data +'">\
                <i class="fa fa-trash"></i> </a> \
					      <form id="reject-form-' +data +'-data" action="{{ url ($page) }}/reject/'+data+'" method="GET" style="display: none;">\
                </form>\
					      <form id="confirm-form-' +data +'-data" action="{{ url ($page) }}/confirm/'+data+'" method="GET" style="display: none;">\
                </form>'
            );
          },
        },
      ],
    });
  });

  //Button Trigger
  $("body").on("click", ".btn-add", function () {
    kosongkan();
    jQuery("#compose-form").attr("action", "{{ url ($page) }}/save");
    jQuery("#compose .modal-title").html("Tambah {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-note", function () {
    var Id = jQuery(this).attr("data-id");
    find_data(Id);
    jQuery("#compose .modal-title").html("Detail {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-simpan", function () {
    Swal.fire("Data Disimpan!", "", "success");
  });

  function kosongkan() {
    jQuery("#compose-form textarea[name=notes]").val("");
  }
  
  function set_value(value) {
    jQuery("#compose textarea[name=notes]").val(value.notes);
  }
</script>
@endsection