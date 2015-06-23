<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Config;
use Input;
use yajra\Datatables\Datatables;
use Zofe\Rapyd\DataForm\DataForm;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getManage()
    {
        return view('product.list');
    }
    public function getListdata(){
        $users = User::select(['name','email','created_at','updated_at'])->get();
        //$users = User::all();

        //dd($users);
        return Datatables::of($users)->addColumn('action', 'action here')->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAdd()
    {

        //Product Add
        $form = DataForm::create();
        $form->text('ProductName', 'ชื่อสินค้า')->rule('required');
        $form->text('ProductBarCode', 'รหัสบาร์โค๊ด')->rule('required');
        $form->add('ProductOnlineSell','ขายออนไลน์','checkbox');
        $form->add('ProductCanSellRunOut','สามารถขายได้เมื่อของหมด','checkbox')->attributes(array("class" => "checkbox-primary"));

        $form->add('body','Body', 'redactor');
        $form->attributes(array("class" => " "));


        $form->submit('Save');


        $form->saved(function () use ($form) {
            $user = new User();
            $user->name = Input::get('name');
            $user->username = Input::get('username');
            $user->password = bcrypt(Input::get('password'));
            $user->email = Input::get('email');
            $user->role = Input::get('role');
            $user->save();
            $form->message("ok record saved");
            $form->link("product/manage", "back to the form");
        });
        return view('product/add', compact('form'));
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
