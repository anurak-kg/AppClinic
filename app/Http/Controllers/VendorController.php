<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:29
 */

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class VendorController extends Controller
{
    public function vendor(){
        return view("vendor/index");
    }

    public function getDataGrid(){
        $grid = DataGrid::source('vendor');
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));

        $grid->add('ven_id', 'รหัสร้านค้า',true);
        $grid->add('ven_name', 'ชื่อร้านค้า');
        $grid->add('ven_address', 'ที่อยู่ร้านค้า');
        $grid->add('ven_sell_name', 'ชื่อพนักงานขาย');
        $grid->add('ven_sell_tel', 'เบอร์โทรพนักงานขาย');
        $grid->add('ven_discount_per', 'ส่วนลด %');
        $grid->add('ven_discount_amount', 'ส่วนลด บาท');
        $grid->edit('/vendor/edit', 'กระทำ','modify|delete');
        $grid->link('vendor/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);
        return $grid;
    }

    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('ven_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('vendor/index', compact('grid'));
    }


    public function create()
    {

        $form = DataForm::create();
        $form->text('ven_id', 'รหัสร้านค้า')->rule('required');
        $form->text('ven_name', 'ชื่อร้านค้า')->rule('required');
        $form->text('ven_address', 'ที่อยู่ร้านค้า')->rule('required');
        $form->text('ven_sell_name', 'ชื่อพนักงานขาย')->rule('required');
        $form->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย')->rule('required');
        $form->text('ven_discount_per', 'ส่วนลด %')->rule('required');
        $form->text('ven_discount_amount', 'ส่วนลด บาท')->rule('required');
        $form->attributes(array("class" => " "));

        $form->submit('บันทึก');
        $form->link("vendor/index", "ย้อนกลับ");

        $form->saved(function () use ($form) {
            $user = new Vendor();
            $user->ven_id = Input::get('ven_id');
            $user->ven_name = Input::get('ven_name');
            $user->ven_address = Input::get('ven_address');
            $user->ven_sell_name = Input::get('ven_sell_name');
            $user->ven_sell_tel = Input::get('ven_sell_tel');
            $user->ven_discount_per = Input::get('ven_discount_per');
            $user->ven_discount_amount = Input::get('ven_discount_amount');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");
        });
        return view('vendor/create', compact('form'));
    }


}