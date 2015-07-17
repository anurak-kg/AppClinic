<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product_group;
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
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('{{ $product_type->pt_name }}', 'ชื่อประเภท','pt_id');

        $grid->add('pg_id', 'รหัสกลุ่มสินค้า');
        $grid->add('pg_name', 'ชื่อกลุ่มสินค้า');
        $grid->edit('/product_group/edit', 'กระทำ','modify|delete');
        $grid->link('product_group/create',"เพิ่มข้อมูลใหม่", "TR");

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

        return view('product_group/index', compact('grid'));
    }
    public function create()
    {

        $form = DataEdit::source(new Product_group());
        $form->add('pt_id','ประเภทสินค้า','select')->options(product_type::lists('pt_name')->toArray());
        $form->text('pg_name', 'ชื่อกลุ่มสินค้า')->rule('required|unique:product_group,pg_name')->attributes(array('placeholder'=>'โปรดระบุชื่อกลุ่มสินค้า....'));
        $form->link("product_group/create", "Back");
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Product_group();
            $user->pg_id = Input::get('pg_id');
            $user->pt_id = Input::get('pt_id');
            $user->pg_name = Input::get('pg_name');
            $user->save();
            $form->message("Success");
        });
        return view('product_group/create', compact('form'));
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
