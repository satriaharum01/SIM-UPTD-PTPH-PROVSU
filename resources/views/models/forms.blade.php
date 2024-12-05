
<div class="col-md-6 col-lg-3">
    <div class="form-group">
        <label class="form-label">{{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</label>
        @if ($type == 'textarea')
        <textarea class="form-control" name="{{$field}}" cols="30" rows="3">{{$value}}</textarea>
        @elseif($type == 'select')
        <select class="form-control" name="{{$field}}" id="{{$field}}">
            <option value="0" selected disabled>-- Pilih {{ucwords(str_replace(['_id', '_'], [' ', ' '], $field))}}</option>
        </select>
        @else
        <input type="{{$type}}" class="form-control" name="{{$field}}" value="{{$value}}"/>
        @endif
    </div>
</div>