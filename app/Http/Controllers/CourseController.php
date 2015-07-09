<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function manage(){
        return view("course/manage");
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
    public function getUserDataGrid(){
        $grid = DataGrid::source('course');
        $grid->add('course_id', 'รหัส');
        $grid->add('course_name', 'ชื่อคอร์ส');
        $grid->add('course_type', 'ประเภทคอร์ส');
        $grid->edit('/rapyd-demo/edit', 'Edit','show|modify');
        $grid->paginate(10);
        return $grid;
    }
    public function create()
    {
        //User Table
        $grid = $this->getUserDataGrid();
        //User Create
        $form = DataForm::create();
        $form->text('course_id', 'รหัส')->rule('required');
        $form->text('course_name', 'ชื่อคอร์ส')->rule('required');
        $form->text('course_type', 'ประเภทคอร์ส')->rule('required');
        $form->submit('Save');
        $form->saved(function () use ($form) {
            $user = new Course\newcourse();
            $user->course_id = Input::get('course_id');
            $user->course_name = Input::get('course_name');
            $user->course_type = Input::get('course_type');
            $user->save();
            $form->message("ok");
            $form->link("course/manage", "back to the form");
        });
        return view('course/manage', compact('form','grid'));
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
