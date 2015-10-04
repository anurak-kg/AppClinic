<?php

namespace App\Http\Controllers;

use App\Branch;
use App\InventoryTransaction;
use App\Product;
use App\Re_turn;
use App\Receive;
use App\return_detail;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ReturntostockController extends Controller
{
    public function getIndex()
    {
        $returnCount = Re_turn::where('return_status', "WAITING")
            ->where('branch_id', Branch::getCurrentId())
            ->where('emp_id',Auth::user()->getAuthIdentifier())
            ->where('return_type','=','request')
            ->count();
        if ($returnCount == 0) {
            $return = new Re_turn();
            $return->return_id = getNewReturnPK();
            $return->emp_id = Auth::user()->getAuthIdentifier();
            $return->branch_id = Branch::getCurrentId();
            $return->return_status = "WAITING";
            $return->return_type = "request";
            $return->save();
            return $this->render();
        } else {
            return $this->render();
        }
    }

    private function render()
    {
        $warehouse = Branch::where('branch_type','warehouse')->get();
        return view('returntostock.index', [
            'warehouse' => $warehouse,
            'data' => Re_turn::findOrFail($this->getId())
        ]);
    }

    private function getId()
    {
        $id = Re_turn::where('return_status', "WAITING")
            ->where('emp_id', Auth::user()->getAuthIdentifier())
            ->where('branch_id', Branch::getCurrentId())
            ->where('return_type','=','request')
            ->firstOrFail();
        return $id->return_id;
    }

    public function getSave()
    {
        $return = Re_turn::find($this->getId());
        $return->return_total = $this->getTotal();
        $return->return_date = \Carbon\Carbon::now()->toDateTimeString();
        // $order->quo_date = null;
        $return_detail = Return_detail::where('return_id',$this->getId())->get();
        foreach($return_detail as $item) {
            $inv = new InventoryTransaction();
            $inv->inv_id = getNewInvTranPK();
            $inv->product_id =  $item->product_id;
            $inv->return_id =  $item->return_id;
            $inv->qty =  -abs($item->return_de_qty);
            $inv->branch_id =  Branch::getCurrentId();
            $inv->type = "คืนสินค้ากลับคลังสินค้า";
            $inv->save();
        }

        $return->return_status = "CLOSE";
        $return->save();
        systemLogs([
            'emp_id' => auth()->user()->getAuthIdentifier() ,
            'logs_type' => 'info' ,
            'logs_where'=>'Return',
            'description'=>'คืนสินค้า เลขที่การคืน :' . $return->return_id
        ]);
        return redirect('returntostock')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }
    public function getWarehouse(){
        $id = Input::get('id');
        $order = Re_turn::find($this->getId());
        $order->warehouse_id = $id;
        $order->save();

        return response()->json(['status' => 'Success']);
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
            'return_de_qty' => 1,
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
