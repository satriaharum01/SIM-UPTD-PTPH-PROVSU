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
                    
                    </div>
                  </div>
                  <div class="card-body " id="card-main">
                      <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary">Kecamatan</th>
                                <th class="text-primary">Wilayah Kerja</th>
                                <th class="text-primary">Tanaman</th>
                                <th class="text-primary">Jenis OPT</th>
                                <th class="text-primary">Tanggal</th>
                                <th class="text-primary">Tingkat Kerusakan</th>
                                <th class="text-primary">Luas Serangan</th>
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
@section('js')
<script>
  $(function () {
      table = $("#data-width").DataTable({
        searching: true,
        ajax: '{{Request::url() }}/json',
        columns: [
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
            data: "tanggal_laporan",
            className: "text-left",
          },
          {
            data: "tingkat_kerusakan",
            className: "text-left",
          },
          {
            data: "luas_serangan",
            className: "text-left",
          },
        ],
      });
    });
    
</script>
@endsection