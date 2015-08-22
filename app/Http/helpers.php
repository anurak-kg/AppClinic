<?php
use App\Branch;

function getConfig($configName)
{
    $setting = new \App\Setting();
    return $setting->getValue($configName);
}
function systemLogs($array){
    $log = new \App\SystemLogs();
    foreach($array as $key => $value){
        $log->$key = $value;
    }
    $log->branch_id =  Branch::getCurrentId();
    $log->save();
}