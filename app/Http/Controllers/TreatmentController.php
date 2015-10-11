<?php
namespace App\Http\Controllers;

use App\Branch;
use App\Bt;
use App\InventoryTransaction;
use App\Medicine;
use App\Payment_detail;
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
        $course = Quotations::with('Quotations_detail.Course')
            ->where('cus_id', '=', $customerId)
            ->where('quo_status', '>=', 1)
            ->orderBy('quo_id', 'DESC')
            ->get();
        $data = [];

        foreach ($course as $item) {
            foreach ($item->quotations_detail as $quoDetail) {
                if ($quoDetail->Course != null) {
                    $array = null;
                    $array['quo_status'] = $item->quo_status;

                    //ข้อมูลการสั่งซื้อ และการรักษา
                    $array['quo_de_id'] = $quoDetail->quo_de_id;
                    $array['course_id'] = $quoDetail->course_id;
                    $array['qty'] = $quoDetail->qty;
                    $array['treat_status'] = $quoDetail->treat_status;
                    $array['payment_remain'] = (float)$quoDetail->payment_remain;

                    //ข้อมูลของคอร์ส
                    $array['course_name'] = $quoDetail->Course->course_name;
                    $array['course_qty'] = $quoDetail->Course->course_qty;
                    $array['course_detail'] = $quoDetail->Course->course_detail;

                    array_push($data, $array);

                }
            }
        }

        return response()->json($data);
    }

    public function save()
    {

        DB::transaction(function () {
            $input = \Input::all();
            $customer_id = Input::get('customer_id');
            $quo_de_id = Input::get('quo_de_id');

            $treat = new TreatHistory();
            $treat->treat_id = getNewTreatmentPK();
            $treat->quo_de_id = $quo_de_id;
            $treat->emp_id = Auth::user()->getAuthIdentifier();;
            $treat->comment = $input['comment'];
            $treat->treat_date = $input['treat_date'];
            $treat->branch_id = Branch::getCurrentId();
            $this->updateCourseQty($quo_de_id);
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

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier(),
                'logs_type' => 'info',
                'logs_where' => 'Treatment',
                'description' => 'การรักษา เลขที่การรักษา :' . $treat->treat_id
            ]);
        });
        if (Input::get('payment') == true) {
            return redirect("payment/history?cus_id=" . Input::get('customer_id') . "&quo_de_id=" . Input::get('quo_de_id'));
        } else {
            return redirect('treatment')->with('message', 'ลงบันทึกเรียบร้อยแล้ว');
        }

    }

    public function updateCourseQty($quo_de_id)
    {
        $treat_status = 1;
        $quo = Quotations_detail::with(['Course'])
            ->where('quo_de_id', '=', $quo_de_id)
            ->get()
            ->first();
        $course_qty = $quo->course->course_qty;
        $qty = $quo->qty + 1;
        if ($course_qty == $qty) {
            $treat_status = 5;
        }
        DB::table('quotations_detail')
            ->where('quo_de_id', '=', $quo_de_id)
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
        $quo_de_id = \Input::get('quo_de_id');
        $quo = Quotations_detail::with(['Course.course_medicine.product', 'Quotations.Customer'])
            ->where('quo_de_id', '=', $quo_de_id)
            ->get()
            ->first();
        $payment = Payment_detail::where("quo_de_id", "=", $quo_de_id)->get();
        $totalAmount = $payment->sum('amount');
        // dd($this->getMedicineRemain($quo->course_id));
        $medicines = $this->getMedicineRemain($quo->course_id);
        $course_id = $quo->course_id;
        $doctor = User::where('position_id', '=', 4)->get();
        $users = User::where('position_id', '=', 8)->get();
        //return response()->json($payment);
        return view('treatment.add', compact('quo', 'doctor', 'users', 'medicines', 'medic', 'course_id', 'payment', 'totalAmount'));
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