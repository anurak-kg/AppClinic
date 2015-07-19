<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Course;
use App\Customer;
use App\Quotations;
use App\Quotations_detail;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class QuotationsController extends Controller
{
    public function index()
    {
        if (Quotations::where('quo_status', -1)->count() == 0) {
            $quotation = new Quotations();
            //$quotation->cus_id = null;
            $quotation->emp_id = Auth::user()->getAuthIdentifier();
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
            ->orWhere('cus_lastname', 'LIKE', $query)
            ->orWhere('cus_phone', 'LIKE', $query)
            ->get();
        return response()->json($customer);
    }

    public function getCourseList()
    {
        $query = '%' . \Input::get('q') . '%';
        $course = Course::
        with('detail')
            ->where('course_name', 'LIKE', $query)
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
            'quo_t' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
        $status = "ok";

        return response()->json([
            'status' => $status,
        ]);

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function save()
    {

    }

    public function getData()
    {
        /*$receivedItem = DB::table('quotations_detail')
            ->select('course.course_id', 'course_name')
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->where('quo_id', "=", $this->getQuoId())
            ->get();*/
        $receivedItem = Quotations_detail::with(['Course.detail'])->
        where('quo_id', "=", $this->getQuoId())->get();
        // dd($receivedItem);
        return response()->json($receivedItem);
    }

    private function getQuoId()
    {
        $quo = \App\Quotations::where('quo_status', -1)->where('emp_id', Auth::user()->getAuthIdentifier())->firstOrFail();
        return $quo->quo_id;
    }


}
