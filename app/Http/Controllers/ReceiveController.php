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

class ReceiveController extends Controller
{
    public function getDataGrid(){
        $grid = DataGrid::source(new Receive());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('receive_id', 'เลขที่รับสินค้า',true);
        $grid->add('{{ $vendor->ven_name }}', 'ร้านค้า','ven_id');
        $grid->add('{{ $employee->emp_name }}', 'ร้านค้า','emp_id');
        $grid->add('receive_date', 'วันที่รับ');
        $grid->add('receive_total', 'ราคารวม');

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
        $form->text('receive_id', 'เลขที่รับสินค้า')->rule('required')->attributes(array('placeholder'=>'โปรดระบุเลขที่รับสินค้า....'));
        $form->add('ven_id', 'รหัสร้านค้า','select')->rule('required')->options(Vendor::lists('ven_name','ven_id'));
        $form->add('emp_id', 'รหัสพนักงานที่รับ','select')->rule('required')->options(Employee::lists('emp_name','emp_id'));
        $form->date('receive_date', 'วันที่รับ')->rule('required')->format('d/m/Y','th');
        $form->text('receive_total', 'ราคารวม')->rule('required')->attributes(array('placeholder'=>'โปรดระบุราคารวม....'));
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
        $edit->text('ven_id', 'รหัสร้านค้า');
        $edit->text('emp_id', 'รหัสพนักงานที่รับ');
        $edit->date('receive_date', 'วันที่รับ');
        $edit->text('receive_total', 'ราคารวม');
        $edit->attributes(array("class" => " "));
        $edit->link("receive/index", "ย้อนกลับ");


        return $edit->view('receive/edit', compact('edit'));
    }


}
