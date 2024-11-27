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
        <h2><i class="bi bi-people"></i> Data Rekam Medis Pasien  {{Auth::user()->name}}</h2>
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
                <th>Pasien</th>
                <th>Tanggal Kunjungan</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
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
                      <label class="col-sm-4">Pasien :</label>
                      <div class="col-sm-6">
                          <input type="text" name="patient_id" class="form-control" hidden/>
                          <input type="text" name="pasien" class="bg-dark-subtle form-control" readonly/>
                      </div>
                      <button type="button" class="btn btn-primary col-md-1" data-bs-target="#data-modal-pasien" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-search"></i> </button>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Tanggal Kunjungan</label>
                      <div class="col-sm-8">
                        <input type="date" name="visit_date" class="form-control" required>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Diagnosis</label>
                      <div class="col-sm-8">
                        <input type="text" name="diagnosis" class="form-control" required>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Treatment</label>
                      <div class="col-sm-8">
                          <textarea name="treatment" class="form-control" required></textarea>
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
@include('template.modal.pasien')
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
            }
        });
  }

  $(function() {
      table = $('#data-width').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          ajax: {
              url: '{{url("$page/json")}}'
          },
          columns: [{
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex',
                  className: 'text-center',
                  orderable: false,
                  searchable: false
              },
              {
                  data: 'pasien',
                  className: 'text-center'
              },
              {
                  data: 'waktu',
                  className: 'text-center'
              },
              {
                  data: 'diagnosis',
                  className: 'text-center'
              },
              {
                  data: 'treatment',
                  className: 'text-center'
              },
              {
                  data: 'id',
                  className: 'text-center',
                  orderable: false,
                  searchable: false,
                  render: function(data, type, row) {
                      return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                      <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="medical" href="<?= url($page.'/delete') ?>/' + data + '">\
                      <i class="fa fa-trash"></i> </a> \
				              <form id="delete-form-' + data + '-medical" action="<?= url($page.'/delete') ?>/' + data + '" \
                      method="GET" style="display: none;"> \
                      </form>'
                  }
              },
          ]
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
    jQuery("#compose-form").attr("action", "{{ url ($page) }}/update/"+Id);
    jQuery("#compose .modal-title").html("Update {{$title}}");
    jQuery("#compose").modal("toggle");
  });

  $("body").on("click", ".btn-simpan", function () {
    Swal.fire("Data Disimpan!", "", "success");
  });

  function kosongkan() {
    jQuery("#compose-form input[name=patient_id]").val("");
    jQuery("#compose-form input[name=pasien]").val("");
    jQuery("#compose-form input[name=visit_date]").val("");
    jQuery("#compose-form input[name=diagnosis]").val("");
    jQuery("#compose-form textarea[name=treatment]").val("");
  }
  
  function set_value(value) {
    jQuery("#compose-form input[name=patient_id]").val(value.patient_id);
    jQuery("#compose-form input[name=pasien]").val(value.pasien);
    jQuery("#compose-form input[name=visit_date]").val(value.visit_date);
    jQuery("#compose-form input[name=diagnosis]").val(value.diagnosis);
    jQuery("#compose-form textarea[name=treatment]").val(value.treatment);
  }
  
  $("body").on("click", ".btn-pilih", function () {
    var Id = jQuery(this).attr("data-id");
    var pasien = jQuery(this).attr("data-pasien");
    jQuery("#compose-form input[name=patient_id]").val(Id);
    jQuery("#compose-form input[name=pasien]").val(pasien);
    jQuery("#data-modal-pasien").modal("hide");
    jQuery("#compose").modal("toggle");
  });
</script>
@include('template.modal.pasienjs')
@endSection