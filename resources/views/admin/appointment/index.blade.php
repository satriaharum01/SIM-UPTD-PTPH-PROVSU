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
      <div class="border-bottom d-flex justify-content-end mb-3 pb-2 tile-body">
        <button type="button" class="btn btn-primary btn-add pull-right">
          <i class="fa fa-plus"></i> Tambah Data
        </button>
      </div>
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
          <form action="#" method="POST" id="compose-form" class="form-horizontal" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Pasien</label>
                      <div class="col-sm-6">
                        <select name="patient_id" id="patient_id" class="form-control" required>
                          <option value="0" selected disabled hidden>-- Pilih</option>
                        </select>
                      </div>
                      <button type="button" class="btn btn-primary col-md-1" data-bs-target="#data-modal-pasien" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-search"></i> </button>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Dokter</label>
                      <div class="col-sm-8">
                        <select name="doctor_id" id="doctor_id" class="form-control" required>
                          <option value="0" selected disabled >-- Pilih</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Tanggal</label>
                      <div class="col-sm-8">
                        <input type="date" name="appointment_date" class="form-control">
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Waktu</label>
                      <div class="col-sm-8">
                        <input type="time" name="appointment_time" class="form-control">
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Status</label>
                      <div class="col-sm-8">
                        <select name="status" class="form-control" required>
                          <option value="0" selected disabled>-- Pilih</option>
                          <option value="Pending">Pending</option>
                          <option value="Completed">Completed</option>
                          <option value="Canceled">Canceled</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Catatan</label>
                      <div class="col-sm-8">
                        <textarea name="notes" class="form-control"></textarea>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
          </form>
    </div>
  </div>
</div>
<!--- END MODAL DATA --->
@include('template.modal.pasien')
@endsection
@section('custom_script')
<script>
  let dokter;
  let pasien;
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
  function get_dokter(){
    $.ajax({
          url: '{{ url("get/data/dokter") }}',
          type: "GET",
          cache: false,
          dataType: 'json',
          success: function (dataResult) { 
              var binding = dataResult.data;
              $.each(binding, function(index, row) {
                  $('#doctor_id').append('<option  value="' + row.id + '">' + row.name + ' </option>');
              })
          }
    });
  }
  
  function get_pasien(){
    $.ajax({
          url: '{{ url("get/data/pasien") }}',
          type: "GET",
          cache: false,
          dataType: 'json',
          success: function (dataResult) { 
              var binding = dataResult.data;
              $.each(binding, function(index, row) {
                  $('#patient_id').append('<option hidden value="' + row.id + '">' + row.name + ' </option>');
              })
          }
    });
  }
  $(function () {
    get_dokter();
    get_pasien();
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
                '<button type="button" class="btn btn-success btn-edit" data-id="' + data +'"><i class="fa fa-edit"></i> </button>\
                <a class="btn btn-danger btn-hapus" data-id="' + data +'" data-handler="data" href="delete/'+data +'">\
                <i class="fa fa-trash"></i> </a> \
					      <form id="delete-form-' +data +'-data" action="{{ url ($page) }}/delete/'+data+'" method="GET" style="display: none;">\
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

  $("body").on("click", ".btn-edit", function () {
    var Id = jQuery(this).attr("data-id");
    find_data(Id);

    jQuery("#compose-form").attr("action", '{{ url($page)}}/update/' + Id);
    jQuery("#compose .modal-title").html("Update {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-simpan", function () {
    Swal.fire("Data Disimpan!", "", "success");
  });

  function kosongkan() {
    jQuery("#compose-form select[name=patient_id]").val(0);
    jQuery("#compose-form select[name=doctor_id]").val(0);
    jQuery("#compose-form input[name=appointment_date]").val("");
    jQuery("#compose-form input[name=appointment_time]").val("");
    jQuery("#compose-form select[name=status]").val(0);
    jQuery("#compose-form textarea[name=notes]").val("");
  }
  
  function set_value(value) {
    jQuery("#compose-form select[name=patient_id]").val(value.patient_id);
    jQuery("#compose-form select[name=doctor_id]").val(value.doctor_id);
    jQuery("#compose-form input[name=appointment_date]").val(value.appointment_date);
    jQuery("#compose-form input[name=appointment_time]").val(value.appointment_time);
    jQuery("#compose-form select[name=status]").val(value.status);
    jQuery("#compose-form textarea[name=notes]").val(value.notes);
  }
  
  $("body").on("click", ".btn-pilih", function () {
    var Id = jQuery(this).attr("data-id");
    jQuery("#compose-form select[name=patient_id]").val(Id);
    jQuery("#data-modal-pasien").modal("hide");
    jQuery("#compose").modal("toggle");
  });
</script>
@include('template.modal.pasienjs')
@endsection