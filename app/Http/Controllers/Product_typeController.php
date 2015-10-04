<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:43
 */

namespace App\Http\Controllers;

use App\Product_type;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class Product_typeController extends Controller
{
    public function product_type()
    {
        return view("product_type/index");
    }

    public function getDataGrid()
    {
        $grid = DataGrid::source(new Product_type());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('pt_id', 'รหัสประเภทสินค้า',true);
        $grid->add('pt_name', 'ชื่อประเภทสินค้า',true);
        $grid->edit('/product_type/edit', 'กระทำ','modify|delete');
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $form = $this->create();
        return view('product_type/index', compact('form','grid'));
    }


    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Product_type());
        $form->text('pt_name', 'ชื่อประเภทสินค้า')->rule('required|unique:product_type,pt_name')->attributes(array('placeholder'=>'โปรดระบุชื่อประเภทสินค้า....'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Product_type();
            $user->pt_id = Input::get('pt_id');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("product_type/index", "ย้อนกลับ");

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product_type',
                'description'=>'เพิ่มกลุ่มสินค้า : รหัสประเภทสินค้า '. $user->pt_id
            ]);
        });

        return view('product_type/create', compact('form','grid'));
    }

    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Product_type());
        $edit->text('pt_name', 'ชื่อประเภทสินค้า');
        $edit->attributes(array("class" => " "));
        $edit->link("product_type/index", "ย้อนกลับ");
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product_type',
                'description'=>'เพิ่มกลุ่มสินค้า : ประเภทสินค้า '. Input::get('pt_name')
            ]);
        });
        return $edit->view('product_type/edit', compact('edit'));

    }


}
