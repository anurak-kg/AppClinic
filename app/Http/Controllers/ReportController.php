<?php

namespace App\Http\Controllers;

use App\Branch;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public $data1 = null;

    public function index(){
      return view('report/index');
    }

    //ยอดขาย Sale
    public function reportSalesGraphic()
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
            return view('report/saleGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }

    public function reportSalesDetail()
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
            return view('report/saleDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


    }


    //ยอดขายรายวัน
    public function reportsalesperdayGraphic()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        //var_dump($date);
        $dateTxt = [];

//        $salesdaycourse = DB::select(DB::raw(
//            "
//                SELECT
//                (calendar.datefield) AS DATE,
//                IFNULL(SUM(total_net_price),0) AS total_sales
//                FROM
//                quotations
//                RIGHT JOIN calendar ON DATE(quotations.created_at) = calendar.datefield
//
//                WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('".$rang ."-01')) FROM quotations) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM quotations))
//
//                GROUP BY DATE
//
//                ORDER BY DATE ASC
//            "
//            , [$rang, $rang]));

        $salesdaycourse = DB::table('quotations_detail')
            ->select(DB::raw('Sum(course.course_price) as Total'),DB::raw('date(quotations.created_at) AS DATE'))
            ->join('course','course.course_id','=','quotations_detail.course_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id');

        if ($rang != null) {
            $salesdaycourse->whereRaw("DATE(quotations.created_at) between ? and ?", [trim($date[0]), trim($date[0])]);
            $dateTxt['start'] = Date::createFromFormat('Y-m-d', trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');

        }

        $data = $salesdaycourse->get();


        $salesdaypro = DB::table('quotations_detail')
            ->select(DB::raw('sum(product.product_price) as Total'),DB::raw('date(quotations.created_at) AS DATE'))
            ->join('product','product.product_id','=','quotations_detail.product_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id');

        if ($rang != null) {
            $salesdaypro->whereRaw("DATE(quotations.created_at) between ? and ?", [trim($date[0]), trim($date[0])]);
            $dateTxt['start'] = Date::createFromFormat('Y-m-d', trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
        }

        $datapro = $salesdaypro->get();

//        $salesdaypro = DB::select(DB::raw(
//            "
//            SELECT
//            calendar.datefield AS DATE,
//            IFNULL(SUM(sales.sales_total),0) AS total_sales
//
//            FROM
//            sales
//            RIGHT JOIN calendar ON DATE(sales.created_at) = calendar.datefield
//            WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('" . $rang . "-01')) FROM sales) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM sales))
//            GROUP BY DATE
//
//            ORDER BY DATE ASC
//            "
//            , [$rang, $rang]));

//        return response()->json($data);


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
            return view('report/saleperdayGraphic', [
                'datapro' => $datapro,

                'total1' => $this->arrayToChartData($datapro, 'Total'),

                'data' => $data,

                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }

    //ยอดขายรายวัน
    public function reportsalesperdayDetail()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        //var_dump($date);
        $dateTxt = [];

//        $salesdaycourse = DB::select(DB::raw(
//            "
//                SELECT
//                (calendar.datefield) AS DATE,
//                IFNULL(SUM(total_net_price),0) AS total_sales
//                FROM
//                quotations
//                RIGHT JOIN calendar ON DATE(quotations.created_at) = calendar.datefield
//
//                WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('".$rang ."-01')) FROM quotations) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM quotations))
//
//                GROUP BY DATE
//
//                ORDER BY DATE ASC
//            "
//            , [$rang, $rang]));

        $salesdaycourse = DB::table('quotations_detail')
            ->select(DB::raw('Sum(course.course_price) as Total'),DB::raw('date(quotations.created_at) AS DATE'))
            ->join('course','course.course_id','=','quotations_detail.course_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id');

        if ($rang != null) {
            $salesdaycourse->whereRaw("DATE(quotations.created_at) between ? and ?", [trim($date[0]), trim($date[0])]);
            $dateTxt['start'] = Date::createFromFormat('Y-m-d', trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');

        }

        $data = $salesdaycourse->get();


        $salesdaypro = DB::table('quotations_detail')
            ->select(DB::raw('sum(product.product_price) as Total'),DB::raw('date(quotations.created_at) AS DATE'))
            ->join('product','product.product_id','=','quotations_detail.product_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id');

        if ($rang != null) {
            $salesdaypro->whereRaw("DATE(quotations.created_at) between ? and ?", [trim($date[0]), trim($date[0])]);
            $dateTxt['start'] = Date::createFromFormat('Y-m-d', trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
        }

        $datapro = $salesdaypro->get();

//        $salesdaypro = DB::select(DB::raw(
//            "
//            SELECT
//            calendar.datefield AS DATE,
//            IFNULL(SUM(sales.sales_total),0) AS total_sales
//
//            FROM
//            sales
//            RIGHT JOIN calendar ON DATE(sales.created_at) = calendar.datefield
//            WHERE (calendar.datefield BETWEEN (SELECT MIN(DATE('" . $rang . "-01')) FROM sales) AND (SELECT MAX(DATE(DATE('" . $rang . "-31'))) FROM sales))
//            GROUP BY DATE
//
//            ORDER BY DATE ASC
//            "
//            , [$rang, $rang]));

//        return response()->json($data);


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
            return view('report/saleperdayDetail', [
                'datapro' => $datapro,

                'total1' => $this->arrayToChartData($datapro, 'Total'),

                'data' => $data,

                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }



    //ยอดขายพวกคอร์ต่างๆ ต่อเดือน
    public function reportCourseMonthGraphic()
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
            return view('report/coursemonthGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


        //   return response()->json($coursemonth);
    }

    //ยอดขายพวกคอร์ต่างๆ ต่อเดือน
    public function reportCourseMonthDetail()
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
            return view('report/coursemonthDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


        //   return response()->json($coursemonth);
    }


    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHotGraphic()
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

         //return response()->json($coursehot);

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
            return view('report/coursehotGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }

    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHotDetail()
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

        //return response()->json($coursehot);

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
            return view('report/coursehotDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'coursename'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }
    }

    //สินค้าที่ขายดีที่สุด
    public function reportProductHotGraphic()
    {

        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);

        $dateTxt = [];
        //  var_dump([trim($date[0]),trim($date[1])]);
        $producthot = DB::table('quotations_detail')
            ->select(DB::raw('product.product_name as productname'), DB::raw('Sum(quotations_detail.product_qty) AS Total'))
            ->join('product', 'product.product_id', '=', 'quotations_detail.product_id');
        if ($rang != null) {
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
            $producthot->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
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
            return view('report/producthotGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'productname'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


    }

    //สินค้าที่ขายดีที่สุด
    public function reportProductHotDetail()
    {

        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);

        $dateTxt = [];
        //  var_dump([trim($date[0]),trim($date[1])]);
        $producthot = DB::table('quotations_detail')
            ->select(DB::raw('product.product_name as productname'), DB::raw('Sum(quotations_detail.product_qty) AS Total'))
            ->join('product', 'product.product_id', '=', 'quotations_detail.product_id');
        if ($rang != null) {
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
            $producthot->whereRaw("DATE(quotations_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
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
            return view('report/producthotDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'productname'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }


    }

    //ยอดขายแพทย์
    public function reportDoctorGraphic()
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
            return view('report/doctorGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //ยอดขายแพทย์
    public function reportDoctorDetail()
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
            return view('report/doctorDetail', [
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
    public function reportsuplierGraphic()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $suplier = DB::table('order')
            ->select('vendor.ven_name as name',DB::raw('SUM(if(vat = "false",order_total,order_total+(order_total*7/100))) as total'))
            ->join('vendor', 'vendor.ven_id', '=', 'order.ven_id');
        if ($rang != null) {
            $suplier->whereRaw("DATE(order.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
        }
        $suplier->groupBy('ven_name');

        $data = $suplier->get();

         //return response()->json($suplier);

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
            return view('report/suplierGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'total')
            ]);
        }

    }

    //รายจ่าย suplier
    public function reportsuplierDetail()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $suplier = DB::table('order')
            ->select('vendor.ven_name as name',DB::raw('SUM(if(vat = "false",order_total,order_total+(order_total*7/100))) as total'))
            ->join('vendor', 'vendor.ven_id', '=', 'order.ven_id');
        if ($rang != null) {
            $suplier->whereRaw("DATE(order.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
        }
        $suplier->groupBy('ven_name');

        $data = $suplier->get();

        //return response()->json($suplier);

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
            return view('report/suplierDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'total')
            ]);
        }

    }

    //รายได้ทั้งหมดจากลูกค้า แบ่งเป็น ประเภทการชำระเงิน
    public function reportCustomer_paymentGraphic()
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
            return view('report/customer_paymentGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //รายได้ทั้งหมดจากลูกค้า แบ่งเป็น ประเภทการชำระเงิน
    public function reportCustomer_paymentDetail()
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
            return view('report/customer_paymentDetail', [
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

//report คอมมิชชั่น ยอดขาย โอนเงิน
    public function reportCommissionTranfer()
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
            ->where('payment_detail.payment_type','=','Transfer');
        if ($rang != null) {
            $comcash->whereRaw("DATE(payment_detail.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $comcash->groupBy('name')->orderBy('Total', 'desc');

        $data = $comcash->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('สรุป Commission โอนเงิน', function ($excel) use ($data) {

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
                    $sheet->loadView('report.excelcommissionTranfer',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/commissionTransfer', [
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

    public function reportRequest(){
        $type = \Input::get('type');
        $branch_id = Input::get('branch');

        $data = DB::table('order')
                ->select('branch.branch_name','order.order_id','product.product_name','order_detail.order_de_qty','users.name',
                    DB::raw('date(`order`.created_at) as date'))
                ->join('order_detail','order_detail.order_id','=','order.order_id')
                ->join('product','product.product_id','=','order_detail.product_id')
                ->join('branch','branch.branch_id','=','order.branch_id')
                ->join('users','users.id','=','order.emp_id')
                ->where('order.order_type','=','request');
              if ($branch_id > 0) {
                  $data->where('order.branch_id', $branch_id);
              }
           $dataRe =  $data ->get();

        $branch = Branch::all();

        if ($type == "excel") {
            Excel::create('รายงานการเบิกสินค้า', function ($excel) use ($dataRe) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the settersp
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                $excel->sheet('Sheetname', function ($sheet) use ($dataRe) {

                    //dd($data);

                    $sheet->setStyle(array(
                        'font' => array(
                            'name'      =>  'Angsana new',
                            'size'      =>  18,
                            'bold'      =>  false
                        )
                    ));
                    $sheet->loadView('report.excelrequest',['data'=>$dataRe]);
                });


            })->export('xls');
        } else {
            return view('report/request',['data'=>$dataRe], compact('reportRequest', 'branch'));
        }



    }

    //report คอมมิชชั่น ยอดขาย Commission
    public function reportCommissionGraphic()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $comcash = DB::table('commission')
            ->select(DB::raw('users.name as name'),DB::raw('sum(commission.commission) as Total'))
            ->join('users','users.id','=','commission.emp_id');
        if ($rang != null) {
            $comcash->whereRaw("DATE(commission.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $comcash->groupBy('name');

        $data = $comcash->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('รายงาน Commission ', function ($excel) use ($data) {

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
                    $sheet->loadView('report.excelcommission',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/commisstionGraphic', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'Total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

    //report คอมมิชชั่น ยอดขาย Commission
    public function reportCommissionDetail()
    {
        $rang = \Input::get('rang');
        $type = \Input::get('type');
        $date = explode('to', $rang);
        // var_dump($date);
        $dateTxt = [];
        $comcash = DB::table('commission')
            ->select(DB::raw('users.name as name'),DB::raw('sum(commission.commission) as Total'))
            ->join('users','users.id','=','commission.emp_id');
        if ($rang != null) {
            $comcash->whereRaw("DATE(commission.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');

        }
        $comcash->groupBy('name');

        $data = $comcash->get();

        // return response()->json($doctor);

        if ($type == "excel") {
            Excel::create('รายงาน Commission ', function ($excel) use ($data) {

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
                    $sheet->loadView('report.excelcommission',['data'=>$data]);
                });


            })->export('xls');
        } else {
            return view('report/commisstionDetail', [
                'data' => $data,
                'date' => $dateTxt,
                'name' => $this->arrayToChartData($data, 'name'),
                'Total' => $this->arrayToChartData($data, 'Total')
            ]);
        }

    }

//    public function reportCommisstionSaleCourseType(){
//        $rang = \Input::get('rang');
//        $type = \Input::get('type');
//        $date = explode('to', $rang);
//        // var_dump($date);
//        $dateTxt = [];
//        $comcash = DB::table('quotations')
//            ->select(DB::raw('sum((SELECT
//            Sum((
//            CASE
//                WHEN quotations.sale2 Is NULL And quotations.sale3 Is NULL THEN course.commission
//                WHEN quotations.sale2 Is Not NULL And quotations.sale3 Is NULL THEN course.commission/2
//                WHEN quotations.sale2 Is Not NULL And quotations.sale3 Is Not NULL THEN course.commission/3
//            END
//                ))
//
//            FROM
//            quotations
//
//            where sale1
//            )) as com1,'),
////            DB::raw('sum((SELECT
////                 Sum((
////                    CASE
////                        WHEN quotations.sale3 Is NULL  THEN course.commission/2
////                        WHEN quotations.sale3 Is Not NULL  THEN course.commission/3
////
////                    END
////                    ))
////
////            FROM
////            quotations
////
////            where sale2
////
////
////            )) as com2,
////            '),
////             DB::raw('sum((SELECT
////
////                Sum(
////                (CASE
////                    WHEN quotations.sale1 Is not NULL and quotations.sale2 Is not NULL THEN course.commission/3
////                END)
////                )
////
////                FROM
////                quotations
////
////                where sale3
////
////
////                ) ) as com3,'),
////             DB::raw('course_type.name as Type')
////            )
//
//            ->join('users','users.id','=','commission.emp_id');
//        if ($rang != null) {
//            $comcash->whereRaw("DATE(commission.created_at) between ? and ?", [trim($date[0]), trim($date[1])]);
//            $dateTxt['start'] = Date::createFromFormat("Y-m-d", trim($date[0]))->format('l j F Y');
//            $dateTxt['end'] = Date::createFromFormat("Y-m-d", trim($date[1]))->format('l j F Y');
//
//        }
//        $comcash->groupBy('name');
//
//        $data = $comcash->get();
//
//        // return response()->json($doctor);
//
//        if ($type == "excel") {
//            Excel::create('รายงาน Commission ', function ($excel) use ($data) {
//
//                // Set the title
//                $excel->setTitle('Our new awesome title');
//
//                // Chain the settersp
//                $excel->setCreator('Maatwebsite')
//                    ->setCompany('Maatwebsite');
//
//                // Call them separately
//                $excel->setDescription('A demonstration to change the file properties');
//
//                $excel->sheet('Sheetname', function ($sheet) use ($data) {
//
//                    //dd($data);
//
//                    $sheet->setStyle(array(
//                        'font' => array(
//                            'name'      =>  'Angsana new',
//                            'size'      =>  18,
//                            'bold'      =>  false
//                        )
//                    ));
//                    $sheet->loadView('report.excelcommission',['data'=>$data]);
//                });
//
//
//            })->export('xls');
//        } else {
//            return view('report/commisstionDetail', [
//                'data' => $data,
//                'date' => $dateTxt,
//                'name' => $this->arrayToChartData($data, 'name'),
//                'Total' => $this->arrayToChartData($data, 'Total')
//            ]);
//        }
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
//SELECT
//
//sum((SELECT
//
//Sum((
//CASE
//WHEN quotations.sale2 Is NULL And quotations.sale3 Is NULL THEN course.commission
//WHEN quotations.sale2 Is Not NULL And quotations.sale3 Is NULL THEN course.commission/2
//WHEN quotations.sale2 Is Not NULL And quotations.sale3 Is Not NULL THEN course.commission/3
//END
//) )
//
//FROM
//quotations
//
//where sale1
//
//)) as com1,
//
//sum((SELECT
//
//Sum((
//CASE
//WHEN quotations.sale3 Is NULL  THEN course.commission/2
//WHEN quotations.sale3 Is Not NULL  THEN course.commission/3
//
//END
//) )
//
//FROM
//quotations
//
//where sale2
//
//
//)) as com2,
//
//sum((SELECT
//
//Sum(
//(CASE
//WHEN quotations.sale1 Is not NULL and quotations.sale2 Is not NULL THEN course.commission/3
//END)
//)
//
//FROM
//quotations
//
//where sale3
//
//
//) ) as com3,
//
//course.course_name,
//course_type.`name` as Type
//
//FROM
//quotations
//
//INNER JOIN quotations_detail ON quotations_detail.quo_id = quotations.quo_id
//INNER JOIN course ON course.course_id = quotations_detail.course_id
//LEFT OUTER JOIN course_type on course_type.ct_id = course.ct_id
//
//GROUP BY type
}