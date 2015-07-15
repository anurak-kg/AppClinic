<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:29
 */

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class VendorController extends Controller
{
    public function vendor(){
        return view("vendor/manage");
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
    public function getDataGrid(){
        $grid = DataGrid::source('vendor');
        $grid->add('ven_id', 'รหัสร้านค้า');
        $grid->add('ven_name', 'ชื่อร้านค้า');
        $grid->add('ven_address', 'ที่อยู่ร้านค้า');
        $grid->add('ven_sell_name', 'ชื่อพนักงานขาย');
        $grid->add('ven_sell_tel', 'เบอร์โทรพนักงานขาย');
        $grid->add('ven_discount_per', 'ส่วนลด %');
        $grid->add('ven_discount_amount', 'ส่วนลด บาท');
        $grid->edit('/rapyd-demo/edit', 'Edit','show|modify|delete');
        $grid->paginate(10);
        return $grid;
    }
    public function create()
    {

        $grid = $this->getDataGrid();

        $form = DataForm::create();
        $form->text('ven_id', 'รหัสร้านค้า')->rule('required');
        $form->text('ven_name', 'ชื่อร้านค้า')->rule('required');
        $form->text('ven_address', 'ที่อยู่ร้านค้า')->rule('required');
        $form->text('ven_sell_name', 'ชื่อพนักงานขาย')->rule('required');
        $form->text('ven_sell_tel', 'เบอร์โทรพนักงานขาย')->rule('required');
        $form->text('ven_discount_per', 'ส่วนลด %')->rule('required');
        $form->text('ven_discount_amount', 'ส่วนลด บาท')->rule('required');
        $form->submit('Save');
        $form->saved(function () use ($form) {
            $user = new Vendor();
            $user->ven_id = Input::get('ven_id');
            $user->ven_name = Input::get('ven_name');
            $user->ven_address = Input::get('ven_address');
            $user->ven_sell_name = Input::get('ven_sell_name');
            $user->ven_sell_tel = Input::get('ven_sell_tel');
            $user->ven_discount_per = Input::get('ven_discount_per');
            $user->ven_discount_amount = Input::get('ven_discount_amount');
            $user->save();
            $form->message("Success");
            $form->link("vendor/manage", "Back");
        });
        return view('vendor/manage', compact('form','grid'));
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