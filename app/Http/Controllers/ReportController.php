<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    //ยอดขาย Sale
    public function reportsales()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                users.id,
                users.name,
                SUM(quo_de_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id = quotations_detail.course_id
                INNER JOIN quotations ON quotations.quo_id = quotations_detail.quo_id
                INNER JOIN users ON quotations.sale_id = users.id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015 AND users.position_id = 1
                GROUP BY
                quotations.sale_id
                ORDER BY Total DESC
                   ")));

    }

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
        if($rang != null){
            $sales->whereBetween('quotations_detail.created_at', [$date[0], $date[1]]);
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
    public function reportCourseMonth()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                course.course_id,
                course.course_name AS coursename,
                SUM(quo_de_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id =quotations_detail.course_id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015
                GROUP BY
                coursename
                   ")));
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
            $coursemonth->whereBetween('quotations_detail.created_at', [$date[0], $date[1]]);
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
            ->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
        if ($rang != null) {
            $coursehot->whereBetween('quotations_detail.created_at', [$date[0], $date[1]]);
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

    //ยอดขายแพทย์
    public function reportDoctor()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                users.id,
                users.name,
                SUM(quo_de_price) as Total
                FROM
                quotations_detail

                INNER JOIN course ON course.course_id = quotations_detail.course_id
                INNER JOIN quotations ON quotations.quo_id = quotations_detail.quo_id
                INNER JOIN users ON quotations.sale_id = users.id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015 AND users.position_id = 4
                GROUP BY
                quotations.sale_id
                ORDER BY Total DESC
                   ")));
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
            $doctor->whereBetween('quotations_detail.created_at', [$date[0], $date[1]]);
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