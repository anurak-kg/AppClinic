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
        $grid->add('pt_id', 'รหัสประเภทสินค้า');
        $grid->add('pt_name', 'ชื่อประเภทสินค้า');
        $grid->edit('/product_type/edit', 'กระทำ','show|modify|delete');
        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $form = $this->create();
        $grid->row(function ($row) {
            if ($row->cell('product_type_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('product_type/index', compact('form','grid'));
    }


    public function create()
    {
        $form = DataForm::source(new Product_type());
        $form->text('pt_name', 'ชื่อประเภทสินค้า')->rule('required|unique:product_type,pt_name')->attributes(array('placeholder'=>'โปรดระบุชื่อประเภทสินค้า....'));
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {

            $form->message("Success");
            $form->link("product_type/index", "Back");
        });
        return $form;
    }

    public function edit()
    {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Product_type());
        $edit->text('pt_name', 'ชื่อประเภทสินค้า');
        $edit->attributes(array("class" => " "));
        $edit->link("product_type/index", "ย้อนกลับ");

        return $edit->view('product_type/edit', compact('edit'));

    }


}
