<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product_group;
use App\Product_type;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Controllers\Controller;

class Product_groupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("product_group/index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getDataGrid()
    {
        $grid = DataGrid::source(Product_group::with('product_type'));
        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));

        $grid->add('pg_id', 'รหัสกลุ่มสินค้า');
        $grid->add('pg_name', 'ชื่อกลุ่มสินค้า');
        $grid->edit('/product_group/edit', 'กระทำ','modify|delete');


        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();

        $form = $this->create();

        return view('product_group/index', compact('form','grid'));
    }
    public function create()
    {
        $form = DataEdit::source(new Product_group());
        $form->text('pg_name', 'ชื่อกลุ่มสินค้า')->rule('required|unique:product_group,pg_name')->attributes(array('placeholder'=>'โปรดระบุชื่อกลุ่มสินค้า....'));
        $form->attributes(array("class" => " "));
        $form->saved(function () use ($form) {
            $user = new Product_group();
            $user->pg_id = Input::get('pg_id');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("product_group/index", "ย้อนกลับ");

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product_group',
                'description'=>'เพิ่มกลุ่มสินค้า : รหัสกลุ่มสินค้า '.$user->pg_id
            ]);
        });
        return $form;
    }
    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Product_group());
        $edit->text('pg_name', 'ชื่อกลุ่มสินค้า');
        $edit->attributes(array("class" => " "));
        $edit->link("product_group/index", "ย้อนกลับ");
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product_group',
                'description'=>'เพิ่มกลุ่มสินค้า : กลุ่มสินค้า '. Input::get('pg_name')
            ]);
        });
        return $edit->view('product_group/edit', compact('edit'));


    }

}
