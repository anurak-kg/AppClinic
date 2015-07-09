<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;

class BranchController extends Controller
{
    public function branch(){
        return view("branch/manage");
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
        $grid = DataGrid::source('branch');
        $grid->add('branch_id', 'รหัสสาขา');
        $grid->add('branch_name', 'ชื่อสาขา');
        $grid->add('branch_address', 'ที่อยู่สาขา');
        $grid->add('branch_tel', 'เบอร์โทร');
        $grid->add('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี');
        $grid->edit('/rapyd-demo/edit', 'Edit','show|modify');
        $grid->paginate(10);
        return $grid;
    }
    public function create()
    {

        $grid = $this->getDataGrid();

        $form = DataForm::create();
        $form->text('branch_id', 'รหัสสาขา')->rule('required');
        $form->text('branch_name', 'ชื่อสาขา')->rule('required');
        $form->text('branch_address', 'ที่อยู่สาขา')->rule('required');
        $form->text('branch_tel', 'เบอร์โทร')->rule('required');
        $form->text('branch_code', 'หมายเลขประจำตัวผู้เสียภาษี')->rule('required');
        $form->submit('Save');
        $form->saved(function () use ($form) {
            $user = new Branch\branch();
            $user->branch_id = Input::get('branch_id');
            $user->branch_name = Input::get('branch_name');
            $user->branch_address = Input::get('branch_address');
            $user->branch_tel = Input::get('branch_tel');
            $user->branch_code = Input::get('branch_code');
            $user->save();
            $form->message("Success");
            $form->link("course/manage", "Back");
        });
        return view('branch/manage', compact('form','grid'));
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
