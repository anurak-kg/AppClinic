<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
        $data = DB::table('branch')
            ->select('branch_name','branch_id')
            ->get();

        return view('login',['data'=>$data]);
    }
    public function getUserDataGrid(){
        $grid = DataGrid::source(User::with('branch','role')
            ->where('position_id','!=',95)
            ->where('position_id','!=',99));

        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));

        $grid->add('{{ $branch->branch_name }}', 'ชื่อสาขา');
        $grid->add('name','Name');
        $grid->add('email','Email');
        $grid->add('{{ $role->display_name }}', 'ตำแหน่ง');
        $grid->add('<a href="/user/resetpassword/?id={{ $id }}">Reset</a>','Reset Password');
        $grid->edit('/user/edit', 'กระทำ','show|modify|delete');

        return $grid;
    }


    public function manage (){

        //User Table
        $grid = $this->getUserDataGrid();
        $grid->row(function ($row) {
            if ($row->cell('{{ $position->position_name }}') == 'admin') {
                $row->cell('{{ $position->position_name }}')->style("display:none");
                $row->style("display:none");
            }
            if ($row->cell('{{ $position->position_name }}') == 'IT') {
                $row->cell('{{ $position->position_name }}')->style("display:none");
                $row->style("display:none");
            }
        });

            //User Create
        $form = DataForm::create('user');
        $form->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('username', 'Username')->rule('unique:users')->attributes(array('placeholder' => 'ระบุ Username ....'));
        $form->text('password', 'Password', 'password')->attributes(array('placeholder' => 'ระบุ Password ....'));
        $form->text('name', 'ชื่อ-สกุล')->rule('required')->attributes(array('placeholder' => 'ระบุ ชื่อ-สกุล ....'));
        $form->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->text('tel','เบอร์โทรศัพท์')->attributes(array('placeholder' => 'ระบุ เบอร์โทร ....'));
        $form->text('email', 'Email')->rule('required|email|unique:users')->attributes(array('placeholder' => 'ระบุ E-mail ....'));
        $form->add('role', 'ตำแหน่ง','select')->options(Role::where('id','<','90')->lists('display_name','id')->toArray());
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
            $user->position_id = Input::get('role');
            $user->save();
            $user->roles()->sync([Input::get('role')]);
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
        $grid = DataGrid::source(User::with('branch','role')->where('position_id','=',4));
        $grid->attributes(array("class"=>"table table-bordered",'id'=>'data-table'));
        $grid->add('{{ $branch->branch_name }}', 'ชื่อสาขา');
        $grid->add('name','Name');
        $grid->add('email','Email');
        $grid->add('license','เลขใบประกอบวิชาชีพ');
        $grid->edit('/user/editdoc', 'กระทำ','show|modify|delete');
        $grid->orderBy('id','desc');

        return $grid;
    }
    public function adddoctor (){

        //User Table
        $grid = $this->getUserDataGridDoctor();
        //User Create
        $form = DataForm::create('users');
        $form->add('branch','ชื่อสาขา','select')->options(Branch::lists('branch_name','branch_id')->toArray());
        $form->text('name', 'ชื่อ-สกุล')->rule('required')->attributes(array('placeholder' => 'ระบุ ชื่อ-สกุล ....'));
        $form->add('sex','เพศ','select')->options(Config::get('sex.sex'))->rule('required');
        $form->text('tel','เบอร์โทรศัพท์')->attributes(array('placeholder' => 'ระบุ เบอร์โทร ....'));
        $form->text('email', 'Email')->rule('required|email|unique:users')->attributes(array('placeholder' => 'ระบุ E-mail ....'));
        $form->add('position_id','','hidden')->insertValue(4);
        $form->text('license','เลขใบประกอบวิชาชีพ')->rule('required')->attributes(array('placeholder' => 'ระบุ เลขใบประกอบวิชาชีพ ....'));
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new User();
            $user->branch_id = Input::get('branch');
            $user->password = bcrypt(Input::get('password'));
            $user->name = Input::get('name');
            $user->sex = Input::get('sex');
            $user->tel = Input::get('tel');
            $user->email = Input::get('email');
            $user->position_id = Input::get('position_id');
            $user->license = Input::get('license');
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
        $edit->link("user/adddoctor", "ย้อนกลับ");
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
            systemLogs([
                'logs_type' => 'info' ,
                'logs_where'=>'Auth',
                'description'=>'พนักงาน Username :'.$request->input('username') . ' ได้เข้าสู่ระบบ'
            ]);
            return redirect()->intended();
        }
        return back()->withErrors([Lang::get('user.loginFailed')])
            ->withInput($request->only('username', 'remember'));
    }




}
