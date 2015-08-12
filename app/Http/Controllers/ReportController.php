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

    public function getDatSale()
    {

    }

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
        $data1 = $sales->take(4)->get();
        //dd($data);
        //return response()->json($data);
        if ($type == "excel") {
            Excel::create('Filename', function ($excel) use ($data) {

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
                'data1' => $data1,
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
        $salesdaycourse = DB::select(DB::raw(
            "
                SELECT
                (calendar.datefield) AS DATE,
                IFNULL(SUM(quotations.price),0) AS total_sales
                FROM
                quotations
                RIGHT JOIN calendar ON DATE(quotations.created_at) = calendar.datefield

                WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('" . $rang . "-01')) FROM quotations) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM quotations))

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
        if ($type == "excel") {
            Excel::create('Filename', function ($excel) use ($data) {

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
                    $sheet->loadView('report.excelsaleperday',['data'=>$data]);
                });

                $excel->sheet('Sheetname', function ($sheet) use ($data) {



                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelsaleperday',['data'=>$data]);
                });

            })->export('xls');
        } else {
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
            Excel::create('Filename', function ($excel) use ($data) {

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
        $data = $coursehot->take(10)->get();

        // return response()->json($data);

        if ($type == "excel") {
            Excel::create('Filename', function ($excel) use ($data) {

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
        $data = $producthot->take(10)->get();


        // return response()->json($data);
        if ($type == "excel") {
            Excel::create('Filename', function ($excel) use ($data) {

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
            Excel::create('Filename', function ($excel) use ($data) {

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