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
use Zofe\Rapyd\Facades\DataEdit;

class BranchController extends Controller
{

    public function getDataGrid(){
        $grid = DataGrid::source(new Branch());
        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));

        $grid->add('branch_id', trans('branch.branch Code'));
        $grid->add('branch_name', trans('branch.branch name'));
        $grid->add('branch_address', trans('branch.address'));
        $grid->add('branch_tel', trans('branch.tel'));
        $grid->add('branch_code', trans('branch.Tax Identification Number'));
        $grid->edit('/branch/edit', trans('branch.Action'),'modify|delete');
        $grid->link('branch/create', trans('branch.Add'), "TR");
        return view('branch/index', compact('grid'));
    }

    public function grid(){

        $grid = $this->getDataGrid();

        return view('branch/index', compact('grid'));
    }


    public function create()
    {
        $grid = $this->getDataGrid();
        $form = DataEdit::source(new Branch());
        $form->text('branch_name', trans('branch.branch name'))->rule('required|unique:branch,branch_name')->attributes(array('maxlength'=>30));
        $form->textarea('branch_address', trans('branch.address'))->rule('required')->attributes(array('rows'=>4));
        $form->text('branch_tel', trans('branch.tel'))->rule('required');
        $form->text('branch_code', trans('branch.Tax Identification Number'))->rule('required|numeric|unique:branch,branch_code')->attributes(array('maxlength'=>13,'minlength'=>13));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Branch();
            $user->branch_id = Input::get('branch_id');
            $user->save();
            $form->message(trans('branch.successfully'));
            $form->link("branch/index", trans('branch.back'));

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Branch',
                'description'=>'เพิ่มข้อมูลสาขา : รหัสสาขา '.$user->branch_id
            ]);
        });

        return view('branch/create', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Branch());
        $edit->text('branch_name', trans('branch.branch name'));
        $edit->textarea('branch_address', trans('branch.address'))->attributes(array('rows'=>4));
        $edit->text('branch_tel', trans('branch.tel'))->rule('numeric');
        $edit->text('branch_code', trans('branch.Tax Identification Number'))->rule('numeric')->attributes(array('maxlength'=>13,'minlength'=>13));
        $edit->attributes(array("class" => " "));
        $edit->link("branch/index", trans('branch.back'));
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Branch',
                'description'=>'แก้ไขข้อมูลสาขา '.Input::get('branch_name')
            ]);
        });

        return $edit->view('branch/edit', compact('edit'));
    }

}
