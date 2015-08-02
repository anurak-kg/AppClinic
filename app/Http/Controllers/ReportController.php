<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    //ยอดขาย Sale
    public function reportSalesTest()
    {
        $rang = \Input::get('rang');
        $date = explode('-', $rang);
        //var_dump($date);
        $sales = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id')
            ->where('users.position_id', '=', 1);
        if ($rang != null) {
            $start = Carbon::createFromFormat("Y/m/d",trim($date[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat("Y/m/d",trim($date[1]))->format('Y-m-d');
            $sales->whereRaw("DATE(quotations_detail.created_at) between ? and ?",[$start,$end]);
        }
        $sales
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc');
        $data = $sales->get();
        //return response()->json($date);
        return view('report/sale', [
            'data' => $data,
            'name' => $this->arrayToChartData($data, 'name'),
            'total' => $this->arrayToChartData($data, 'Total')
        ]);

    }


    public function reportCourseProduct()
    {
        /*  $data = \DB::select((\DB::raw("
                      SELECT
                      DAY(quotations_detail.created_at),
                      SUM(course_price) as Total
                      FROM
                      quotations_detail
                      INNER JOIN course ON course.course_id =quotations_detail.course_id
                      WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015
                      GROUP BY
                      DAY(quotations_detail.created_at) ")));*/
    }


    //ยอดขายพวกคอร์ต่างๆ ต่อเดือน
    public function reportCourseMonthTest()
    {
        $rang = \Input::get('rang');
        $date = explode('-', $rang);
        // var_dump($date);
        $coursemonth = DB::table('quotations_detail')
            ->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
        if ($rang != null) {
            $start = Carbon::createFromFormat("Y/m/d",trim($date[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat("Y/m/d",trim($date[1]))->format('Y-m-d');
            $coursemonth->whereRaw("DATE(quotations_detail.created_at) between ? and ?",[$start,$end]);
        }
        $coursemonth
            ->groupBy('coursename')->orderBy('Total', 'desc');
        $data = $coursemonth->get();

        return view('report/coursemonth', [
            'data' => $data,
            'name' => $this->arrayToChartData($data, 'coursename'),
            'total' => $this->arrayToChartData($data, 'Total')
        ]);

        //   return response()->json($coursemonth);
    }



    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHotTest()
    {
        $rang = \Input::get('rang');
        $date = explode('-', $rang);
        // var_dump($date);

        $coursehot = DB::table('quotations_detail')
            ->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('count(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
        if ($rang != null) {
            $start = Carbon::createFromFormat("Y/m/d",trim($date[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat("Y/m/d",trim($date[1]))->format('Y-m-d');
            $coursehot->whereRaw("DATE(quotations_detail.created_at) between ? and ?",[$start,$end]);
        }
        $coursehot->groupBy('coursename')->orderBy('Total', 'desc');
        $data = $coursehot->take(10)->get();

       // return response()->json($data);

        return view('report/coursehot', [
            'data' => $data,
            'name' => $this->arrayToChartData($data, 'coursename'),
            'total' => $this->arrayToChartData($data, 'Total')
        ]);
    }

    //สินค้าที่ขายดีที่สุด
    public function reportProductHot(){

        $rang = \Input::get('rang');
        $date = explode('-',$rang);
        //  var_dump([trim($date[0]),trim($date[1])]);
        $producthot = DB::table('sales_detail')
            ->select(DB::raw('product.product_name as productname'),DB::raw('count(sales_detail.sales_de_price) AS Total'))
            ->join('product','product.product_id','=','sales_detail.product_id');
             if ($rang != null) {
                 $start = Carbon::createFromFormat("Y/m/d",trim($date[0]))->format('Y-m-d');
                 $end = Carbon::createFromFormat("Y/m/d",trim($date[1]))->format('Y-m-d');
                 $producthot->whereRaw("DATE(sales_detail.created_at) between ? and ?",[$start,$end]);
             }
        $producthot->groupBy('productname')->orderBy('Total','desc');
         $data = $producthot->take(10)->get();

       // return response()->json($data);

        return view('report/producthot', [
            'data' => $data,
            'name' => $this->arrayToChartData($data, 'productname'),
            'total' => $this->arrayToChartData($data, 'Total')
        ]);

    }

    //ยอดขายแพทย์
    public function reportDoctorTest()
    {
        $doc = \Input::get('doc');
        $date = explode('-', $doc);
        // var_dump($date);

        $doctor = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id');
        if ($doc != null) {
            $start = Carbon::createFromFormat("Y/m/d",trim($date[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat("Y/m/d",trim($date[1]))->format('Y-m-d');
            $doctor->whereRaw("DATE(quotations_detail.created_at) between ? and ?",[$start,$end]);
        }
        $doctor->where('users.position_id', '=', 4)
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc');
        $data = $doctor->get();
        return view('report/doctor', [
            'data' => $data ,
            'name' => $this->arrayToChartData($data, 'name'),
            'total' => $this->arrayToChartData($data, 'Total')
        ]);
        // return response()->json($doctor);

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