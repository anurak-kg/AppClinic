<?php
namespace App\Http\Controllers;
use App\Branch;
use App\Customer;
use App\Payment_bank;
use App\Payment_detail;
use App\Quotations;
use App\Http\Requests;
use App\Quotations_detail;
use App\Sales;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Payment;
use Session;
class PaymentController extends Controller
{
    private $input;
    private $amount;
    private $quo_id;
    private $payment;
    private $quo_detail;
    private $minAmountPay;
    private $quo;
    private $quoDetail;
    private $totalPrice;
    private $vat = 0;
    private $sale;
    public function getIndex()
    {

        $id = null;
        if (Session::get('quo_id') != null) {
            $id = Session::get('quo_id');
        } else {
            $id = Input::get('quo_id');
        }
        $quo = Quotations::where('quo_id', $id)->with('course', 'Customer', 'Quotations_detail.payment')->get()->first();
        //dd($quo);
        // return response()->json($quo);
        return view('payment.payment', compact('quo'));
    }

    public function getHistory(){

        /*$course = DB::table('quotations_detail')
            ->select('course.course_name','course.course_qty','quotations_detail.net_price','quotations_detail.payment_remain',
                'payment.payment_status','quotations.vat','quotations.vat_rate','quotations.cus_id')
            ->join('course','quotations_detail.course_id','=','course.course_id')
            ->join('payment','quotations_detail.quo_de_id','=','payment.quo_de_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id')
            ->get();

        $sale = DB::table('sales_detail')
            ->select('product.product_name','product.product_price','sales_detail.sales_de_qty','sales.sales_total'
                ,'sales_detail.sales_id','sales.vat','sales.vat_rate')
            ->join('sales','sales_detail.sales_id','=','sales.sales_id')
            ->join('product','sales_detail.product_id','=','product.product_id')
            ->get();*/

        //dd($course);
        //return response()->json($course);
        $id = Input::get('cus_id');

        $quo = Quotations::where('cus_id', $id)->with('quotations_detail.course','quotations_detail.payment.payment_detail')
            ->get();
        //$sale = Customer::where('cus_id',$id)->with('sales.sales_detail.product','sales.sales_detail.payment')
        //   ->get();
        //dd($sale);
        //return response()->json($quo);
        return view('payment.paymenthistory', compact('quo'));
    }

