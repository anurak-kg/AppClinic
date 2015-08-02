<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Order;
use App\User;
use App\Http\Requests;
use App\Order_detail;
use App\Product;
use App\Vendor;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Zofe\Rapyd\Facades\DataGrid;

class OrderController extends Controller
{
    public function history(){
        $order = DB::table('order')
            ->select('order.order_id', 'vendor.ven_name','users.name','order.order_date','order.order_total','order.order_status')
            ->join('users', 'order.emp_id', '=', 'users.id')
            ->join('vendor', 'order.ven_id', '=', 'vendor.ven_id')
            ->where('order.order_id', '=', 1);
        $data = $order->get();

       // return response()->json($data);

        return view('order/history', [
            'data' => $data,
        ]);
    }

    public function getIndex()
    {
        if (Order::where('order_status', "WAITING")->where('branch_id', Branch::getCurrentId())->count() == 0) {
            $order = new Order();
            $order->emp_id = Auth::user()->getAuthIdentifier();
            $order->branch_id = Branch::getCurrentId();
            $order->order_status = "WAITING";
            $order->save();
            return $this->render();
        } else {
            return $this->render();
        }
    }

    private function render()
    {
        return view('order.order', [
            'data' => Order::findOrFail($this->getId())
        ]);
    }

    private function getId()
    {
        $quo = Order::where('order_status', "WAITING")
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->firstOrFail();
        return $quo->order_id;
    }

    public function getSave()
    {
        $order = Order::find($this->getId());
        $order->order_total = $this->getTotal();
        $order->order_status = "PENDING";
        $order->order_date = \Carbon\Carbon::now()->toDateTimeString();
        // $order->quo_date = null;
        $order->save();
        return redirect('order')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }

    public function getTotal()
    {
        $sum = DB::table('order_detail')
            ->select(DB::raw('SUM(order_de_qty*order_de_price) as total'))
            ->where('order_id', $this->getId())
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
        $r = DB::table('order_detail')
            ->where('order_id', "=", $this->getId())
            ->where('product_id', "=", $id)
            ->update([$type => $value]);
        return response()->json(['status' => 'Success']);
    }

    public function getAddproduct()
    {
        $id = \Input::get('id');
        $rec = Order::find($this->getId());
        $product = Product::find($id);
        $rec->product()->attach($product, [
            'order_de_qty' => 1,
            'order_de_price' => $product->product_price,
            'order_de_discount' => 0,
            'order_de_disamount' => 0,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
        $status = "ok";
        return response()->json([
            'status' => $status,
        ]);

    }

    public function getData()
    {
        $data = Order_detail::with(['Product'])
            ->where('order_id', "=", $this->getId())
            ->get();
        return response()->json($data);
    }
    public function getDelete()
    {
        DB::table('order_detail')
            ->where('order_id', "=", $this->getId())
            ->where('product_id', "=", \Input::get('id'))
            ->delete();
    }

    public function getDatavendor()
    {
        //echo $this->getQuoId();
        $quo = Order::find($this->getId());
        // dd($quo);
        $data = null;
        if ($quo->ven_id == 0) {
            $data['status'] = -1;
        } else {
            $data = Vendor::find($quo->ven_id);

        }
        return response()->json($data);
    }

    public function getRemovevendor()
    {
        $quo = Order::findOrFail($this->getId());
        $quo->ven_id = 0;
        $quo->save();
        return redirect('order');
    }

    public function getSetvendor()
    {
        $ven_id = \Input::get('id');
        $quo = Order::findOrFail($this->getId());
        $quo->ven_id = $ven_id;
        $quo->save();
        return response()->json(['status' => 'success']);
    }

    private function arrayToChartData($data, $string)
    {
        $text = "[";
        foreach ($data as $row) {
            $text .= "'" . $row->$string . "'" . ',';
        }
        $text .= ']';
        return $text;
    }
}
