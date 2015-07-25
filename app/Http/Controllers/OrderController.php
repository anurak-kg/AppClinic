<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Order;
use App\Quotations;
use App\User;
use ClassesWithParents\D;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;
use Illuminate\Support\Facades\Input;
class OrderController extends Controller
{

    public function index()
    {
        $order = Order::find(1)->with('branch','user','vendor','product')->get();

        // return response()->json($order);

       return view("order/index",['order' => $order]);
    }

    public function getDataGrid(){
        $grid = DataGrid::source(Order::with('user'));
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('order_id', 'เลขที่ใบสั่งซื้อ',true);

        $grid->add('{{ $user->name }}', 'ชื่อพนักงาน','id');
        $grid->add('created_at', 'วันที่สั่งซื้อ');
        $grid->add('order_total', 'ราคารวม');


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
        $form->add('id', 'ชื่อพนักงานสั่งซื้อ','select')->rule('required')->options(User::lists('name','id')->toArray());
        $form->text('order_total', 'ราคารวม')->rule('required')->attributes(array('placeholder'=>'โปรดระบุราคารวม....'));

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
        $edit->add('id', 'พนักงานสั่งซื้อ','select')->options(User::lists('name','id')->toArray());
        $edit->text('order_total', 'ราคารวม');

        $edit->attributes(array("class" => " "));


        return $edit->view('order/edit', compact('edit'));
    }


}
