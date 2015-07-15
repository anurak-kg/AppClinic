<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:43
 */

namespace App\Http\Controllers;

use App\Producttype;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class ProducttypeController extends Controller
{
    public function product_type()
    {
        return view("product_type/manage");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getDataGrid()
    {
        $grid = DataGrid::source('product_type');
        $grid->add('pt_id', 'รหัสประเภทสินค้า');
        $grid->add('pt_name', 'ชื่อประเภทสินค้า');
        $grid->edit('/rapyd-demo/edit', 'Edit', 'show|modify|delete');
        $grid->paginate(10);
        return $grid;
    }

    public function create()
    {

        $grid = $this->getDataGrid();

        $form = DataForm::create();
        $form->text('pt_id', 'รหัสประเภทสินค้า')->rule('required');
        $form->text('pt_name', 'ชื่อประเภทสินค้า')->rule('required');
        $form->submit('Save');
        $form->saved(function () use ($form) {
            $user = new Producttype\product_type();
            $user->pt_id = Input::get('pt_id');
            $user->pt_name = Input::get('pt_name');
            $user->save();
            $form->message("Success");
            $form->link("product_type/manage", "Back");
        });
        return view('product_type/manage', compact('form', 'grid'));
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
        //
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
