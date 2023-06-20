@php
$value = "";
$display = explode('|', $data['options']['display']);
if(isset($data['value'])) {
    for($i = 0; $i < count($display); $i++) {
        if($i > 0) $value .= " - ";
        $value .= $data['value'][$display[$i]];
    }
}   
@endphp

<div class="col-lg-9 col-xl-{{ isset($data['column']) ? $data['column'] : '9' }}">
    <input
        type="text"
        class="form-control"
        placeholder="{{ __(isset($data['placeholder'])) ? __($data['placeholder']) : __($data['label']) }}"
        value="{{ $value }}"
        readonly
    >
</div>