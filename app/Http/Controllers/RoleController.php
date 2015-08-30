<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.role.index',compact('roles', 'permissions'));
    }

    public function postUpdate(Request $request)
    {
        $input = $request->all();

        $roles = Role::all();

        foreach($roles as $role)
        {

                $permissions_sync = isset($input['roles'][$role->id]) ? $input['roles'][$role->id]['permissions'] : [];
                $role->perms()->sync($permissions_sync);

        }

        return redirect('/permission');
    }
    public function getDataGrid(){
        $grid = DataGrid::source(new Role())
            ->where('id','!=',11)
            ->where('id','!=',95)
            ->where('id','!=',99);
        $grid->attributes(array("class" => "table table-hover"));
        $grid->attributes(array("class" => "table table-bordered"));
        $grid->add('name','ต่ำแหน่งภาษาอังกฤษ');
        $grid->add('display_name','ต่ำแหน่งภาษาไทย');
        $grid->edit('/course/edit', 'กระทำ', 'modify|delete|view');
        return $grid;
    }
    public function postGrid(){

        $grid = $this->getDataGrid();

        $form = $this->getCreate();

        return view('role/index', compact('form','grid'));
    }
    public function getCreate(){
        $form = DataEdit::source(new role());


    }
}
