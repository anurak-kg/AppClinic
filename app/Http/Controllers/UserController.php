<?php

namespace App\Http\Controllers;

use App\Position;
use App\User;
use App\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
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
        Session::flush();
        return  redirect('');
    }
    public function getLogin()
    {
        return view('login');
    }
    public function getUserDataGrid(){
        $grid = DataGrid::source(User::with('branch','position'));
        $grid->add('{{ $branch->branch_name }}', 'ชื่อสาขา','branch_id');
        $grid->add('name','Name');
        $grid->add('email','Email');
        $grid->add('{{ $position->position_name }}', 'ตำแหน่ง','position_id');
        $grid->add('<a href="/user/resetpassword/?id={{ $id }}">Reset</a>','Reset Password');
        $grid->edit('/user/edit', 'กระทำ','show|modify');
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
        $form->add('position_id', 'ตำแหน่ง','select')->options(Position::lists('position_name','position_id')->toArray());
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
            $user->position_id = Input::get('position_id');
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
        $edit->text('name', 'ชื่อ-สกุล');
        $edit->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $edit->text('tel','เบอร์โทรศัพท์');
        $edit->text('email', 'Email');
        $edit->attributes(array("class" => " "));
        $edit->link("user/manage", "ย้อนกลับ");
        return $edit->view('user/edit', compact('edit'));
    }
    public function getUserDataGridDoctor(){
        $grid = DataGrid::source(User::with('branch','position')->where('position_id','=',4));
        $grid->add('{{ $branch->branch_name }}', 'ชื่อสาขา','branch_id');
        $grid->add('name','Name');
        $grid->add('email','Email');
        $grid->add('license','เลขใบประกอบวิชาชีพ');
        $grid->edit('/user/editdoc', 'กระทำ','show|modify');
        $grid->orderBy('id','desc');
        $grid->paginate(10);
        return $grid;
    }
    public function adddoctor (){

        //User Table
        $grid = $this->getUserDataGridDoctor();
        //User Create
        $form = DataForm::create('user');
        $form->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('username', 'Username')->rule('required|unique:users');
        $form->text('password', 'Password', 'password')->rule('required');
        $form->text('name', 'ชื่อ-สกุล')->rule('required');
        $form->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->text('tel','เบอร์โทรศัพท์');
        $form->text('email', 'Email')->rule('required|email|unique:users');
        $form->add('position_id','','hidden')->insertValue(4);
        $form->text('license','เลขใบประกอบวิชาชีพ');
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
            $user->position_id = Input::get('position_id');
            $user->save();
            $form->message("ok record saved");
            $form->link("user/adddoctor", "back to the form");
        });
        return view('user/adddoctor', compact('form','grid'));
    }
    public function editdoc(){
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new User());
        $edit->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $edit->text('name', 'ชื่อ-สกุล');
        $edit->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $edit->text('tel','เบอร์โทรศัพท์');
        $edit->text('email', 'Email');
        $edit->text('license','เลขใบประกอบวิชาชีพ');
        $edit->attributes(array("class" => " "));
        $edit->link("user/manage", "ย้อนกลับ");
        return $edit->view('user/edit', compact('edit'));
    }
    public function test(){
        return \Auth::user()->getRole();
    }

    public function resetPass()
    {
        $user = User::find(Input::get('id'));
        return view('user/resetpassword',['user' => $user]);
    }
    public function postResetPassword(){
        $user = User::find(Input::get('id'));
        $reset = \Input::get('pass');
        //var_dump($reset);
        $user->password = bcrypt(Input::get($reset));
        $user->save();
       // $user->message("success");
        //return Redirect::to('user/manage')->with('message', 'Login Failed');
        Session::flash('message', "ได้ทำการเปลี่ยนรหัสผ่านเรียบร้อย");
        return Redirect::back();
    }

    public function auth(Request $request)
    {
        $this->validate($request, [
            'username' => 'required', 'password' => 'required','branch' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            Session::put('branch_id',Input::get('branch'));
            return redirect()->intended();
        }
        return back()->withErrors([Lang::get('user.loginFailed')])
            ->withInput($request->only('username', 'remember'));
    }

    public function getName() {

        $data = DB::table('branch')
            ->select('branch_name','branch_id')
            ->get();

        return view('/login',['data'=> $data]);
    }



}