    public function getSalePay()
    {
        $this->sale = Sales::findOrFail(Input::get('sale_id'));
        $saleController = new SalesController();
        $saleId = $saleController->getId();
        $type = Input::get('type');
        $this->payment = new Payment();
        $this->payment->payment_id = getNewPaymentPK();
        $this->payment->sales_id = $saleId;
        $this->payment->cus_id = $this->sale->cus_id;
        $total = DB::table('sales_detail')->where('sales_id', $saleId)->sum('sales_de_net_price');
        //$totalVat = $total * getConfig('vat_rate') /100;
        //$totalWithVat = $total + $totalVat;
        if ($type == 'cash') {
            $this->payment->payment_status = "FULLY_PAID";
            $this->payment->payment_type = 'PAID_IN_FULL';
            $this->payment->save();
            $this->totalPrice = $total;
            $this->saleVatCalculate();
            $this->saveCash();
            return redirect('sales/save');
        }
    }
    public function getPay()
    {
        $this->quo_detail = Quotations_detail::where('quo_de_id', Input::get('quo_de_id'))
            ->with('Course', 'Quotations')
            ->get()->first();
        $this->input['method'] = 'PAID_IN_FULL';
        $this->quo = Quotations::findOrFail($this->quo_detail->quo_id);
        $this->quo_id = $this->quo_detail->quo_id;
        $this->vatCalculate();
        $totalPrice = $this->quo_detail->net_price;
        $bank = Payment_bank::all();
        //return response()->json($quo);
        return view('payment.pay', [
            'quo' => $this->quo_detail,
            'totalPrice' => $totalPrice,
            'bank' => $bank]);
    }
    public function postPay()
    {
        $this->input = Input::all();
        if ($this->input['method'] == 'PAID_IN_FULL') {
            $this->savePaidInFull();
        } elseif ($this->input['method'] == 'PAY_BY_COURSE') {
            $this->savePayPerCourse();
        }elseif ($this->input['method'] == 'PAY_BY_Transfer') {
            $this->savePayPerCourse();
        }
        //var_dump($this->quo);
        // dump($this->totalPrice);
        // dd($this->input['method']);
        return redirect("payment" . "?quo_id=" . $this->quo_id)
            ->with(['headTxt' => 'เรียบร้อยแล้ว',
                    'message' => 'ลงบันทึกการชำระเงินเรียบร้อยแล้ว',
                    'quo_id' => $this->quo_id]
            );
    }
    private function vatCalculate()
    {
        if ($this->input['method'] == 'PAID_IN_FULL') {
            $this->totalPrice = (float)$this->quo_detail->payment_remain;
            if ($this->quo->vat == 'true') {
                $this->setVat(($this->quo_detail->payment_remain * $this->quo->vat_rate / 100));
            }
        } elseif ($this->input['method'] == 'PAY_BY_COURSE') {
            $this->totalPrice = (float)$this->quo_detail->net_price / $this->quo_detail->Course->course_qty;
            if ($this->quo->vat == 'true') {
                $this->setVat(($this->quo_detail->net_price / $this->quo_detail->Course->course_qty) * $this->quo->vat_rate / 100);
            }
        } elseif ($this->input['method'] == 'PAY_BY_Transfer') {
            $this->totalPrice = (float)$this->quo_detail->payment_remain;
            if ($this->quo->vat == 'true') {
                $this->setVat(($this->quo_detail->payment_remain * $this->quo->vat_rate / 100));
            }
        }
    }
    private function savePaidInFull()
    {
        $count = Payment::where('quo_de_id', $this->input['quo_de_id'])->count();
        if ($count == 0) {
            $this->quo_detail = Quotations_detail::where('quo_de_id', $this->input['quo_de_id'])
                ->where('course_id', $this->input['course_id'])->get()->first();
            $this->quo = Quotations::findOrFail($this->quo_detail->quo_id);
            $this->quo_id = $this->quo_detail->quo_id;
            $this->vatCalculate();
            /* ยังไม่ถูกต้อง
             * if ($this->quo_detail->payment_remain > $this->input['receivedAmount']) {
                abort(403, '400001 : ข้อมูลเงินสดไม่ถูกต้อง.');
            }*/
            if ($this->input['receivedAmount'] >= $this->totalPrice + $this->getVat()) {
                $this->amount = $this->totalPrice;
            } else {
                abort(405, '0x400002 : จำนวนเงินไม่พอ.');
            }
            $this->payment = new Payment();
            $this->payment->payment_id = getNewPaymentPK();
            $this->payment->quo_de_id = $this->input['quo_de_id'];
            $this->payment->cus_id = $this->quo->cus_id;
            $this->payment->payment_type = "PAID_IN_FULL";
            $this->payment->save();
            if ($this->input['type'] == "cash") {
                $this->saveCash();
            } elseif ($this->input['type'] == "credit_card") {
                $this->saveCredit();
            } elseif ($this->input['type'] == "transfer") {
                $this->saveTransfer();
            }
            $this->updateQuoPaymentStatus();
            $this->payment->save();
        } else {
            abort(405, '0x400003 : พบข้อผิดพลาดทางการเงิน.');
        }
    }
    private function savePayPerCourse()
    {
        $count = Payment::where('quo_de_id', $this->input['quo_de_id'])->count();
        $this->quo_detail = Quotations_detail::where('quo_de_id', $this->input['quo_de_id'])
            ->with('Course', 'Quotations')
            ->where('course_id', $this->input['course_id'])->get()->first();
        $this->quo = Quotations::findOrFail($this->quo_detail->quo_id);
        $this->quo_id = $this->quo_detail->quo_id;
        $this->vatCalculate();
        if ($this->input['receivedAmount'] >= $this->totalPrice + $this->getVat()) {
            $this->amount = $this->totalPrice;
        } else {
            abort(405, '0x400004 : จำนวนเงินไม่พอ');
        }
        if ($count == 0) {
            // dd($quo_detail);
            $this->quo_id = $this->quo_detail->quo_id;
            $this->payment = new Payment();
            $this->payment->payment_id = getNewPaymentPK();
            $this->payment->quo_de_id = $this->input['quo_de_id'];
            $this->payment->cus_id = $this->quo->cus_id;
            $this->payment->payment_type = "PAY_BY_COURSE";
            $this->payment->save();
        } else {
            $this->payment = Payment::where('quo_de_id', $this->input['quo_de_id'])->get()->first();
        }
        if ($this->input['type'] == "cash") {
            $this->saveCash();
        } elseif ($this->input['type'] == "credit_card") {
            $this->saveCredit();
        }elseif ($this->input['type'] == "transfer") {
            $this->saveTransfer();
        }
        $this->updateQuoPaymentStatus();
        $this->payment->save();
    }
    private function saveCash()
    {
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_de_id = getNewPaymentDetailPK();
        $paymentDetail->payment_type = 'CASH';
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->branch_id = Branch::getCurrentId();
        $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
        $paymentDetail->amount = $this->totalPrice;
        $paymentDetail->vat_amount = $this->getVat();
        $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->save();
    }
    private function saveCredit()
    {
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_de_id = getNewPaymentDetailPK();
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->payment_type = 'CREDIT';
        $paymentDetail->branch_id = Branch::getCurrentId();
        $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
        $paymentDetail->amount = $this->totalPrice;
        $paymentDetail->vat_amount = $this->getVat();
        $paymentDetail->bank_id = $this->input['bank_id'];
        $paymentDetail->card_id = $this->input['card_id'];
        $paymentDetail->edc_id = $this->input['edc'];
        $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->save();
    }
    private function saveTransfer()
    {
        $paymentDetail = new Payment_detail();
        $paymentDetail->payment_de_id = getNewPaymentDetailPK();
        $paymentDetail->payment_id = $this->payment->payment_id;
        $paymentDetail->payment_type = 'Transfer';
        $paymentDetail->branch_id = Branch::getCurrentId();
        $paymentDetail->emp_id = Auth::user()->getAuthIdentifier();
        $paymentDetail->amount = $this->totalPrice;
        $paymentDetail->vat_amount = $this->getVat();
        $paymentDetail->bank_id = $this->input['bank_id'];
        $paymentDetail->id_account = $this->input['id_account'];
        $paymentDetail->transfer_day = $this->input['transfer_day'];
        $paymentDetail->transfer_hour = $this->input['transfer_hour'];
        $paymentDetail->transfer_min = $this->input['transfer_min'];
        $paymentDetail->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $paymentDetail->save();
    }
    private function updateQuoPaymentStatus()
    {
        $quo_detail = Quotations_detail::find($this->input['quo_de_id']);
        $quo_detail->payment_remain = $quo_detail->payment_remain - $this->amount;
        if ($quo_detail->payment_remain <= 0) {
            $quo_detail->payment_remain = 0;
            $this->payment->payment_status = 'FULLY_PAID';
        } else {
            $this->payment->payment_status = 'REMAIN';
        }
        $this->payment->save();
        $quo_detail->save();
    }
    /**
     * @return mixed
     */
    public function getVat()
    {
        return $this->vat;
    }
    /**
     * @param mixed $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }
    private function saleVatCalculate()
    {
        if ($this->sale->vat == 'true') {
            $vat = $this->totalPrice * $this->sale->vat_rate / 100;
            $this->setVat($vat);
        }
    }
}