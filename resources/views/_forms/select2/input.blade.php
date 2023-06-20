<div class="col-lg-9 col-xl-{{ isset($data['column']) ? $data['column'] : '9' }}">
    <select
        class="form-select select2ajax"
        data-model="{{ $data['options']['model'] }}"
        data-key="{{ $data['options']['key'] }}"
        data-display="{{ $data['options']['display'] }}"
        name="{{ __($data['name']) }}"
    >
    @if(isset($data['value']))
    @php
        $value = "";
        $display = explode('|', $data['options']['display']);
        for($i = 0; $i < count($display); $i++) {
            if($i > 0) $value .= " - ";
            $value .= $data['value'][$display[$i]];
        }
    @endphp
    <option value="{{ $data['value'][$data['options']['key']] }}" selected>{{ $value }}</option>
    @endif
    </select>
    @if ($errors->has($data['name']))
    <small id="form-error-{{$data['name']}}" class="form-text text-danger">
        {{ $errors->first($data['name']) }}
    </small>
    @endif
</div>
