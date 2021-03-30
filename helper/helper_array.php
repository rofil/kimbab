<?php

function add_merge(array $array1, array $array2){
    foreach($array2 as $key=>$value) {
        if (key_exists($key, $array1)) {
            $array1[$key] += $value;
        }
    }
    return $array1;
}

function remake_array(array $array1, $key_key, $key_value){
    $data = [];
    foreach ($array1 as $k=>$item) {
        if(key_exists($key_key, $item) && key_exists($key_value, $item))
            $data[$item[$key_key]] = $item[$key_value];
    }

    return $data;
}