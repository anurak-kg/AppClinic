<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Customer_event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataEdit;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\Facades\DataForm;

class Customer_eventController extends Controller
{

    public function index()
    {

        //return view("dr/calender");
        $event = Customer_event::find(1)->with('customer')->get();

       // return response()->json($event);

       return view("customer/calendar", ['customer_event' => $event[0]]);
    }

    public function fetch()
    {
        $events = [];
        $customer_event = Customer_event::with(['Customer'])->get();
        // dd($dr_event);
        foreach ($customer_event as $event) {
            $e = array();
            $e['id'] = $event->event_id;
            $e['title'] = $event->Customer->cus_name . ' -' . $event->event_name;
            $e['start'] = $event->event_start;
            $e['end'] = $event->event_end;
            $e['allDay'] = false;
            $e['color'] = '#0000CC';
            array_push($events, $e);
        }
        return response()->json($events);
    }

    public function update()
    {
        $input = Input::all();

        $event = Customer_event::findOrFail($input['eventid']);
        $event->event_name = $input['title'];
        $event->event_start = $input['start'];
        $event->event_end = $input['end'];
        $event->save();
        return response()->json(['status' => 'success']);
    }

    public function delete()
    {
        $event = Customer_event::findOrFail(Input::get('id'));
        $event->delete();
        return response()->json(['status' => 'success']);

    }

    public function create()
    {
        /* dd(User::where('position_id','=',4)->lists('name','id')->toArray());*/
        $form = DataForm::create('customer_event');
        $form->add('cus_name', 'ชื่อลูกค้า', 'select')->options(Customer::lists('cus_name','cus_id')->toArray());
        $form->text('event_name', 'รายละเอียด');
        $form->add('event_start', 'วันที่เริ่ม', 'datetime')->format('Y-m-d H:i:s', 'th')->rule('required');
        $form->add('event_end', 'วันที่สิ้นสุด', 'datetime')->format('Y-m-d H:i:s', 'th')->rule('required');
        // $form->text('event_status', 'สถานะ');
        //$form->add('color','Color','colorpicker');

        $form->attributes(array("class" => " "));
        $form->submit('บันทึก');
        $form->saved(function () use ($form) {
            $user = new Customer_event();
            $user->customer_id = Input::get('cus_name');
            $user->event_name = Input::get('event_name');
            $user->event_start = Input::get('event_start');
            $user->event_end = Input::get('event_end');
            // $user->event_status = Input::get('event_status');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("customer/calendar", "ย้อนกลับ");
        });

        return view('customer/calendar', compact('form'));
    }

}
