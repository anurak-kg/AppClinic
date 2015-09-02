<?php
namespace App\Http\Controllers;

use App\Branch;
use App\Bt;
use App\InventoryTransaction;
use App\Medicine;
use App\Product;
use App\Quotations_detail;
use App\TreatHasMedicine;
use App\TreatHistory;
use App\User;
use App\Quotations;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class TreatmentController extends Controller
{

    public function treatment()
    {
        return view("treatment/index");
    }

    public function getCourseData()
    {
        $customerId = \Input::get('id');
        $course = Quotations::with('course')
            ->where('cus_id', '=', $customerId)
            ->where('quo_status', '>=', 1)
            ->get();
        return response()->json($course);
    }

    public function save()
    {
        $input = \Input::all();
        $treat = new TreatHistory();
        $treat->treat_id= getNewTreatmentPK();
        $treat->course_id = $input['course_id'];
        $treat->quo_id = $input['quo_id'];
        $treat->emp_id = Auth::user()->getAuthIdentifier();;
        $treat->comment = $input['comment'];
        $treat->treat_date = $input['treat_date'];
        $treat->branch_id = Branch::getCurrentId();
        $this->updateCourseQty($input['quo_id'], $input['course_id']);
        //dd(Input::all());

        $treat->save();
        $array = $input['qty'];
        if (count($array) >= 1) {
            foreach ($array as $product_id => $qty) {
                $treat->product()->attach(Product::findOrFail($product_id), ['qty' => $qty]);
                $inv = new InventoryTransaction();
                $inv->inv_id = getNewInvTranPK();
                $inv->product_id = $product_id;
                $inv->treatment_id = $treat->treat_id;
                $inv->qty = -abs($qty);
                $inv->branch_id = Branch::getCurrentId();
                $inv->type = "Treatment";
                $inv->save();
            }
        }
        if (!empty($input['doctor'])) {
            $bt = new Bt;
            $bt->bt_id = getNewBtPK();
            $bt->treat_id = $treat->treat_id;
            $bt->emp_id = $input['doctor'];
            $bt->bt_type = 'doctor';
            $bt->total = $input['dr_price'];
            $bt->save();
        }
        if (!empty($input['bt1'])) {
            $bt = new Bt;
            $bt->bt_id = getNewBtPK();
            $bt->treat_id = $treat->treat_id;
            $bt->emp_id = $input['bt1'];
            $bt->bt_type = 'bt1';
            $bt->total = $input['bt1_price'];
            $bt->save();
        }
        if (!empty($input['bt2'])) {
            $bt = new Bt;
            $bt->bt_id = getNewBtPK();
            $bt->treat_id = $treat->treat_id;
            $bt->emp_id = $input['bt2'];
            $bt->bt_type = 'bt2';
            $bt->total = $input['bt2_price'];
            $bt->save();
        }
         if ($input['payment'] == 'true') {
             return redirect('payment/pay?quo_de_id=' . $input['quo_de_id']);
         }
         return redirect('treatment')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
    }

    public function updateCourseQty($quo_id, $course_id)
    {
        $treat_status = 1;
        $quo = Quotations_detail::with(['Course'])
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->get()
            ->first();
        $course_qty = $quo->course->course_qty;
        $qty = $quo->qty + 1;
        if ($course_qty == $qty) {
            $treat_status = 5;
        }
        $quo_detail = DB::table('quotations_detail')
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->update(['treat_status' => $treat_status, 'qty' => $qty]);
    }

    public function getProductList()
    {
        $product = $this->getMedicineAllData(6); // pg id หมวด 6
        //$product = Product::where('pg_id', '=' ,6)->get();

        return response()->json($product);
    }

    public function add()
    {
        $course_id = \Input::get('course_id');
        $quo_id = \Input::get('quo_id');
        $quo = Quotations_detail::with(['Course.course_medicine.product', 'Quotations.Customer', 'payment'])
            ->where('quo_id', '=', $quo_id)
            ->where('course_id', '=', $course_id)
            ->get()
            ->first();
        // dd($this->getMedicineRemain($quo->course_id));
        $medicines = $this->getMedicineRemain($quo->course_id);
        $doctor = User::where('position_id', '=', 4)->get();
        $users = User::where('position_id', '=', 8)->get();
        //return response()->json($quo);
        return view('treatment.add', compact('quo', 'doctor', 'users', 'medicines', 'medic', 'course_id'));
    }


    public function getMedicineRemain()
    {
        $courseId = \Input::get('courseId');
        $medicineData = DB::select(
            DB::raw(" SELECT
                        course_medicine.product_id as p_id,
                        product.product_name,
                        product.product_unit,

                        course_medicine.qty,
                        (SELECT SUM(inventory_transaction.qty)
                        FROM inventory_transaction
                        WHERE inventory_transaction.product_id = p_id and inventory_transaction.branch_id = " . Branch::getCurrentId() . " ) as remain
                        FROM
                        course_medicine
                        INNER JOIN product ON  product.product_id = course_medicine.product_id

                        WHERE
                        course_medicine.course_id LIKE '" . $courseId . "'"));
        return $medicineData;

    }

    private function getMedicineAllData($category)
    {
        $medicineData = DB::select(
            DB::raw(" SELECT product_id as p_id,product_name, product.product_unit,0 as qty,
        (SELECT SUM(inventory_transaction.qty)
        FROM inventory_transaction  Where inventory_transaction.product_id = product.product_id AND inventory_transaction.branch_id =  " . Branch::getCurrentId() . "
        ) as remain
         FROM
        product
        WHERE pg_id = " . $category . "

        "));
        return $medicineData;
    }

    public function getMedicineData()
    {
        $medicine = TreatHasMedicine::where('treat_medicine_id', Input::get('treat_medicine_id'))
            ->with('product')->get();
        $data = [];
        $index = 0;
        foreach ($medicine as $item) {
            $array['id'] = $index;
            $array['product_id'] = $item->product->product_id;
            $array['qty'] = $item->qty;
            $array['product_name'] = $item->product->product_name;
            array_push($data, $array);
            $index++;
        }
        return response()->json($data);
    }

    public function getMedicineAdd()
    {
        $medicine = new TreatHasMedicine();
        $medicine->treat_medicine_id = Input::get('treat_medicine_id');
        $medicine->treat_id = Input::get('treat_id');
        $medicine->product_id = Input::get('product_id');
        $medicine->qty = Input::get('qty');
        $medicine->save();
    }

    public function getMedicineRemove()
    {
        $medicine = TreatHasMedicine::where('treat_medicine_id', Input::get('treat_medicine_id'))
            ->where('product_id', Input::get('product_id'));
        $medicine->delete();
    }
}