<?php
namespace App\Http\Controllers;
use App\Branch;
use App\Doctor;
use App\InventoryTransaction;
use App\Product;
use App\Quotations_detail;
use App\TreatHistory;
use App\User;
use App\Quotations;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function treatment()
    {
        return view("treatment/index");
    }
    public function getCourseData()
    {
        $customerId = \Input::get('id');
        $course = Quotations::with('course')
            ->where('cus_id', '=', $customerId)
            ->where('quo_status', '>=', 1)
            ->get();
        return response()->json($course);
    }
    public function save()
    {
        $input = \Input::all();
        $treat = new TreatHistory();
        $treat->course_id = $input['course_id'];
        $treat->quo_id = $input['quo_id'];
        $treat->emp_id = Auth::user()->getAuthIdentifier();;
        $treat->dr_id = $input['doctor'];
        $treat->bt_user_id1 = $input['bt1'];
        $treat->bt_user_id2 = $input['bt2'];
        $treat->dr_price = $input['dr_price'];
        $treat->bt1_price = $input['bt1_price'];
        $treat->bt2_price = $input['bt2_price'];
        $treat->comment = $input['comment'];
        $treat->treat_date = $input['treat_date'];
        $treat->branch_id = Branch::getCurrentId();
        $this->updateCourseQty($input['quo_id'], $input['course_id']);
        $treat->save();
        $array = $input['qty'];
        foreach ($array as $qty) {
            $treat->product()->attach(Product::find(key($array)), ['qty' => $qty]);
            $inv = new InventoryTransaction();
            $inv->product_id =  key($array);
            $inv->treatment_id =  $treat->treat_id;
            $inv->qty =  -abs($qty);
            $inv->branch_id =  Branch::getCurrentId();
            $inv->type = "Treatment" ;
            $inv->save();
            next($array);
        }
        // dd(\Input::all());
        return redirect('treatment')->with('message','ลงบันทึกเรียบร้อยแล้ว');    }
    public function updateCourseQty($quo_id, $course_id)
    {
        $treat_status = 1;
        $quo = Quotations_detail::with(['Course'])
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->get()
            ->first();
        $course_qty = $quo->course->course_qty;
        $qty = $quo->qty + 1;
        if ($course_qty == $qty) {
            $treat_status = 5;
        }
        $quo_detail = DB::table('quotations_detail')
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->update(['treat_status' => $treat_status,'qty' => $qty]);
    }
    public function add()
    {
        $course_id = \Input::get('course_id');
        $quo_id = \Input::get('quo_id');
        $quo = Quotations_detail::with(['Course.course_medicine.product', 'Quotations.Customer'])
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->get();
        //dd($quo);
        $dr = User::where('position_id', '=', 4)->get();
        $user = User::all();
        // return response()->json($quo);
        return view('treatment.add',
            ['quo' => $quo[0],
                'doctor' => $dr,
                'users' => $user
            ]);
    }
}