<div class="col-lg-9 col-xl-{{ isset($data['column']) ? $data['column'] : '9' }} select-multiple">
    <input type="hidden" name="{{ $data['name'] }}">
    <select
        class="form-select select2ajax select2multiple"
        data-model="{{ $data['options']['model'] }}"
        data-key="{{ $data['options']['key'] }}"
        data-display="{{ $data['options']['display'] }}"
        multiple
    >
    </select>
    @if ($errors->has($data['name']))
    <small id="form-error-{{$data['name']}}" class="form-text text-danger">
        {{ $errors->first($data['name']) }}
    </small>
    @endif
</div>
