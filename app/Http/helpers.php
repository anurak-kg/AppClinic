<?php
use App\Branch;
use App\Customer;
function getConfig($configName)
{
    $setting = new \App\Setting();
    return $setting->getValue($configName);
}

function systemLogs($array)
{
    $log = new \App\SystemLogs();
    foreach ($array as $key => $value) {
        $log->$key = $value;
    }
    $log->branch_id = Branch::getCurrentId();
    $log->save();
}

function getNewQuoPK()
{
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . '1' . '0000000';
    $maxPk = Branch::getCurrentId() . '1' . '9999999';
    $count = \App\Quotations::where('quo_id','>=',$minPk)
        ->where('quo_id','<=',$maxPk)->count();
    if($count == 0){
        $primaryKey=(int)$minPk+1;
    }else{
        $quo = \App\Quotations::where('quo_id','>=',$minPk)
            ->where('quo_id','<=',$maxPk)
            ->orderBy('quo_id', 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey=$quo->quo_id+1;
    }
    return $primaryKey;
    //dump([$minPk,$maxPk,$count]);
}
function getNewQuoDetailPK()
{
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . '2' . '0000000';
    $maxPk = Branch::getCurrentId() . '2' . '9999999';
    $count = \App\Quotations_detail::where('quo_de_id','>=',$minPk)
        ->where('quo_de_id','<=',$maxPk)->count();
    if($count == 0){
        $primaryKey=(int)$minPk+1;
    }else{
        $quo = \App\Quotations_detail::where('quo_de_id','>=',$minPk)
            ->where('quo_de_id','<=',$maxPk)
            ->orderBy('quo_de_id', 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey=$quo->quo_de_id+1;
    }
    return $primaryKey;
    //dump([$minPk,$maxPk,$count]);
}
function getNewSalePK()
{
    return createPkFrom('App\Sales','sales_id',3);
}
function getNewOrderPK()
{
    return createPkFrom('App\Order','order_id',4);
}
function getNewCustomerPK()
{
    return createPkFrom('App\Customer','cus_id',9);
}

function createPkFrom($model,$primaryKeyAtt,$typeNumber){
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . $typeNumber . '0000000';
    $maxPk = Branch::getCurrentId() . $typeNumber . '9999999';
    $count = $model::where($primaryKeyAtt,'>=',$minPk)
        ->where($primaryKeyAtt,'<=',$maxPk)->count();
    if($count == 0){
        $primaryKey=(int)$minPk+1;
    }else{
        $data = $model::where($primaryKeyAtt,'>=',$minPk)
            ->where($primaryKeyAtt,'<=',$maxPk)
            ->orderBy($primaryKeyAtt, 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey=$data->$primaryKeyAtt+1;
    }
    return $primaryKey;
}