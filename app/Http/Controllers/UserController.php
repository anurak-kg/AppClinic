<?php

namespace App\Http\Controllers;

use App\User;
use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataGrid;

class UserController extends Controller
{

    public function index()
    {
        //
    }
    public function getLogout()
    {
        \Auth::logout();
        return  redirect('');
    }
    public function getLogin()
    {
        return view('login');
    }
    public function getUserDataGrid(){
        $grid = DataGrid::source(User::with('branch'));
        $grid->add('{{ $branch->branch_name }}', 'ชื่อสาขา','branch_id');
        $grid->add('name','Name');
        $grid->add('username','Username');
        $grid->add('email','Email');
        $grid->add('role','Role');
        $grid->edit('/rapyd-demo/edit', 'Edit','show|modify');
        $grid->orderBy('id','desc');
        $grid->paginate(10);
        return $grid;
    }
    public function manage (){

        //User Table
        $grid = $this->getUserDataGrid();
        //User Create
        $form = DataEdit::source(new User());
        $form->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('name', 'Name')->rule('required|unique:user,name');
        $form->text('username', 'Username')->rule('required|unique:users');
        $form->text('password', 'Password', 'password')->rule('required');
        $form->text('name', 'ชื่อ-สกุล')->rule('required');
        $form->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->text('tel','เบอร์โทรศัพท์');
        $form->text('email', 'Email')->rule('required|email|unique:users');
        $form->add('role', 'ตำแหน่ง', 'select')->options(Config::get('shop.role'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $form->message("ok record saved");
            $form->link("user/manage", "back to the form");
        });
        return view('user/manage', compact('form','grid'));
    }


    public function test(){
        return \Auth::user()->getRole();
    }




    public function auth(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->intended();
        }
        return back()->withErrors([Lang::get('user.loginFailed')])
            ->withInput($request->only('username', 'remember'));
    }



}
