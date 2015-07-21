<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Receive;
use App\Vendor;
use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ReceiveController extends Controller
{
    public function getDataGrid(){
        $grid = DataGrid::source(Receive::with('employee','vendor'));
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('receive_id', 'เลขที่รับสินค้า',true);
        $grid->add('{{ $vendor->ven_name }}', 'ร้านค้า','ven_id');
        $grid->add('{{ $employee->emp_name }}', 'ชื่อพนักงาน','emp_id');
        $grid->add('receive_date', 'วันที่รับ');


        $grid->edit('/receive/edit', 'กระทำ','modify|delete');
        $grid->link('receive/create',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('receive_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('receive/index', compact('grid'));
    }
    public function create()
    {
        $form = DataEdit::source(new Receive());
        $form->text('order_id', 'เลขที่ใบสั่งซื้อ')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเลขใบสั่งซื้อสินค้า....'));
        $form->text('receive_id', 'เลขที่รับสินค้า')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเลขที่รับสินค้า....'));
        $form->add('ven_id', 'ชื่อร้านค้า','select')->rule('required')->options(Vendor::lists('ven_name','ven_id')->toArray());
        $form->add('emp_id', 'ชื่อพนักงานที่รับ','select')->rule('required')->options(Employee::lists('emp_name','emp_id')->toArray());
        $form->date('receive_date', 'วันที่รับ')->rule('required')->format('d/m/Y','th')->attributes(array('placeholder'=>'โปรดระบุวันที่รับสินค้า....'));;

        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("receive/index", "ย้อนกลับ");
        });

        return view('receive/create', compact('form'));
    }


    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Receive());
        $edit->text('receive_id', 'เลขที่รับสินค้า');
        $edit->text('ven_id', 'รหัสร้านค้า')->options(Vendor::lists('ven_name','ven_id')->toArray());
        $edit->text('emp_id', 'ชื่อพนักงานที่รับ')->options(Employee::lists('emp_name','emp_id')->toArray());
        $edit->date('receive_date', 'วันที่รับ');

        $edit->attributes(array("class" => " "));
        $edit->link("receive/index", "ย้อนกลับ");


        return $edit->view('receive/edit', compact('edit'));
    }


}
