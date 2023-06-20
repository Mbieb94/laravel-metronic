<?php

namespace App\Library;

class Operator {
    public static function in ($model, $name, $value) {
        $array = is_string($value) ? json_decode($value, true) : $value;
        if(empty($array)) return $model;
        return $model->whereIn($name, $array);
    }
    
    public static function or ($model, $name, $value) {
        
    }

    public static function like ($model, $name, $value) {
        return $model->where($name, 'like', '%' . $value . '%');
    }

    public static function gte ($model, $name, $value) {
        $value = is_string($value) ? (int) $value : $value;
        return $model->where($name, '>=', $value);
    }

    public static function lte ($model, $name, $value) {
        $value = is_string($value) ? (int) $value : $value;
        return $model->where($name, '<=', $value);
    }
}