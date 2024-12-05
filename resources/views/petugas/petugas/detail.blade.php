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
                  <form id="compose-form" method="POST" enctype="multipart/form-data" action="{{url($action)}}">
                    @csrf
                    <div class="card-body row">
                          @foreach ($fieldTypes as $field => $type)
                              @include('models.forms', ['field' => $field, 'type' => $type, 'value' => old($field, $load->$field ?? '')])
                          @endforeach
                    </div>
                    <div class="card-footer">
                      <button type="reset" class="btn btn-danger btn-back" data-bs-dismiss="modal">Kembali</button>
                      <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                      <div class="pull-right">{{env('APP_NAME')}} - {{$title}}</div>
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
  
  var kabupaten_id = {{$load->kabupaten_id ?? 0}};
  var user_id = {{$load->user_id ?? 0}};
  var wilayah_kerja_id = {{$load->wilayah_kerja_id ?? 0}};
  
  $("body").on("click", ".btn-back", function () {
    window.location.href = "{{route('kordinator.petugas')}}";
  })
  $(function () {
    //Kabupaten
    $.ajax({
            url: "{{ url('/find/kabupaten/'.Auth::user()->kabupaten_id)}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                  $('#kabupaten_id').append('<option value="' + row.id + '" selected>' + row.nama_kabupaten + '</option>');
                })
            }
        });

    $.ajax({
            url: "{{ url('/get/users/Petugas Lapangan')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {  
                  $('#user_id').append('<option value="' + row.id + '">' + row.name + ' - ' + row.email + '</option>');
                })
            }
        });

        $.ajax({
            url: "{{ url('/get/wilayah/'.Auth::user()->kabupaten_id)}}",
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

        jQuery("#compose-form select[name=kabupaten_id]").val(kabupaten_id);
        jQuery("#compose-form select[name=user_id]").val(user_id);
        jQuery("#compose-form select[name=wilayah_kerja_id]").val(wilayah_kerja_id);
  
  })
</script>
@endsection