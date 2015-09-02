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
function zerofill ($num, $zerofill = 5)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}
function getNewQuoPK()
{
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . '1' . '0000000';
    $maxPk = Branch::getCurrentId() . '1' . '9999999';
    $count = \App\Quotations::where('quo_id', '>=', $minPk)
        ->where('quo_id', '<=', $maxPk)->count();
    if ($count == 0) {
        $primaryKey = (int)$minPk + 1;
    } else {
        $quo = \App\Quotations::where('quo_id', '>=', $minPk)
            ->where('quo_id', '<=', $maxPk)
            ->orderBy('quo_id', 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey = $quo->quo_id + 1;
    }
    return $primaryKey;
    //dump([$minPk,$maxPk,$count]);
}

function getNewQuoDetailPK()
{
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . '2' . '0000000';
    $maxPk = Branch::getCurrentId() . '2' . '9999999';
    $count = \App\Quotations_detail::where('quo_de_id', '>=', $minPk)
        ->where('quo_de_id', '<=', $maxPk)->count();
    if ($count == 0) {
        $primaryKey = (int)$minPk + 1;
    } else {
        $quo = \App\Quotations_detail::where('quo_de_id', '>=', $minPk)
            ->where('quo_de_id', '<=', $maxPk)
            ->orderBy('quo_de_id', 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey = $quo->quo_de_id + 1;
    }
    return $primaryKey;
    //dump([$minPk,$maxPk,$count]);
}

function getNewSalePK()
{
    return createPkFrom('App\Sales', 'sales_id', 3, '0000000', '9999999');
}

function getNewOrderPK()
{
    return createPkFrom('App\Order', 'order_id', 4, '0000000', '4999999');
}

function getNewRequestPK()
{
    return createPkFrom('App\Order', 'order_id', 4, '5000000', '6999999');
}

function getNewReceivePK()
{
    return createPkFrom('App\Receive', 'receive_id', 5, '0000000', '4999999');
}

function getNewReturnPK()
{
    return createPkFrom('App\Re_turn', 'return_id', 5, '5000000', '6999999');
}

function getNewRequestReceivePK()
{
    return createPkFrom('App\Receive', 'receive_id', 5, '7000000', '9999999');
}

function getNewInvTranPK()
{
    return createPkFrom('App\InventoryTransaction', 'inv_id', 6, '0000000', '9999999');
}

function getNewPaymentPK()
{
    return createPkFrom('App\Payment', 'payment_id', 7, '0000000', '4999999');
}

function getNewPaymentDetailPK()
{
    return createPkFrom('App\Payment_detail', 'payment_de_id', 7, '5000000', '9999999');
}
function getNewTreatmentPK()
{
    return createPkFrom('App\TreatHistory', 'treat_id', 8, '0000000', '4999999');
}
function getNewBtPK()
{
    return createPkFrom('App\Bt', 'bt_id', 8, '8000000', '9999999');
}
function getNewCustomerPK()
{
    return createPkFrom('App\Customer', 'cus_id', 9, '0000000', '9999999');
}

function createPkFrom($model, $primaryKeyAtt, $typeNumber, $min, $max)
{
    $primaryKey = null;
    $minPk = Branch::getCurrentId() . $typeNumber . $min;
    $maxPk = Branch::getCurrentId() . $typeNumber . $max;
    $count = $model::where($primaryKeyAtt, '>=', $minPk)
        ->where($primaryKeyAtt, '<=', $maxPk)->count();
    if ($count == 0) {
        $primaryKey = (int)$minPk + 1;
    } else {
        $data = $model::where($primaryKeyAtt, '>=', $minPk)
            ->where($primaryKeyAtt, '<=', $maxPk)
            ->orderBy($primaryKeyAtt, 'desc')
            ->limit(1)
            ->get()
            ->first();
        $primaryKey = $data->$primaryKeyAtt + 1;
    }
    return $primaryKey;
}