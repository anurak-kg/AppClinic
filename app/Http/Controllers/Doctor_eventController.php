<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Doctor_event;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\Facades\DataForm;

class Doctor_eventController extends Controller
{

    public function index(){

        //return view("dr/calender");
        $event = Doctor_event::find(1)->with('doctor_event','doctor')->get();

         //return response()->json($event);

        return view("dr/calender",['doctor_event' => $event[0]]);
    }



    public function create()
    {
       /* dd(User::where('position_id','=',4)->lists('name','id')->toArray());*/
        $form = DataForm::create('doctor_event');
        $form->add('name','ชื่อแพทย์','select')->options(User::where('position_id','=',4)->lists('name','id')->toArray());
        $form->text('event_name', 'event_name');
        $form->add('event_start','Start', 'datetime')->format('Y-m-d H:i:s', 'th')->rule( 'required' );
        $form->add('event_end','End', 'datetime')->format('Y-m-d H:i:s', 'th')->rule( 'required' );
        $form->text('event_status','สถานะ');
        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new Doctor_event();
            $user->dr_id = Input::get('name');
            $user->event_name = Input::get('event_name');
            $user->event_start = Input::get('event_start');
            $user->event_end = Input::get('event_end');
            $user->event_status = Input::get('event_status');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("dr/calender", "ย้อนกลับ");
        });

        return view('dr/calender', compact('form'));
    }

    public function edit() {
        if (Input::get('do_delete')==1) return  "not the first";

        $edit = DataEdit::source(new Doctor_event());
        $edit->add('name','ชื่อแพทย์','select')->options(User::where('position_id','=',4)->lists('name','id')->toArray());
        $edit->text('event_name', 'event_name');
        $edit->datetime('event_start', 'วัน/เวลาเริ่ม Y-m-d HH:mm:ss');
        $edit->datetime('event_end', 'วัน/เวลาสิ้นสุด Y-m-d HH:mm:ss');
        $edit->text('event_status','สถานะ');
        $edit->attributes(array("class" => " "));
        $edit->link("dr/calender", "ย้อนกลับ");

        return $edit->view('dr/edit-event', compact('edit'));
    }
}
