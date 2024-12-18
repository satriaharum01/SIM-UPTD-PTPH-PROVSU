@extends('backend.app')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                  </div>
                  <form class="" method="POST" enctype="multipart/form-data" action="{{url($action)}}">
                    @csrf
                    <div class="card-body row">
                          @foreach ($fieldTypes as $field => $type)
                              @include('models.forms', ['field' => $field, 'type' => $type, 'value' => old($field, $load->$field ?? '')])
                          @endforeach
                    </div>
                    <div class="card-footer">
                      <button type="reset" class="btn btn-danger btn-back" data-bs-dismiss="modal">Kembali</button>
                      <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                      <div class="float-right">{{env('APP_NAME')}} - {{$title}}</div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
  
  var kecamatan_id = {{$load->kecamatan_id ?? 0}};
  var wilayah_kerja_id = {{$load->wilayah_kerja_id ?? 0}};
  var tanaman_id = {{$load->tanaman_id ?? 0}};
  var opt_id = {{$load->opt_id ?? 0}};
  $("body").on("click", ".btn-back", function () {
    window.location.href = "{{route('petugas.laporan')}}";
  })

</script>

<script>
  
$(function () {
  
    //Petugas
    $.ajax({
        url: "{{ url('/find/petugas/'.Auth::user()->id)}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              $('#petugas_id').append('<option value="' + row.id + '" selected>' + row.name + '</option>');
            })
        }
    });
    
    //Tanaman
    $.ajax({
        url: "{{ url('/get/tanaman/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(tanaman_id === row.id)
              {
                $('#tanaman_id').append('<option value="' + row.id + '" selected>' + row.nama_tanaman + '</option>');
              }else{
                $('#tanaman_id').append('<option value="' + row.id + '">' + row.nama_tanaman + '</option>');
              }
            })
        }
    });

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

    //Wilayah Kerja
    $.ajax({
        url: "{{ url('/get/wilayah_kerja/'.Auth::user()->kabupaten_id)}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(wilayah_kerja_id === row.id)
              {
                $('#wilayah_kerja_id').append('<option value="' + row.id + '" selected>' + row.nama_daerah + '</option>');
              }else{
                $('#wilayah_kerja_id').append('<option value="' + row.id + '">' + row.nama_daerah + '</option>');
              }
            })
        }
    });
    
  })
</script>
@endsection