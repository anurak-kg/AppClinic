<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public $data1 = null;



    //ยอดขาย Sale
    public function reportSalesTest()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        //var_dump($date);
        $dateTxt = [];
        $sales = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id')
            ->where('users.position_id', '=', 1);
        if ($rang != null) {
            $sales->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
        }
        $sales
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc');
        $data = $sales->get();
        //dd($data);
        //return response()->json($data);
        if ($type == "excel") {
            Excel::create('ยอดขายพนักงาน', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelsale',['data'=>$data]);
                });

            })->export('xls');
        } else {
            return view('report/sale', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


    }


    //ยอดขายรายวัน
    public function reportsalesperday()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        //var_dump($date);
        $dateTxt = [];
        if($rang == null){
           $rang = date('Y/m');
        }

        $salesdaycourse = DB::select(DB::raw(
            "
                SELECT
                (calendar.datefield) AS DATE,
                IFNULL(SUM(total_net_price),0) AS total_sales
                FROM
                quotations
                RIGHT JOIN calendar ON DATE(quotations.created_at) = calendar.datefield

                WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('".$rang ."-01')) FROM quotations) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM quotations))

                GROUP BY DATE

                ORDER BY DATE ASC
            "
            , [$rang, $rang]));

        $salesdaypro = DB::select(DB::raw(
            "
            SELECT
            calendar.datefield AS DATE,
            IFNULL(SUM(sales.sales_total),0) AS total_sales

            FROM
            sales
            RIGHT JOIN calendar ON DATE(sales.created_at) = calendar.datefield
            WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('" . $rang . "-01')) FROM sales) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM sales))
            GROUP BY DATE

            ORDER BY DATE ASC
            "
            , [$rang, $rang]));

        //return response()->json($salesdaypro);

        $data = $salesdaycourse;

        $datapro = $salesdaypro;

        //dd($data);

        if ($type == "excel") {
            Excel::create('ยอดขายคอร์สรายวัน', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelsaleperdaycourse',['data'=>$data]);
                });

            })->export('xls');
        } elseif ($type == "excel1") {
        Excel::create('ยอดขายสินค้ารายวัน', function ($excel) use ($datapro) {

            // Set the title
            $excel->setTitle('Our new awesome title');

            // Chain the settersp
            $excel->setCreator('Maatwebsite')
                ->setCompany('Maatwebsite');

            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Sheetname', function ($sheet) use ($datapro) {


                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Angsana new',
                        'size'      =>  18,
                        'bold'      =>  false
                    )
                ));
                $sheet->loadView('report.excelsaleperdayproduct',['datapro'=>$datapro]);
            });

        })->export('xls');
    }else {
            return view('report/salesperday', [
                'datapro' => $salesdaypro,
                'datapro1' => $salesdaypro,

                'total1' => $this->arrayToChartData($salesdaypro, 'total_sales'),

                'data' => $salesdaycourse,
                'data1' => $salesdaycourse,

                'name' => $this->arrayToChartData($salesdaycourse, 'DATE'),
                'total' => $this->arrayToChartData($salesdaycourse, 'total_sales')
            ]);
        }




    }


    //ยอดขายพวกคอร์ต่างๆ ต่อเดือน
    public function reportCourseMonthTest()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        $dateTxt = [];
        // var_dump($date);
        $coursemonth = DB::table('quotations_detail')
            ->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
        if ($rang != null) {
            $coursemonth->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
        }
        $coursemonth
            ->groupBy('coursename')->orderBy('Total', 'desc');
        $data = $coursemonth->get();

        if ($type == "excel") {
            Excel::create('ยอดขายคอร์ส', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelcoursemonth',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/coursemonth', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


        //   return response()->json($coursemonth);
    }


    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHotTest()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        //var_dump($date);
        $dateTxt = [];
        $coursehot = DB::table('quotations_detail')
            ->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('count(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
        if ($rang != null) {
            $coursehot->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $coursehot->groupBy('coursename')->orderBy('Total', 'desc');
        $data = $coursehot->get();

        // return response()->json($data);

        if ($type == "excel") {
            Excel::create('สรุปคอร์สที่ขายดีที่สุด', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelcoursehot',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/coursehot', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }

    //สินค้าที่ขายดีที่สุด
    public function reportProductHot()
    {

        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);

        $dateTxt = [];
        //  var_dump([trim($date[0]),trim($date[1])]);
        $producthot = DB::table('sales_detail')
            ->select(DB::raw('product.product_name as productname'), DB::raw('Sum(sales_detail.sales_de_qty) AS Total'))
            ->join('product', 'product.product_id', '=', 'sales_detail.product_id');
        if ($rang != null) {
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
            $producthot->whereRaw("DATE(sales_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
        }
        $producthot->groupBy('productname')->orderBy('Total', 'desc');
        $data = $producthot->get();


        // return response()->json($data);
        if ($type == "excel") {
            Excel::create('สรุปสินค้าที่ขายดีที่สุด', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {


                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelproducthot',['data'=>$data]);
                });

            })->export('xls');
        } else {
            return view('report/producthot', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'productname'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


    }

    //ยอดขายแพทย์
    public function reportDoctorTest()
    {
        $doc = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $doc);
        // var_dump($date);
        $dateTxt = [];
        $doctor = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id');
        if ($doc != null) {
            $doctor->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $doctor->where('users.position_id', '=', 4)
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc');
        $data = $doctor->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('ยอดขายแพทย์', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.exceldoctor',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/doctor', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

//    public function reportCustomerref(){
//        $ref = DB::table('customer')
//            ->select(DB::raw('customer.cus_reference as name'),DB::raw('(SELECT Count(customer.cus_reference) FROM customer WHERE customer.cus_reference = "Web Site" AND customer.cus_reference = name  ) as web')
//            ,DB::raw('(SELECT Count(customer.cus_reference) FROM customer WHERE customer.cus_reference = "Booth" AND customer.cus_reference = name ) as booth')
//            ,DB::raw('(SELECT Count(customer.cus_reference) FROM customer WHERE customer.cus_reference = "Offline" AND customer.cus_reference = name ) as offline '))
//           ->groupBy('name')
//            ->get();
//
//
//
//        return view('report/customer_ref', [
//            'ref' => $ref,
//
//            'name' => $this->arrayToChartData($ref, 'name'),
//            'web' => $this->arrayToChartData($ref, 'web'),
//            'booth' => $this->arrayToChartData($ref, 'booth'),
//            'offline' => $this->arrayToChartData($ref, 'offline'),
//
//
//        ]);
//    }

        //รายจ่าย suplier
    public function reportsuplier()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $suplier = DB::table('vendor')
            ->select('vendor.ven_name as name',DB::raw('SUM(order_total) as total'))
            ->join('order_detail', 'order_detail.order_id', '=', 'order_detail.order_id')
            ->join('order', 'order.order_id', '=', 'order.order_id');
        if ($rang != null) {
            $suplier->whereRaw("DATE(order.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $suplier->groupBy('ven_name')->orderBy('total', 'desc');

        $data = $suplier->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('สรุปรายจ่าย Suplier', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelsuplier',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/suplier', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //รายได้ทั้งหมดจากลูกค้า แบ่งเป็น ประเภทการชำระเงิน
    public function reportCustomer_payment()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $pay = DB::table('payment_detail')
            ->select('payment_detail.payment_type as name',DB::raw('Sum(payment_detail.amount+payment_detail.amount*7/100) AS Total'));
        if ($rang != null) {
            $pay->whereRaw("DATE(payment_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $pay->groupBy('name')->orderBy('Total', 'desc');

        $data = $pay->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('สรุปรายได้ทั้งหมดจากลูกค้า', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelcustomer_payment',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/customer_payment', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'Total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //report คอมมิชชั่น ยอดขาย เงินสด
    public function reportCommissionCash()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $comcash = DB::table('payment_detail')
            ->select(DB::raw('users.name as name'),'quotations.sale_id','payment_detail.payment_type',DB::raw('Sum(payment_detail.amount+payment_detail.amount*7/100) as Total'))
            ->join('quotations','quotations.quo_id','=','quotations.quo_id')
            ->join('users','users.id','=','quotations.sale_id')
            ->where('payment_detail.payment_type','=','CASH');
        if ($rang != null) {
            $comcash->whereRaw("DATE(payment_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $comcash->groupBy('name')->orderBy('Total', 'desc');

        $data = $comcash->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('สรุป Commission เงินสด', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelcommissionCash',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/commissionCash', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'Total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //report คอมมิชชั่น ยอดขาย Credit
    public function reportCommissionCredit()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $comcash = DB::table('payment_detail')
            ->select(DB::raw('users.name as name'),'quotations.sale_id','payment_detail.payment_type',DB::raw('Sum(payment_detail.amount+payment_detail.amount*7/100) as Total'))
            ->join('quotations','quotations.quo_id','=','quotations.quo_id')
            ->join('users','users.id','=','quotations.sale_id')
            ->where('payment_detail.payment_type','=','CREDIT');
        if ($rang != null) {
            $comcash->whereRaw("DATE(payment_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $comcash->groupBy('name')->orderBy('Total', 'desc');

        $data = $comcash->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('สรุป Commission Credit', function ($excel) use ($data) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($data) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelcommissionCredit',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/commissionCredit', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'Total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    public function arrayToChartData($db, $name)
    {
        $text = "[";
        foreach ($db as $row) {
            $text .= "'" . $row->$name . "'" . ',';
        }
        $text .= ']';
        return $text;
    }

}