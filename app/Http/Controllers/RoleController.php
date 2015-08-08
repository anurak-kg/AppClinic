<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        dump($input);

        foreach($roles as $role)
        {

                $permissions_sync = isset($input['roles'][$role->id]) ? $input['roles'][$role->id]['permissions'] : [];
                $role->perms()->sync($permissions_sync);

        }

        //return redirect('/permission');
    }
}
