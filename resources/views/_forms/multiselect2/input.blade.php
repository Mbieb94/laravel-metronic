<div class="col-lg-9 col-xl-{{ isset($data['column']) ? $data['column'] : '9' }}">
    <select
        class="form-select select2ajax"
        data-model="{{ $data['options']['model'] }}"
        data-key="{{ $data['options']['key'] }}"
        data-display="{{ $data['options']['display'] }}"
        name="{{ $data['name'] }}"
        multiple
    >
    @if(!empty($data['value']))
        @foreach($data['value'] as $value)
        <option value="{{ $value }}" selected>{{ $value }}</option>
        @endforeach
    @endif
    </select>
    @if ($errors->has($data['name']))
    <small id="form-error-{{$data['name']}}" class="form-text text-danger">
        {{ $errors->first($data['name']) }}
    </small>
    @endif
</div>
