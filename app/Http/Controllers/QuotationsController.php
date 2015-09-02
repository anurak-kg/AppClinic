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
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;


class QuotationsController extends Controller
{
    public function getIndex()
    {
        $quoCount = Quotations::where('quo_status', -1)
            ->where('branch_id', Branch::getCurrentId())
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->count();
        if ($quoCount == 0) {
            $quotation = new Quotations();
            $quotation->quo_id = getNewQuoPK();
            //$quotation->cus_id = null;
            $quotation->emp_id = Auth::user()->getAuthIdentifier();
            $quotation->branch_id = Branch::getCurrentId();
            $quotation->quo_status = -1;
            $quotation->vat = getConfig('vat_mode');
            $quotation->vat_rate = getConfig('vat_rate');
            $quotation->commission_rate = getConfig('commission_rate');
            // $quotation->branch_id = Branch::getId();
            $quotation->save();
            return $this->quoRender();
        } else {
            return $this->quoRender();
        }
    }
    public function getHistory()
    {
        $data = Quotations::all();

        return response()->json($data);

        return view('quotations/history', [
            'quotations' => $quotations,
        ]);
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
        $customer = Customer::select('cus_id', 'cus_phone', 'cus_name', 'cus_tel')
            ->where('cus_name', 'LIKE', $query)
            ->orWhere('cus_id', 'LIKE', $query)
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

    public function getAdd()
    {
        $id = \Input::get('id');
        $rec = Quotations::find($this->getQuoId());
        $product = Course::find($id);
        $rec->course()->attach($product, [
            'quo_de_id' => getNewQuoDetailPK(),
            'qty' => 0,
            'quo_de_price' => $product->course_price,
            'net_price' =>  $product->course_price,
            'quo_de_discount' => 0,
            'quo_de_disamount' => 0,
            'payment_remain' =>  $product->course_price,
            'treat_status' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
        $status = "ok";

        return response()->json([
            'status' => $status,
        ]);

    }

    public function anySave()
    {

        $quo = Quotations::find($this->getQuoId());
        $quo->total_net_price = $this->getCurrentSum();
        $quo->quo_status = 1;
        $quo->quo_date = \Carbon\Carbon::now()->toDateTimeString();
        $quo->save();
        systemLogs([
            'emp_id' => auth()->user()->getAuthIdentifier() ,
            'cus_id' => $quo->cus_id ,
            'emp_id2' => $quo->sale_id ,
            'logs_type' => 'info' ,
            'logs_where'=>'Quotations',
            'description'=>'ขายคอร์ส เลขที่การซื้อ :' . $quo->quo_id
        ]);
        return redirect("payment" . "?quo_id=" . $quo->quo_id)
            ->with('quo_id', $quo->quo_id);

    }

    public function getCurrentSum()
    {
        $sum = DB::select(
            DB::raw("SELECT quotations_detail.quo_id, SUM(net_price) as Total
                     FROM quotations_detail
                     INNER JOIN course ON quotations_detail.course_id = course.course_id
                     WHERE quo_id = " . $this->getQuoId() . ""));
        return $sum[0]->Total;
    }

    public function getDelete()
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

    public function getUpdate()
    {
        $type = Input::get('type');
        $value = Input::get('value');
        $id = Input::get('id');
        $quo_detail = Quotations_detail::where('quo_id', "=", $this->getQuoId())
            ->where('course_id', "=", $id)
            ->get()
            ->first();
        $quo_detail->$type = $value;
        if ($type == 'quo_de_discount' || $type == 'quo_de_disamount') {
            $course_price = $quo_detail->quo_de_price - ($quo_detail->quo_de_price * $quo_detail->quo_de_discount / 100) - $quo_detail->quo_de_disamount;
            $quo_detail->net_price=$course_price;
            $quo_detail->payment_remain=$course_price;
        }
        $quo_detail->save();

        return response()->json(['status' => 'Success']);
    }

    public function getUpdatesale()
    {
        $type = Input::get('type');
        $value = Input::get('value');
        $id = Input::get('id');
        $r = DB::table('quotations')
            ->where('quo_id', "=", $this->getQuoId())
            ->update([$type => $value]);
        return response()->json(['status' => 'Success']);
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
            $data['cus_id'] = $customer->cus_id;
            $data['cus_name'] = $customer->cus_name;
            $data['day'] = $customer->cus_birthday_day;
            $data['month'] = $customer->cus_birthday_month;
            $data['year'] = $customer->cus_birthday_year;
            $data['height'] = $customer->cus_height;
            $data['weight'] = $customer->cus_weight;
            $data['phone'] = $customer->cus_phone;
            $data['tel'] = $customer->cus_tel;
            $data['email'] = $customer->cus_email;
            $data['allergic'] = $customer->allergic;
            $data['disease'] = $customer->disease;
            //$data[''] = $customer->;
        }
        return response()->json($data);
    }

    public function getSetCustomer()
    {
        $cus_id = \Input::get('id');
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->cus_id = $cus_id;
        $quo->save();
        //dd($quo);
        return response()->json(['status' => 'success']);

    }

    public function getRemovecustomer()
    {
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->cus_id = 0;
        $quo->save();
        return redirect('quotations');
    }

    public function getDataSale()
    {
        //echo $this->getQuoId();
        $quo = Quotations::find($this->getQuoId());
        // dd($quo);
        $data = null;
        if ($quo->sale_id == 0) {
            $data['status'] = null;
        } else {
            $data['status'] = 'success';
            $user = User::find($quo->sale_id);
            $data['name'] = $user->name;
            $data['id'] = $user->id;
        }
        return response()->json($data);
    }

    public function getSetsale()
    {
        $sale_id = \Input::get('id');
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->sale_id = $sale_id;
        $quo->save();
        //dd($quo);
        return response()->json(['status' => 'success']);

    }

    public function getRemovesale()
    {
        $quo = Quotations::findOrFail($this->getQuoId());
        $quo->sale_id = 0;
        $quo->save();
        return redirect('quotations');
    }

    private function getQuoId()
    {
        $quo = \App\Quotations::where('quo_status', -1)
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->firstOrFail();
        return $quo->quo_id;
    }


}
