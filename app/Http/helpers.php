<?php
function getConfig($configName)
{
    $setting = new \App\Setting();
    return $setting->getValue($configName);
}