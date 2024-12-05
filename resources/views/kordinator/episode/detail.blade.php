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
                  <div class="card-body">
                    <form class="row" method="POST" enctype="multipart/form-data">  
                      <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label class="form-label">Anime</label>
                          <img src="{{ asset('assets/img/' . ($anime->cover ?? 'default.jpg')) }}" alt="Anime Cover" class="cover__anime">
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-9">
                        <div class="form-group">
                          <label class="form-label">Anime</label>
                          <select class="form-control" name="anime_id" id="anime" >
                            <option  value="" selected disabled>--Pilih Anime</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Episode Number</label>
                          <input class="form-control" name="episode_number" type="text" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Episode Title</label>
                          <input class="form-control" name="title" type="text" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Url</label>
                          <input class="form-control" name="url" type="text" />
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer">
                     {{env('APP_NAME')}} - {{$title}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection