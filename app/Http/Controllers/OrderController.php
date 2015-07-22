<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Order;
use App\User;
use ClassesWithParents\D;
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
        $grid->add('order_total', 'ราคารวม');
        $grid->add('order_de_discount', 'ส่วนลด %');
        $grid->add('order_de_disamount', 'ส่วนลดจำนวนเงิน');


        $grid->add('order_receive_id', 'เลขที่การรับ');
        $grid->add('emp_id_receive', 'รหัสพนักงานที่รับ');
        $grid->add('order_receive_date', 'วันที่รับ');

        $grid->add('order_status', 'สถานะ');

        $grid->edit('/order/edit', 'กระทำ','modify|delete');
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

        $form = DataEdit::source(new Order());
        $form->text('order_id', 'เลขที่ใบสั่งซื้อ')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเลขที่ใบสั่งซื้อ....'));
        $form->add('id', 'รหัสพนักงานสั่งซื้อ','select')->rule('required')->options(Employee::lists('emp_id','emp_id'))->attributes(array('placeholder'=>'โปรดระบุรหัสพนักงานที่สั่งซื้อ....'));
        $form->date('order_date', 'วันที่สั่งซื้อ')->format('d/m/Y','th')->rule('required')->attributes(array('placeholder'=>'โปรดระบุวันที่สั่งซื้อ....'));
        $form->text('order_total', 'ราคารวม')->rule('required')->attributes(array('placeholder'=>'โปรดระบุราคารวม....'));
        $form->text('order_de_discount', 'ส่วนลด %')->attributes(array('placeholder'=>'โปรดระบุส่วนลด %....'));
        $form->text('order_de_disamount', 'ส่วนลดจำนวนเงิน')->attributes(array('placeholder'=>'โปรดระบุส่วนลดจำนวนเงิน....'));

        $form->attributes(array("class" => " "));


        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("order/index", "ย้อนกลับ");
        });


        return view('order/create', compact('form'));
    }


    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Order());

        $edit->text('order_id', 'เลขที่ใบสั่งซื้อ');
        $edit->add('id', 'รหัสพนักงานสั่งซื้อ','select')->options(User::lists('name','id'));
        $edit->date('order_date', 'วันที่สั่งซื้อ')->format('d/m/Y','th');
        $edit->text('order_total', 'ราคารวม');
        $edit->text('order_de_discount', 'ส่วนลด %');
        $edit->text('order_de_disamount', 'ส่วนลดจำนวนเงิน');


        $edit->attributes(array("class" => " "));


        return $edit->view('order/edit', compact('edit'));
    }


}
