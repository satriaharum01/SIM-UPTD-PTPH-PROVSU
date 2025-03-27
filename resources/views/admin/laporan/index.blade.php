@extends('backend.app')

<?php
use App\Http\helpers\Formula;

?>


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
                                  <th class="text-primary text-center align-content-around" rowspan="2">Kabupaten</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Komoditas</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Periode</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">OPT</th>
                                  <th class="text-primary text-center" colspan="5">Luas Terserang</th>
                                </tr>
                                <tr>
                                  <th class="text-primary">R</th>
                                  <th class="text-primary">S</th>
                                  <th class="text-primary">B</th>
                                  <th class="text-primary">P</th>
                                  <th class="text-primary">J</th>
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
                    <label class="form-label">Jenis OPT</label>
                    <select value="0" class="form-control" name="opt_id" id="opt_id">
                        <option value="0">Semua OPT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kabupaten</label>
                    <select value="0" class="form-control" name="kabupaten_id" id="kabupaten_id">
                        <option value="0">Semua Kabupaten</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Periode</label>
                    <select value="0" class="form-control" name="periode" id="periode">
                      <option value="">Semua Periode</option>
                      @foreach(Formula::$periode as $row => $val)
                          <option value="{{$row}}">{{ucfirst($val)}}</option>
                      @endforeach
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
@endsection
@section('js')
<script>
  
  $("body").on("click", ".btn-terapkan", function () {
    let formData = $("#filterForm").serialize();
    let url = `{{ Request::url() }}/filter?${formData}`;
    table.ajax.url(url).load();
  })

  $(function () {
    
    //OPT
    $.ajax({
        url: "{{ url('/get/opt/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(opt_id === row.id)
              {
                $('#opt_id').append('<option value="' + row.id + '" selected>' + row.nama_opt + '</option>');
              }else{
                $('#opt_id').append('<option value="' + row.id + '">' + row.nama_opt + '</option>');
              }
            })
        }
    });
    
    //Kabupaten
    $.ajax({
        url: "{{ url('/get/kabupaten/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
                $('#kabupaten_id').append('<option value="' + row.id + '">' + row.nama_kabupaten + '</option>');
            })
        }
    });
    
    table = $("#data-width").DataTable({
        searching: false,
        paging: false,
        lengthChange: false,
        info: false,
        ordering: false,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "nama_kabupaten",
            className: "text-center",
          },
          {
            data: "tanaman",
            className: "text-center",
          },
          {
            data: "periode",
            className: "text-center",
          },
          {
            data: "jenis_opt",
            className: "text-center",
          },
          {
            data: "r_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "s_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "b_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "p_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "j_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
        ],
      });
    });
    
</script>
@endsection