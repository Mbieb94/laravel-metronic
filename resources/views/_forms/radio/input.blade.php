<div class="col-lg-9 col-xl-{{ isset($data['column']) ? $data['column'] : '9' }}">
    
    @foreach($data['options'] as $key => $name)
        <div class="form-check form-check-custom form-check-solid mb-3">
            <input name="{{ $data['name'] }}" class="form-check-input" type="radio" value="{{ $key }}" id="flexCheckboxSm" {{ isset($data['value']) && $data['value'] == $key || old($data['name']) == $key ? 'checked' : '' }} />
            <label class="form-check-label" for="flexCheckboxSm">
                {{ $name }}
            </label>
        </div>
    @endforeach
    @if ($errors->has($data['name']))
    <small id="form-error-{{$data['name']}}" class="form-text text-danger">
        {{ $errors->first($data['name']) }}
    </small>
    @endif
</div>
