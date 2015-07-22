<?php

namespace App\Http\Controllers;

use App\User;
use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Zofe\Rapyd\DataForm\DataForm;
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
        $grid->edit('/user/edit', 'Edit','show|modify');
        $grid->orderBy('id','desc');
        $grid->paginate(10);
        return $grid;
    }
    public function manage (){

        //User Table
        $grid = $this->getUserDataGrid();
        //User Create
        $form = DataForm::create('user');
        $form->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('username', 'Username')->rule('required|unique:users');
        $form->text('password', 'Password', 'password')->rule('required');
        $form->text('name', 'ชื่อ-สกุล')->rule('required');
        $form->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->text('tel','เบอร์โทรศัพท์');
        $form->text('email', 'Email')->rule('required|email|unique:users');
        $form->add('role', 'ตำแหน่ง', 'select')->options(Config::get('shop.role'));
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new User();
            $user->branch_id = Input::get('branch');
            $user->username = Input::get('username');
            $user->password = bcrypt(Input::get('password'));
            $user->name = Input::get('name');
            $user->sex = Input::get('sex');
            $user->tel = Input::get('tel');
            $user->email = Input::get('email');
            $user->role = Input::get('role');
            $user->save();
            $form->message("ok record saved");
            $form->link("user/manage", "back to the form");
        });
        return view('user/manage', compact('form','grid'));
    }

    public function edit(){
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new User());
        $edit->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $edit->text('name', 'ชื่อ-สกุล')->rule('required');
        $edit->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $edit->text('tel','เบอร์โทรศัพท์');
        $edit->text('email', 'Email');
        $edit->add('role', 'ตำแหน่ง', 'select')->options(Config::get('shop.role'));
        $edit->attributes(array("class" => " "));
        $edit->link("user/manage", "ย้อนกลับ");
        return $edit->view('user/edit', compact('edit'));
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
