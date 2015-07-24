<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Branch;
use App\Course;
use App\Customer;
use App\Quotations;
use App\Quotations_detail;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;


class QuotationsController extends Controller
{
    public function index()
    {
        if (Quotations::where('quo_status', -1)->where('branch_id',Branch::getCurrentId())->count() == 0) {
            $quotation = new Quotations();
            //$quotation->cus_id = null;
            $quotation->emp_id = Auth::user()->getAuthIdentifier();
            $quotation->branch_id =  Branch::getCurrentId();
            $quotation->quo_status = -1;
            // $quotation->branch_id = Branch::getId();
            $quotation->save();
            return $this->quoRender();
        } else {
            return $this->quoRender();
        }
    }

    public function quoRender()
    {
        return view('quotations/create', [
            'quo' => Quotations::find($this->getQuoId())
        ]);
    }

    public function getCustomerList()
    {
        $query = '%' . \Input::get('q') . '%';
        $customer = Customer::select('cus_id', 'cus_phone', 'cus_lastname', 'cus_name', 'cus_tel')
            ->where('cus_name', 'LIKE', $query)
            ->orWhere('cus_id', 'LIKE', $query)
            ->orWhere('cus_lastname', 'LIKE', $query)
            ->orWhere('cus_phone', 'LIKE', $query)
            ->get();
        return response()->json($customer);
    }

    public function getCourseList()
    {
        $query = '%' . \Input::get('q') . '%';
        $course = Course::
                where('course_name', 'LIKE', $query)
            ->orWhere('course_id', 'LIKE', $query)
            ->get();

        //$course = Course::find(2);
        //dd($course);
        return response()->json($course);
    }

    public function add()
    {
        $id = \Input::get('id');
         $rec = Quotations::find($this->getQuoId());
        $product = Course::find($id);
        $rec->course()->attach($product, [
            'qty' => 0,
            'quo_de_price'  =>$product->course_price,
            'treat_status'=>0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
        $status = "ok";

        return response()->json([
            'status' => $status,
        ]);

    }

    public function save()
    {

        $quo = Quotations::find($this->getQuoId());
        $quo->price = $this->getCurrentSum();
        $quo->quo_status = 1;
        $quo->quo_date = null;
        $quo->save();
        return redirect('quotations')->with('message','ลงบันทึกเรียบร้อยแล้ว');

    }
    public function getCurrentSum()
    {
        $sum = DB::select(
            DB::raw("    SELECT quotations_detail.quo_id, SUM(course_price) as Total
                        FROM quotations_detail
                        INNER JOIN course ON quotations_detail.course_id = course.course_id
                        WHERE quo_id = ".$this->getQuoId()."")   );
        return $sum[0]->Total;
    }
    public function delete()
    {
        DB::table('quotations_detail')
            ->where('quo_id', "=", $this->getQuoId())
            ->where('course_id', "=", \Input::get('id'))
            ->delete();
    }

    public function getData()
    {
        /*$receivedItem = DB::table('quotations_detail')
            ->select('course.course_id', 'course_name')
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->where('quo_id', "=", $this->getQuoId())
            ->get();*/
        $receivedItem = Quotations_detail::with(['Course'])->
        where('quo_id', "=", $this->getQuoId())->get();
        // dd($receivedItem);
        return response()->json($receivedItem);
    }

    public function getDataCustomer()
    {
        //echo $this->getQuoId();
        $quo = Quotations::find($this->getQuoId());
       // dd($quo);
        $data = null;
        if ($quo->cus_id == 0) {
            $data['status'] = null;
        } else {
            $data['status'] = 'success';
            $customer = Customer::find($quo->cus_id);
            $data['full_name'] = $customer->cus_name . ' ' . $customer->cus_lastname;
            $data['tel'] = $customer->cus_tel;
        }

        return response()->json($data);
    }

    public function setCustomer()
    {
        $cus_id = \Input::get('id');
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->cus_id = $cus_id;
        $quo->save();
        //dd($quo);
        return response()->json(['status' => 'success']);

    }

    public function removeCustomer()
    {
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->cus_id = 0;
        $quo->save();
        return redirect('quotations');
    }

    private function getQuoId()
    {
        $quo = \App\Quotations::where('quo_status', -1)
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id',Branch::getCurrentId())
            ->firstOrFail();
        return $quo->quo_id;
    }


}
