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

    public function index()
    {
        return view("dr/calender");
    }

    public function fetch()
    {
        $events = [];
        $dr_event = Doctor_event::with(['User'])->get();
        // dd($dr_event);
        foreach ($dr_event as $event) {
            $e = array();
            $e['id'] = $event->event_id;
            $e['title'] = $event->User->name . ' -' . $event->event_name;
            $e['start'] = $event->event_start;
            $e['end'] = $event->event_end;
            $e['allDay'] = false;
            $e['color'] = '#512DA8';
            array_push($events, $e);
        }
        return response()->json($events);
    }

    public function update()
    {
        $input = Input::all();

        $event = Doctor_event::findOrFail($input['eventid']);
        $event->event_name = $input['title'];
        $event->event_start = $input['start'];
        $event->event_end = $input['end'];
        $event->save();
        return response()->json(['status' => 'success']);
    }

    public function delete()
    {
        $event = Doctor_event::findOrFail(Input::get('id'));
        $event->delete();
        return response()->json(['status' => 'success']);

    }

    public function create()
    {
        /* dd(User::where('position_id','=',4)->lists('name','id')->toArray());*/
        $form = DataForm::create('doctor_event');
        $form->add('name', 'ชื่อแพทย์', 'select')->options(User::where('position_id', '=', 4)->lists('name', 'id')->toArray());
        $form->text('event_name', 'รายละเอียด')->attributes(array('placeholder' => 'ระบุรายละเอียด ....'));
        $form->add('event_start', 'วันที่เริ่ม', 'datetime')->format('Y-m-d H:i:s', 'th')->rule('required')->attributes(array('placeholder' => 'ระบุวันที่เริ่ม ....'));
        $form->add('event_end', 'วันที่สิ้นสุด', 'datetime')->format('Y-m-d H:i:s', 'th')->rule('required')->attributes(array('placeholder' => 'ระบุวันที่สิ้นสุด ....'));
        // $form->text('event_status', 'สถานะ');
        //$form->add('color','Color','colorpicker');

        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new Doctor_event();
            $user->dr_id = Input::get('name');
            $user->event_name = Input::get('event_name');
            $user->event_start = Input::get('event_start');
            $user->event_end = Input::get('event_end');
            // $user->event_status = Input::get('event_status');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("dr/calender", "ย้อนกลับ");
        });

        return view('dr/calender', compact('form'));
    }

}
