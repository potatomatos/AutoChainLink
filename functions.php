<?php
function httpGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER,0);
    $output = curl_exec($ch);
    curl_close($ch);
    if($output){
        $json = json_decode($output,true);
        if($json){
            return $json;
        }else{
            return $output;
        }
    }
}
