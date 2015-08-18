<?php

namespace App\Http\Controllers;

use App\Branch;
use App\InventoryTransaction;
use App\Order;
use App\Product;
use App\Re_turn;
use App\Receive;
use App\return_detail;
use App\Vendor;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReturnController extends Controller
{
    public function getIndex()
    {
        $returnCount = Re_turn::where('return_status', "WAITING")
            ->where('emp_id',Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->count();
        if ($returnCount == 0) {
            $return = new Re_turn();
            $return->emp_id = Auth::user()->getAuthIdentifier();
            $return->branch_id = Branch::getCurrentId();
            $return->return_status = "WAITING";
            $return->save();
            return $this->render();
        } else {
            return $this->render();
        }
    }

    private function render()
    {
        return view('return.index', [
            'data' => Re_turn::findOrFail($this->getId())
        ]);
    }

    private function getId()
    {
        $id = Re_turn::where('return_status', "WAITING")
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->firstOrFail();
        return $id->return_id;
    }

    public function getSave()
    {
        $return = Re_turn::find($this->getId());
        $return->return_total = $this->getTotal();
        $return->return_date = \Carbon\Carbon::now()->toDateTimeString();
        // $order->quo_date = null;
        if ( $return->receive_id != 0){
            $receive = Receive::find( $return->receive_id);
            $receive->receive_status = 'RETURN';
            $receive->save();
        }
        $return_detail = Return_detail::where('return_id',$this->getId())->get();
        foreach($return_detail as $item) {
            $inv = new InventoryTransaction();
            $inv->product_id =  $item->product_id;
            $inv->return_id =  $item->return_id;
            $inv->qty =  -abs($item->return_de_qty);
            $inv->branch_id =  Branch::getCurrentId();
            $inv->save();
        }

        $return->return_status = "CLOSE";
        $return->save();
        return redirect('return')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }

    public function getTotal()
    {
        $sum = DB::table('return_detail')
            ->select(DB::raw('SUM(return_de_qty * return_de_price) as total'))
            ->where('return_id', $this->getId())
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
        $r = DB::table('return_detail')
            ->where('return_id', "=", $this->getId())
            ->where('product_id', "=", $id)
            ->update([$type => $value]);
        return response()->json(['status' => 'Success']);
    }

    public function getAddproduct()
    {
        $id = \Input::get('id');
        $rec = Re_turn::find($this->getId());
        $product = Product::find($id);
        $rec->product()->attach($product, [
            'return_de_qty' => 1, //ส่วนลดเปอร์เซ็น
            'return_de_text' => "",
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
        $data = Return_detail::with(['Product'])
            ->where('return_id', "=", $this->getId())
            ->get();
        return response()->json($data);
    }

    public function getDatacustomer()
    {
        //echo $this->getQuoId();
        $quo = Re_turn::find($this->getId());
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
        $quo = Re_turn::findOrFail($this->getId());
        $quo->ven_id = 0;
        $quo->save();
        return redirect('return');
    }

    public function getReceivedata()
    {
        $id = Input::get('id');
        $receive = Receive::where('receive_id', $id)
            ->with('product')
            ->get()->first();

        DB::table('return_detail')
            ->where('return_id', $this->getId())
            ->delete();
        $return = Re_turn::findOrFail($this->getId());
        $return->ven_id = $receive->ven_id;
        $return->receive_id = $receive->receive_id;
        $return->order_id = $receive->order_id;
        $return->save();

        foreach ($receive->product as $item) {
            //echo $item->pg_id;
            $product = Product::findOrFail($item->product_id);
            $return->product()->attach($product, [
                'return_de_qty' => $item->pivot->receive_de_qty,
                'return_de_text' => "",
                'return_de_discount' => 0,
                'return_de_disamount' => 0,
                'return_de_price' => $item->pivot->receive_de_price,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);

        }

        return redirect('return');
    }

    public function getReceivesearch()
    {
        $query = '%' . \Input::get('q') . '%';
        $receive = Receive::where('receive_id', 'LIKE', $query)
            ->get();
        return response()->json($receive);
    }

    public function getSetcustomer()
    {
        $ven_id = \Input::get('id');
        $quo = Re_turn::findOrFail($this->getId());
        $quo->ven_id = $ven_id;
        $quo->save();
        return response()->json(['status' => 'success']);
    }

    public function getDelete()
    {
        DB::table('return_detail')
            ->where('return_id', "=", $this->getId())
            ->where('product_id', "=", \Input::get('id'))
            ->delete();

        return response()->json([
            'status' => "Success",
        ]);
    }
}
