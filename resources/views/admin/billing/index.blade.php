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
                <th>Appointment</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Metode Bayar</th>
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
                      <label class="col-sm-4">Appointment:</label>
                      <div class="col-sm-6">
                          <input type="text" name="appointment_id" class="form-control" hidden/>
                          <input type="text" name="kode" class="bg-dark-subtle form-control" readonly/>
                      </div>
                      <button type="button" class="btn btn-primary col-md-1" data-bs-target="#data-modal-appointment" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-search"></i> </button>
                  
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Jumlah:</label>
                      <div class="col-sm-8">
                        <input type="number" name="total_amount" class="form-control" required/>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Status Pembayaran:</label>
                      <div class="col-sm-8">
                          <select name="payment_status" class="form-control" required>
                              <option value="" disabled selected>Pilih</option>
                              <option value="Pending">Pending</option>
                              <option value="Paid">Paid</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row mb-2">
                      <label class="col-sm-4">Metode Pembayaran:</label>
                      <div class="col-sm-8">
                          <select name="payment_method" class="form-control" required>
                              <option value="" disabled selected>Pilih</option>
                              <option value="Cash">Cash</option>
                              <option value="Credit Card">Credit Card</option>
                              <option value="Insurance">Insurance</option>
                          </select>
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

@include('template.modal.appointment')
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
      searching: true,
      ajax: '{{ url("$page/json") }}',
      columns: [
        {
          data: "DT_RowIndex",
          name: "DT_RowIndex",
          class: "text-center",
        },
        {
          data: "kode",
          class: "text-center",
        },
        {
          data: "jumlah",
          className: 'text-center', render: function(data){
              return '<div style="display: flex;flex-wrap: nowrap;align-content: center;justify-content: space-between;" class="px-2"><span>Rp. </span><span>'+number_format(data)+'</span></div>';
          }
        },
        {
          data: "payment_status",
          class: "text-center",render: function(data){
            if(data === 'Paid')
            {
              cls = 'btn-primary';
            }else{
              cls = 'btn-danger';
            }
          return '<button type="button" class="btn '+cls+'">'+data+'</button>'
          }
        },
        {
          data: "payment_method",
          class: "text-center",
        },
        {
          data: "id",
          class: "text-center",
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
    jQuery("#compose-form input[name=appointment_id ]").val("");
    jQuery("#compose-form input[name=kode]").val("");
    jQuery("#compose-form input[name=total_amount]").val("");
    jQuery("#compose-form select[name=payment_status]").val("");
    jQuery("#compose-form select[name=payment_method]").val("");
  }
  
  function set_value(value) {
    jQuery("#compose-form input[name=appointment_id ]").val(value.appointment_id);
    jQuery("#compose-form input[name=kode]").val(value.kode);
    jQuery("#compose-form input[name=total_amount]").val(value.total_amount);
    jQuery("#compose-form select[name=payment_status]").val(value.payment_status);
    jQuery("#compose-form select[name=payment_method]").val(value.payment_method);
  }
  
  $("body").on("click", ".btn-pilih", function () {
    var Id = jQuery(this).attr("data-id");
    var kode = jQuery(this).attr("data-kode");
    jQuery("#compose-form input[name=kode]").val(kode);
    jQuery("#compose-form input[name=appointment_id]").val(Id);
    jQuery("#data-modal-appointment").modal("hide");
    jQuery("#compose").modal("toggle");
  });
</script>
@include('template.modal.appointmentjs')
@endsection