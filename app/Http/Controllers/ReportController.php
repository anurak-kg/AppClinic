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

        $sales = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id')
            ->whereRaw('MONTH(quotations_detail.created_at) = ?', [7])
            ->whereRaw('YEAR(quotations_detail.created_at) = ?', [2015])
            ->where('users.position_id', '=',1)
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc')
            ->get();


        //return response()->json($sales);

        return view('report/sale', [
            'name' => $this->arrayToChartData($sales, 'name'),
            'total' => $this->arrayToChartData($sales, 'Total')
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

        $coursemonth = DB::table('quotations_detail')
            ->select('course.course_id',DB::raw('course.course_name as coursename'), DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            //->whereRaw('MONTH(quotations_detail.created_at) = ?', [7])
            //->whereRaw('YEAR(quotations_detail.created_at) = ?', [2015])
            ->whereBetween('quotations_detail.created_at', ['2012-03-11 00:00:00','2014-03-11 00:00:00'])
            ->groupBy('coursename')
            ->get();

        return view('report/coursemonth', [
            'name' => $this->arrayToChartData($coursemonth,'coursename'),
            'total' => $this->arrayToChartData($coursemonth,'Total')
        ]);

        //   return response()->json($coursemonth);
    }

    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHot()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                course.course_id,
                course.course_name as coursename,
                SUM(quo_de_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id =quotations_detail.course_id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015
                GROUP BY
                coursename
                ORDER BY Total DESC
                   ")));
    }


    //สรุปคอร์สที่ขายดีที่สุด
    public function reportCourseHotTest()
    {

        $coursehot = DB::table('quotations_detail')
            ->select('course.course_id',DB::raw('course.course_name as coursename'),DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->whereRaw('MONTH(quotations_detail.created_at) = 7')
            ->whereRaw('YEAR(quotations_detail.created_at) = 2015')
            ->groupBy('coursename')
            ->orderBy('Total', 'desc')
            ->get();

        return view('report/coursehot', [
            'name' => $this->arrayToChartData($coursehot, 'coursename'),
            'total' => $this->arrayToChartData($coursehot, 'Total')
        ]);
        //return response()->json($coursehot);
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

        $doctor = DB::table('quotations_detail')
            ->select('users.id', 'users.name', DB::raw('SUM(quo_de_price) as Total'))
            ->join('course', 'course.course_id', '=', 'quotations_detail.course_id')
            ->join('quotations', 'quotations.quo_id', '=', 'quotations_detail.quo_id')
            ->join('users', 'quotations.sale_id', '=', 'users.id')
            ->whereRaw('MONTH(quotations_detail.created_at) = 7')
            ->whereRaw('YEAR(quotations_detail.created_at) = 2015')
            ->where('users.position_id', '=', 4)
            ->groupBy('quotations.sale_id')
            ->orderBy('Total', 'desc')
            ->get();

        return view('report/doctor', [
            'name' => $this->arrayToChartData($doctor, 'name'),
            'total' => $this->arrayToChartData($doctor, 'Total')
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