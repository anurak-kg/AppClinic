<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function reportsales()
    {

    }

    public function reportCourseDay()
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

    public function reportCourseMonth()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                course.course_id,
                course.course_name,
                SUM(course_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id =quotations_detail.course_id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015
                GROUP BY
                course.course_name
                   ")));
    }

    public function reportCourseHot()
    {
        $data = \DB::select((\DB::raw("
                SELECT
                course.course_id,
                course.course_name,
                SUM(quo_de_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id =quotations_detail.course_id
                WHERE MONTH(quotations_detail.created_at) = 7 AND YEAR(quotations_detail.created_at) = 2015
                GROUP BY
                course.course_name
                ORDER BY Total DESC
                   ")));
    }

    public function reportDoctor() {
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

    public function reportDoctorTest() {
        $doctor = DB::table('quotations_detail')
            ->select('users.id','users.name',DB::raw('SUM(quo_de_price) as Total'))
            ->join('course','course.course_id','=','quotations_detail.course_id')
            ->join('quotations','quotations.quo_id','=','quotations_detail.quo_id')
            ->join('users','quotations.sale_id','=','users.id')
            ->whereRaw('MONTH(quotations_detail.created_at) = 7')
            ->whereRaw('YEAR(quotations_detail.created_at) = 2015')
            ->where('users.position_id','=',4)
            ->groupBy('quotations.sale_id')
            ->orderBy('Total','desc')
            ->get();
        return response()->json($doctor);
    }

    public function arrayToChartData($array, $name)
    {
        $text = "[";
        foreach ($array as $row) {
            $text .= $row->$name . ',';
        }
        $text .= ']';
        return $text;
    }
}
