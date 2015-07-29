<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Order;
use App\Http\Requests;
use App\Product;
use Auth;

class OrderController extends Controller
{
    public function getIndex()
    {
        if (Order::where('order_status',"WAITING")->where('branch_id',Branch::getCurrentId())->count() == 0) {
            $order = new Order();
            $order->emp_id = Auth::user()->getAuthIdentifier();
            $order->branch_id =  Branch::getCurrentId();
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
            ->where('branch_id',Branch::getCurrentId())
            ->firstOrFail();
        return $quo->order_id;
    }
    public function getProductdata()
    {
        $query = '%' . \Input::get('q') . '%';
        $product = Product::
        where('product_id', 'LIKE', $query)
            ->orWhere('product_name', 'LIKE', $query)
            ->get();
        return response()->json($product);
    }
    public function getAddproduct()
    {
        $id = \Input::get('id');
        $rec = Order::find($this->getId());
        $product = Product::find($id);
        $rec->product()->attach($product, [
            'order_de_qty' => 0,
            'order_de_price'  =>$product->product_price,
            'order_de_discount'=>0,
            'order_de_disamount'=>0,
            'order_de_total'=>$product->product_price,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()

        ]);
        $status = "ok";
        return response()->json([
            'status' => $status,
        ]);

    }
    public function getSet_vender()
    {
        $cus_id = \Input::get('id');
        $quo = Order::findOrFail($this->getId());
        $quo->ven_id = $cus_id;
        $quo->save();
        return response()->json(['status' => 'success']);

    }


}
