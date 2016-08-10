<?php
function theme_path($string='',$parameters = [], $secure = null){
    return url(config('theme.path').'/'.config('theme.name').'/'.$string,$parameters, $secure);
}

function layout($name, $data = [], $mergeData = []){
    return view('layouts/'.$name, $data, $mergeData);
}

function template($name, $data = [], $mergeData = []){
    return view('contents/'.$name, $data, $mergeData);
}

function page($name, $data = [], $mergeData = []){
    return view('pages/'.$name, $data, $mergeData);
}