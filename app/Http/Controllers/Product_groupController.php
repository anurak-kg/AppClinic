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
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('{{ $product_type->pt_id }}', 'รหัสประเภท','pt_id');
        $grid->add('{{ $product_type->pt_name }}', 'ชื่อประเภท','pt_id');
        $grid->add('pg_id', 'รหัสกลุ่มสินค้า');
        $grid->add('pg_name', 'ชื่อกลุ่มสินค้า');
        $grid->edit('/product_group/edit', 'กระทำ','modify|delete');
        $grid->link('product_group/index',"เพิ่มข้อมูลใหม่", "TR");

        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('product_group_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('product_group/index', compact('form','grid'));
    }
    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Product_group());
        $form->add('pt_id','ประเภทสินค้า','select')->options(Product_type::lists('pt_name','pt_id')->toArray());
        $form->text('pg_name', 'ชื่อกลุ่มสินค้า')->rule('required|unique:product_group,pg_name')->attributes(array('placeholder'=>'โปรดระบุชื่อกลุ่มสินค้า....'));
        $form->link("product_group/index", "Back");
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {

            $form->message("Success");
        });
        return view('product_group/index', compact('form','grid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
