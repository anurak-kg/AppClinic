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
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class Product_typeController extends Controller
{
    public function product_type()
    {
        return view("product_type/index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("product_type/index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getDataGrid()
    {
        $grid = DataGrid::source('product_type');
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('pt_id', 'รหัสประเภทสินค้า');
        $grid->add('pt_name', 'ชื่อประเภทสินค้า');
        $grid->edit('/product_type/edit', 'กระทำ','modify|delete');
        $grid->link('product_type/create',"เพิ่มข้อมูลใหม่", "TR");
        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('product_type_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('product_type/index', compact('grid'));
    }


    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataForm::create();
        $form->text('pt_name', 'ชื่อประเภทสินค้า')->rule('required|unique:product_type,pt_name')->attributes(array('placeholder'=>'โปรดระบุชื่อประเภทสินค้า....'));
        $form->submit('Save');
        $form->link("product_type/create", "Back");
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Product_type();
            $user->pt_id = Input::get('pt_id');
            $user->pt_name = Input::get('pt_name');
            $user->save();
            $form->message("Success");
        });
        return view('product_type/create', compact('form','grid'));
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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //find customer
        $product_type = Product_type::find($id);
        //show the edit form
        return View::make('product_type.edit')->with('product_type', $product_type);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
