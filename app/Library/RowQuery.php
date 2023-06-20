<?php

namespace App\Library;

use Illuminate\Support\Facades\DB;

class RowQuery {
    public static function upSert ($tableName, $columns, $dataBinding, $onDuplicate = null) {
        $placeholders = implode(', ', array_fill(0, count($dataBinding), '?'));
        $values = "($placeholders)";
        
        $connection = DB::connection()->getPdo();

        $valuesString = $values;
        $query = "INSERT INTO $tableName ($columns) VALUES $valuesString";
        
        if($onDuplicate) $query .= "ON DUPLICATE KEY UPDATE $onDuplicate = VALUES($onDuplicate)";
        
        $statement = $connection->prepare($query);
        
        $statement->execute($dataBinding);
    }
}