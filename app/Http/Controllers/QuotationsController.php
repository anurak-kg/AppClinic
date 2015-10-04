<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Branch;
use App\Commission;
use App\Course;
use App\Customer;
use App\InventoryTransaction;
use App\Product;
use App\Quotations;
use App\Quotations_detail;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;


class QuotationsController extends Controller
{
    private $quo_id;

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

        /*return view('quotations/history', [
            'quotations' => $quotations,
        ]);*/
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
        $type = \Input::get('type');
        $price = null;
        $quo_detail = new Quotations_detail();
        $quo_detail->quo_de_id = getNewQuoDetailPK();
        $quo_detail->quo_id = $this->getQuoId();
        $quo_detail->quo_de_discount = 0;
        $quo_detail->quo_de_disamount = 0;
        $quo_detail->course_id = null;
        $quo_detail->product_id = null;
        $quo_detail->product_qty = 1;
        $quo_detail->treat_status = 0;
        $quo_detail->qty = 0;

        if ($type == "product") {
            $product = Product::findOrFail($id);
            $quo_detail->product_id = $product->product_id;
            $price = $product->product_price;

        } elseif ($type == "course") {
            $course = Course::findOrFail($id);
            $quo_detail->course_id = $course->course_id;
            $price = $course->course_price;

        }
        $quo_detail->payment_remain = $price;
        $quo_detail->quo_de_price = $price;
        $quo_detail->net_price = $price;

        $quo_detail->save();
        return response()->json($this->getQuoDetailDataToArray($quo_detail->quo_de_id));

    }

    private function  getQuoDetailDataToArray($quo_detail_id)
    {
        $item = Quotations_detail::where('quo_de_id', '=', $quo_detail_id)
            ->with(['Course', 'Product'])
            ->get()
            ->first();

        $array = [];
        $array['quo_id'] = $item->quo_id;
        $array['quo_de_id'] = $item->quo_de_id;

        if ($item->product != null) {
            $array['type'] = "product";
            $array['name'] = $item->product->product_name;
            $array['price'] = $item->product->product_price;
            $array['product_qty'] = $item->product_qty;
            $array['commission'] = 0;
        }
        if ($item->course != null) {
            $array['type'] = "course";
            $array['name'] = $item->course->course_name;
            $array['course_detail'] = $item->course->course_detail;
            $array['price'] = $item->course->course_price;
            $array['product_qty'] = 1;
            if ($item->course->commission == null) {
                $array['commission'] = 0;
            } elseif ($item->course->commission != null) {
                $array['commission'] = $item->course->commission;
            }
        }

        $array['quo_de_discount'] = $item->quo_de_discount;
        $array['quo_de_disamount'] = $item->quo_de_disamount;
        $array['quo_de_price'] = $item->quo_de_price;
        return $array;

    }

    public function anySave()
    {
        $this->quo_id = $this->getQuoId();
        $quo = Quotations::find($this->quo_id);
        $quo->total_net_price = $this->getCurrentSum();
        $quo->quo_status = 1;
        //$quo->bill_number = getNewBillNo();
        $quo->quo_date = \Carbon\Carbon::now()->toDateTimeString();

        //คำนวญค่า Commissions
        $this->commissionsCalculate();
        $quo_de = Quotations_detail::where('quo_id', $this->getQuoId())->get();
        foreach ($quo_de as $item) {
            if ($item->product != null) {
                $inv = new InventoryTransaction();
                $inv->inv_id = getNewInvTranPK();
                $inv->product_id = $item->product->product_id;
                $inv->sales_id = $item->quo_de_id;
                $inv->qty = -abs($item->product_qty);
                $inv->type = "SALE";
                $inv->branch_id = Branch::getCurrentId();
                $inv->save();
            }
        }
        $quo->save();

        systemLogs([
            'emp_id' => auth()->user()->getAuthIdentifier(),
            'cus_id' => $quo->cus_id,
            'emp_id2' => $quo->sale_id,
            'logs_type' => 'info',
            'logs_where' => 'Quotations',
            'description' => 'ขายคอร์ส/สินค้า เลขที่การซื้อ :' . $quo->quo_id
        ]);
        //dd($quo_de);
        return redirect("payment/history?cus_id=" . $quo->cus_id)
            ->with('quo_id', $quo->quo_id);

    }

    public function getCurrentSum()
    {
        $sum = DB::select(
            DB::raw("SELECT quotations_detail.quo_id, SUM(net_price) as Total
                     FROM quotations_detail
                     WHERE quo_id = " . $this->quo_id . ""));
        return $sum[0]->Total;
    }

    public function getDelete()
    {
        $id = Input::get('id');
        DB::table('quotations_detail')
            ->where('quo_de_id', "=", $id)
            ->delete();
    }

    public function getData()
    {
        /*$receivedItem = DB::table('quotations_detail')
            ->select('course.course_id', 'course_name')
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->where('quo_id', "=", $this->getQuoId())
            ->get();*/
        $receivedItem = Quotations_detail::with(['Course', 'Product'])->
        where('quo_id', "=", $this->getQuoId())->get();
        $data = [];
        foreach ($receivedItem as $item) {
            $array = [];
            $array['quo_id'] = $item->quo_id;
            $array['quo_de_id'] = $item->quo_de_id;

            if ($item->product != null) {
                $array['type'] = "product";
                $array['name'] = $item->product->product_name;
                $array['price'] = $item->product->product_price;
                $array['product_qty'] = $item->product_qty;
                $array['commission'] = 0;
            }
            if ($item->course != null) {
                $array['type'] = "course";
                $array['name'] = $item->course->course_name;
                $array['course_detail'] = $item->course->course_detail;
                $array['price'] = $item->course->course_price;
                $array['product_qty'] = 1;
                if ($item->course->commission == null) {
                    $array['commission'] = 0;
                } elseif ($item->course->commission != null) {
                    $array['commission'] = $item->course->commission;
                }
            }

            $array['quo_de_discount'] = $item->quo_de_discount;
            $array['quo_de_disamount'] = $item->quo_de_disamount;
            $array['quo_de_price'] = $item->quo_de_price;

            array_push($data, $array);
        }
        // dd($receivedItem);
        //return response()->json($receivedItem);
        return response()->json($data);
    }

    public function getUpdate()
    {
        $type = Input::get('type');
        $value = Input::get('value');
        $id = Input::get('id');
        $quo_detail = Quotations_detail::where('quo_de_id', "=", $id)
            ->get()
            ->first();
        $quo_detail->$type = $value;
        if ($type == 'quo_de_discount' || $type == 'quo_de_disamount' || $type == 'product_qty') {
            $course_price = ($quo_detail->quo_de_price - ($quo_detail->quo_de_price * $quo_detail->quo_de_discount / 100) - $quo_detail->quo_de_disamount) * $quo_detail->product_qty;
            $quo_detail->net_price = $course_price;
            $quo_detail->payment_remain = $course_price;
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

    private function commissionsCalculate()
    {
        $quo = Quotations::where('quo_id', '=', $this->quo_id)
            ->with("Quotations_detail.course")
            ->get()
            ->first();
        $saleId = $quo->sale_id;
        foreach ($quo->Quotations_detail as $item) {
            if ($item->course != null && $item->course->commission != null && $saleId != null) {
                $commission = new Commission();
                $commission->quo_de_id = $this->quo_id;
                $commission->emp_id = $saleId;
                $commission->commission = $item->course->commission;
                $commission->save();
            }
        }
    }

    public function  getUnitTest()
    {
        $this->quo_id = $this->getQuoId();
        $this->commissionsCalculate();

    }


}
