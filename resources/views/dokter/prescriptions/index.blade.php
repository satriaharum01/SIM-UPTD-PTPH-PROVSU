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
      <div class="border-bottom d-flex justify-content-between mb-3 pb-2 tile-body">
        <h2><i class="bi bi-people"></i> Data Resep/Obat Pasien  {{Auth::user()->name}}</h2>
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
                <th>Appointment Kode</th>
                <th>Pasien</th>
                <th>Pengobatan</th>
                <th>Dosis</th>
                <th>Instruksi</th>
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
                      <label class="col-sm-4">Appointment Kode:</label>
                      <div class="col-sm-6">
                          <input type="text" name="appointment_id" class="form-control" hidden/>
                          <input type="text" name="kode" class="bg-dark-subtle form-control" readonly/>
                      </div>
                      <button type="button" class="btn btn-primary col-md-1" data-bs-target="#data-modal-appointment" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-search"></i> </button>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Pasien:</label>
                      <div class="col-sm-8">
                          <input type="text" name="pasien" class="bg-dark-subtle form-control" readonly/>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Pengobatan:</label>
                      <div class="col-sm-8">
                          <input type="text" name="medication" class="form-control" required/>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Dosis:</label>
                      <div class="col-sm-8">
                          <input type="text" name="dosage" class="form-control" required/>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Instruksi:</label>
                      <div class="col-sm-8">
                          <input type="text" name="instructions" class="form-control" required/>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
              </div>
          </form>
    </div>
  </div>
</div>
<!--- END MODAL DATA --->
@include('template.modal.doctorappointment')
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

    table = $("#data-width").DataTable({
      searching: true,
      ajax: '{{ url("$page/json") }}',
      columns: [
        {
          data: "DT_RowIndex",
          name: "DT_RowIndex",
          className: "text-center",
        },
        {
          data: "kode",
          class: "text-center",
        },
        {
          data: "pasien",
          class: "text-center",
        },
        {
          data: "medication",
          class: "text-center",
        },
        {
          data: "dosage",
          class: "text-center",
        },
        {
          data: "instructions",
          class: "text-justify",
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
    jQuery("#compose-form").attr("action", "{{ url ('dokter/prescriptions') }}/save");
    jQuery("#compose .modal-title").html("Tambah {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-edit", function () {
    var Id = jQuery(this).attr("data-id");
    find_data(Id);

    jQuery("#compose-form").attr("action", '{{ url ("dokter/prescriptions") }}/update/' + Id);
    jQuery("#compose .modal-title").html("Update {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-simpan", function () {
    Swal.fire("Data Disimpan!", "", "success");
  });

  function kosongkan() {
    jQuery("#compose-form input[name=appointment_id]").val("");
    jQuery("#compose-form input[name=kode]").val("");
    jQuery("#compose-form input[name=pasien]").val("");
    jQuery("#compose-form input[name=medication]").val("");
    jQuery("#compose-form input[name=dosage]").val("");
    jQuery("#compose-form input[name=instructions]").val("");
  }
  
  function set_value(value) {
    jQuery("#compose-form input[name=appointment_id]").val(value.appointment_id);
    jQuery("#compose-form input[name=kode]").val(value.kode);
    jQuery("#compose-form input[name=pasien]").val(value.pasien);
    jQuery("#compose-form input[name=medication]").val(value.medication);
    jQuery("#compose-form input[name=dosage]").val(value.dosage);
    jQuery("#compose-form input[name=instructions]").val(value.instructions);
  }
  
  $("body").on("click", ".btn-pilih", function () {
    var Id = jQuery(this).attr("data-id");
    var kode = jQuery(this).attr("data-kode");
    var pasien = jQuery(this).attr("data-pasien");
    jQuery("#compose-form input[name=kode]").val(kode);
    jQuery("#compose-form input[name=appointment_id]").val(Id);
    jQuery("#compose-form input[name=pasien]").val(pasien);
    jQuery("#data-modal-appointment").modal("hide");
    jQuery("#compose").modal("toggle");
  });
</script>
@include('template.modal.doctorappointmentjs')
@endsection