<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting
{
    private $settingList = [];
    private $settingValue = [];
    private $rule = [];

    public function initSettingList($list){
        $this->rule = $list;
        foreach ($list as $key =>$rule) {
            $this->pushSettingList($key);
        }
        return $this;
    }
    public function pushSettingList($setting)
    {
        array_push($this->settingList, $setting);
    }

    public function save($input){
        foreach ($input as $key => $value) {
           // echo $value ." + ". $this->getValue($key);
            if($value != $this->getValue($key)){
                $this->update($key,$value);
               // echo "update";
            }
        }

    }

    public function getSettingValue()
    {
        foreach($this->settingList as $setting ){

            $this->settingValue[$setting] = $this->getValue($setting);
        }
        return  $this->settingValue;
    }

    public function getValue($setting_name)
    {
        return DB::table('setting')
            ->where('setting_name',$setting_name)->pluck('value');
    }

    private function update($setting_name,$setting_value)
    {
        $var = DB::table('setting')
            ->where('setting_name',$setting_name)
            ->update(['value' => $setting_value]);
    }
}
