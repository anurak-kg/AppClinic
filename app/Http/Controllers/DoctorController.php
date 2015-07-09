<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 2:12
 */

namespace App\Http\Controllers;

use App\Dr;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class DoctorController extends Controller
{
    public function doctor(){
        return view("dr/manage");
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
        $grid = DataGrid::source('doctor');
        $grid->add('dr_id', 'รหัสหมอ');
        $grid->add('dr_name', 'ชื่อหมอ');
        $grid->add('dr_lastname', 'นามสกุล');
        $grid->add('dr_tel', 'เบอร์โทรศัพท์มือถือ');
        $grid->add('dr_sex', 'เพศ');
        $grid->edit('/rapyd-demo/edit', 'Edit','show|modify|delete');
        $grid->paginate(10);
        return $grid;
    }
    public function create()
    {

        $grid = $this->getDataGrid();
        $form = DataForm::create();
        $form->text('dr_id', 'รหัสหมอ')->rule('required');
        $form->text('dr_name', 'ชื่อหมอ')->rule('required');
        $form->text('dr_lastname', 'นามสกุล')->rule('required');
        $form->text('dr_tel', 'เบอร์โทรศัพท์มือถือ')->rule('required');
        $form->text('dr_sex', 'เพศ')->rule('required');
        $form->submit('Save');
        $form->saved(function () use ($form) {
            $user = new Dr\doctor();
            $user->dr_id = Input::get('dr_id');
            $user->dr_name = Input::get('dr_name');
            $user->dr_lastname = Input::get('dr_lastname');
            $user->dr_tel = Input::get('dr_tel');
            $user->dr_sex = Input::get('dr_sex');
            $user->save();
            $form->message("Success");
            $form->link("dr/manage", "Back");
        });
        return view('dr/manage', compact('form','grid'));
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
