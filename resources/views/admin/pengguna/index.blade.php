@extends('template.master')
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <button class="btn btn-primary btn-add pull-right" data-toggle="modal" data-target="#compose"><i class="mdi mdi-plus"></i> Tambah Data</button>
        <h3 class="card-title">{{$title}}</h3>
        <div class="table-responsive pt-5">
          <table class="display table table-bordered table-hover" id="data-width" width="100%">
            <thead class="text-center">
              <tr>
                <th width="7%">No</th>
                <th width="20%">Nama Pengguna</th>
                <th width="25%">Email</th>
                <th>Hak Akses</th>
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

 
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
                
                  <div class="form-group row">
                      <label class="col-sm-4">Nama Pengguna</label>
                      <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" placeholder="Nama Pengguna">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Email</label>
                      <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" placeholder="Email Pengguna">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="password" class="form-control">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-sm-4">Hak Akses</label>
                      <div class="col-sm-8">
                        <select name="level" class="form-control p-0" required>
                          <option value="0" selected disabled>-- Pilih Hak Akses</option>
                          <option value="Admin">Administrator</option>
                          <option value="Pegawai">Pegawai</option>
                          <option value="Pembeli">Pembeli</option>
                        </select>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>
<!--- END MODAL DATA --->
@endsection

@section('custom_script')

<script>
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
                    data: 'name',
                    className: 'text-center'
                },
                {
                    data: 'email',
                    className: 'text-center'
                },
                {
                    data: 'level',
                    className: 'text-center'
                },
                {
                    data: 'id',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> </button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="pengguna" href="<?= url($page.'/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> </a> \
					              <form id="delete-form-' + data + '-pengguna" action="<?= url($page.'/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });

    });

    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/save');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
                    
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#compose-form input[name=name]").val(row.name);
                    jQuery("#compose-form input[name=email]").val(row.email);
                    jQuery("#compose-form select[name=level]").val(row.level);
                    jQuery("#compose-form input[name=password]").val("");
                    jQuery("#compose-form input[name=password]").attr("placeholder","Kosongkan jika tidak diubah !");
                    jQuery("#compose-form input[name=password]").attr("required",false);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
        
    function kosongkan()
    {
      
      jQuery("#compose-form input[name=name]").val("");
      jQuery("#compose-form input[name=email]").val("");
      jQuery("#compose-form select[name=level]").val(0);
      jQuery("#compose-form input[name=password]").val("");
      jQuery("#compose-form input[name=password]").attr("placeholder","Buat Password Baru !");
      jQuery("#compose-form input[name=password]").attr("required",true);
    }
    
</script>
@endSection