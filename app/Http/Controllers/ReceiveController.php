<?php

namespace App\Http\Controllers;


use App\Branch;
use App\Order;
use App\Product;
use App\Receive;
use App\Receive_detail;
use App\Vendor;
use Auth;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class ReceiveController extends Controller
{
    public function getIndex()
    {
        if (Receive::where('receive_status', "WAITING")->where('branch_id', Branch::getCurrentId())->count() == 0) {
            $receive = new Receive();
            $receive->emp_id = Auth::user()->getAuthIdentifier();
            $receive->branch_id = Branch::getCurrentId();
            $receive->receive_status = "WAITING";
            $receive->save();
            return $this->render();
        } else {
            return $this->render();
        }
    }

    private function render()
    {
        return view('receive.index', [
            'data' => Receive::findOrFail($this->getId())
        ]);
    }

    private function getId()
    {
        $id = Receive::where('receive_status', "WAITING")
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->firstOrFail();
        return $id->receive_id;
    }

    public function getSave()
    {
        $receive = Receive::find($this->getId());
        $receive->receive_total = $this->getTotal();
        $receive->receive_status = "CLOSE";
        $receive->receive_date = \Carbon\Carbon::now()->toDateTimeString();
        // $order->quo_date = null;
        if ( $receive->order_id != 0){
            $order = Order::find( $receive->order_id);
            $order->order_status = 'CLOSE';
            $order->save();
        }

        $receive->save();
        return redirect('receive')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }

    public function getTotal()
    {
        $sum = DB::table('receive_detail')
            ->select(DB::raw('SUM(receive_de_qty * receive_de_price) as total'))
            ->where('receive_id', $this->getId())
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
        $r = DB::table('receive_detail')
            ->where('receive_id', "=", $this->getId())
            ->where('product_id', "=", $id)
            ->update([$type => $value]);
        return response()->json(['status' => 'Success']);
    }

    public function getAddproduct()
    {
        $id = \Input::get('id');
        $rec = Receive::find($this->getId());
        $product = Product::find($id);
        $rec->product()->attach($product, [
            'receive_de_qty' => 1, //ส่วนลดเปอร์เซ็น
            'receive_de_qty_return' => 0, //ส่วนลดจำนวนเงิน
            'receive_de_text' => "",
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
        $data = Receive_detail::with(['Product'])
            ->where('receive_id', "=", $this->getId())
            ->get();
        return response()->json($data);
    }

    public function getDatacustomer()
    {
        //echo $this->getQuoId();
        $quo = Receive::find($this->getId());
        // dd($quo);
        $data = null;
        if ($quo->ven_id == 0) {
            $data['status'] = -1;
        } else {
            $data = Vendor::find($quo->ven_id);
        }
        return response()->json($data);
    }

    public function getRemovecustomer()
    {
        $quo = Receive::findOrFail($this->getId());
        $quo->ven_id = 0;
        $quo->save();
        return redirect('receive');
    }

    public function getOrderdata()
    {
        $id = Input::get('id');
        $order = Order::where('order_id', $id)
            ->with('product')
            ->get()->first();

        DB::table('receive_detail')
            ->where('receive_id', $this->getId())
            ->delete();
        $receive = Receive::findOrFail($this->getId());
        $receive->ven_id = $order->ven_id;
        $receive->order_id = $order->order_id;
        $receive->save();

        foreach ($order->product as $item) {
            //echo $item->pg_id;
            $product = Product::findOrFail($item->product_id);
            $receive->product()->attach($product, [
                'receive_de_qty' => $item->pivot->order_de_qty,
                'receive_de_qty_return' => 0,
                'receive_de_text' => "",
                'receive_de_disamount' => 0,
                'receive_de_discount' => 0,
                'receive_de_price' => $item->pivot->order_de_price,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }


        return redirect('receive');

    }

    public function getOrdersearch()
    {
        $query = '%' . \Input::get('q') . '%';
        $order = Order::where('order_id', 'LIKE', $query)
            ->get();
        return response()->json($order);
    }

    public function getSetcustomer()
    {
        $ven_id = \Input::get('id');
        $quo = Receive::findOrFail($this->getId());
        $quo->ven_id = $ven_id;
        $quo->save();
        return response()->json(['status' => 'success']);
    }

    public function getDelete()
    {
        DB::table('receive_detail')
            ->where('receive_id', "=", $this->getId())
            ->where('product_id', "=", \Input::get('id'))
            ->delete();

        return response()->json([
            'status' => "Success",
        ]);
    }
}
