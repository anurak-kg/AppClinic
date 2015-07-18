<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class OrderController extends Controller
{

    public function getDataGrid(){
        $grid = DataGrid::source(new Order());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('order_id', 'เลขที่ใบสั่งซื้อ',true);
        $grid->add('emp_id_order', 'รหัสพนักงานที่สั่งซื้อ');
        $grid->add('order_date', 'วันที่สั่งซื้อ');
        $grid->add('order_total', 'ราคารวมที่สั่งซื้อ');
        $grid->add('order_de_discount', 'ส่วนลด %');
        $grid->add('order_de_disamount', 'ส่วนลดจำนวนเงิน');


        $grid->add('order_receive_id', 'เลขที่การรับ');
        $grid->add('emp_id_receive', 'รหัสพนักงานที่รับ');
        $grid->add('order_receive_date', 'วันที่รับ');

        $grid->add('order_status', 'สถานะ');

        $grid->edit('/order/edit', 'กระทำ','show|modify|delete');
        $grid->link('order/create',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }


    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('order_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('order/index', compact('grid'));
    }

    public function create()
    {
        $form = DataForm::source(new Order());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $form->text('order_id', 'เลขที่ใบสั่งซื้อ')->rule('required')->attributes(array('maxlength'=>30,'placeholder'=>'โปรดระบุเลขที่ใบสั่งซื้อ....'));
        $form->text('emp_id_order', 'รหัสพนักงานที่สั่งซื้อ')->rule('required');
        $form->date('order_date', 'วันที่สั่งซื้อ')->format('d/m/Y','th')->rule('required');
        $form->text('order_total', 'ราคารวมที่สั่งซื้อ')->rule('required');
        $form->text('order_de_discount', 'ส่วนลด %')->rule('required');
        $form->text('order_de_disamount', 'ส่วนลดจำนวนเงิน')->rule('required');
        $form->text('order_receive_id', 'เลขที่การรับ')->rule('required');
        $form->text('emp_id_receive', 'รหัสพนักงานที่รับ')->rule('required');
        $form->text('order_receive_date', 'วันที่รับ')->rule('required');
        $form->text('order_status', 'สถานะ')->rule('required');



        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->link("order/index", "ย้อนกลับ");
        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อยแล้ว");

        });

        $form->build();
        return view('order/create', compact('form'));
    }


    public function edit()
    {
        //
    }


}
