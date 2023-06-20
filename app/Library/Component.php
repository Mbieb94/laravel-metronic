<?php

namespace App\Library;

class Component {
    public static function Checkbox ($value, $option = []) {
        return $value;
    }

    public static function Text ($value, $option = []) {
        return $value;
    }

    public static function Thumbnail ($value, $option = []) {
        $file = asset('assets/media/avatars/blank.png');
        if (!empty($value)) {
            $image = json_decode($value, true);
            $file = url('storage/avatar/', $image['filename']);
        }

        $data = ['file' => $file];
        return view('_forms.thumbnail.plain', compact('data'))->render();
    }

    public static function Date ($value, $option = []) {
        return $value;
    }

    public static function Editor ($value, $option = []) {
        return $value;
    }

    public static function Email ($value, $option = []) {
        return $value;
    }

    public static function File ($value, $option = []) {
        return $value;
    }

    public static function Fileupload ($value, $option = []) {
        return $value;
    }

    public static function Multipleupload ($value, $option = []) {
        return $value;
    }

    public static function Multiselect2 ($value, $option = []) {
        if(empty($value)) return;

        $val = json_decode($value, true);
        $html = '';
        for($i=0; $i < count($val); $i++) {
            $html .= '<div class="badge badge-light-success fw-bold">'. $val[$i] .'</div>';
        }

        return $html;
    }

    public static function Password ($value, $option = []) {
        return '**********************************';
    }

    public static function Radio ($value, $option = []) {
        return $value;
    }

    public static function Select ($value, $option = []) {
        return $value;
    }

    public static function Select2 ($value, $option = []) {
        if(empty($value)) return '';
        $display = explode('|', $option['options']['display']);

        $displayName = '';
        for($i=0; $i < count($display); $i++) {
            $concat = $i > 0 ? ' - ' : '';
            $displayName .= $concat . $value[$display[$i]];
        }

        return $displayName;
    }

    public static function Sysparam ($value, $option = []) {
        return empty($value) ? '' : $value['value'];
    }

    public static function Multiselect2sys ($value, $option = []) {
        if(empty($value)) return;

        $val = json_decode($value, true);
        $html = '';
        for($i=0; $i < count($val); $i++) {
            $html .= '<div class="badge badge-light-success fw-bold">'. $val[$i] .'</div>';
        }

        return $html;
    }

    public static function Textarea ($value, $option = []) {
        return $value;
    }

    public static function Number ($value, $option = []) {
        return $value;
    }
}