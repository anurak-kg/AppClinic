<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Customer;
use App\Product;
use App\Sales;
use App\Sales_detail;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SalesController extends Controller
{
    public function getIndex()
    {
        if (Sales::where('sales_status', "WAITING")->where('branch_id', Branch::getCurrentId())->count() == 0) {
            $sales = new Sales();
            $sales->emp_id = Auth::user()->getAuthIdentifier();
            $sales->branch_id = Branch::getCurrentId();
            $sales->sales_status = "WAITING";
            $sales->save();
            return $this->render();
        } else {
            return $this->render();
        }
    }
    private function render()
    {
        return view('sales.index', [
            'data' => Sales::findOrFail($this->getId())
        ]);
    }
    private function getId()
    {
        $quo = Sales::where('sales_status', "WAITING")
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->firstOrFail();
        return $quo->sales_id;
    }
    public function getSave()
    {
        $sales = Sales::find($this->getId());
        $sales->sales_total = $this->getTotal();
        $sales->sales_status = "CLOSE";
        // $order->quo_date = null;
        $sales->save();
        return redirect('sales')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }
    public function getTotal()
    {
        $sum = DB::table('sales_detail')
            ->select(DB::raw('SUM(sales_de_qty*sales_de_price) as total'))
            ->where('sales_id', $this->getId())
            ->get();
        return $sum[0]->total;
    }

    public function getProductdata()
    {
        $query = '%' . \Input::get('q') . '%';
        $product = Product::where('product_id', 'LIKE', $query)
            ->orWhere('product_name', 'LIKE', $query)
            ->get();
        return response()->json($product);
    }

    public function getUpdate()
    {
        $type = Input::get('type');
        $value = Input::get('value');
        $id = Input::get('id');
        $r = DB::table('sales_detail')
            ->where('sales_id', "=", $this->getId())
            ->where('product_id', "=", $id)
            ->update([$type => $value]);
        return response()->json(['status' => 'Success']);
    }

    public function getAddproduct()
    {
        $id = \Input::get('id');
        $rec = Sales::find($this->getId());
        $product = Product::find($id);
        $rec->product()->attach($product, [
            'sales_de_qty' => 1,
            'sales_de_price' => $product->product_price,
            'sales_de_discount' => 0, //ส่วนลดเปอร์เซ็น
            'sales_de_disamount' => 0, //ส่วนลดจำนวนเงิน
            'sales_de_total' => $product->product_price,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
        $status = "ok";
        return response()->json([
            'status' => $status,
        ]);

    }
    public function getDatacustomer()
    {
        //echo $this->getQuoId();
        $quo = Sales::find($this->getId());
        // dd($quo);
        $data = null;
        if ($quo->cus_id == 0) {
            $data['status'] = null;
        } else {
            $data['status'] = 'success';
            $customer = Customer::find($quo->cus_id);
            $data['cus_id'] = $customer->cus_id;

            $data['cus_name'] = $customer->cus_name;
            $data['tel'] = $customer->cus_tel;
        }
        return response()->json($data);
    }
    public function getRemovecustomer()
    {
        $quo = Sales::findOrFail($this->getId());
        $quo->cus_id = 0;
        $quo->save();
        return redirect('sales');
    }
    public function getData()
    {
        $data = sales_detail::with(['Product'])
            ->where('sales_id', "=", $this->getId())
            ->get();
        return response()->json($data);
    }

    public function getSetcustomer()
    {
        $cus_id = \Input::get('id');
        $quo = Sales::findOrFail($this->getId());
        $quo->cus_id = $cus_id;
        $quo->save();
        return response()->json(['status' => 'success']);
    }
    public function getDelete()
    {
        DB::table('sales_detail')
            ->where('sales_id', "=", $this->getId())
            ->where('product_id', "=", \Input::get('id'))
            ->delete();
    }
}
