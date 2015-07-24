<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

    public function reportsales()
    {
        $data = \DB::select((\DB::raw("
			SELECT  DAY(created_at) as 'Day',sale_price,cost_price,sale_price-cost_price as profit ,
			SUM(cost_price) as total_cost,
			SUM(sale_price)*qty as total_sale,
			SUM((sale_price-cost_price)*qty) as total_profit
			FROM
			sale_item
			WHERE MONTH(created_at) = 7
			GROUP BY
			DAY(created_at)")));
    }

    public function reportCourse(){
        $data = \DB::select((\DB::raw("
                    SELECT
                    DAY(quotations_detail.created_at),
                    SUM(course_price) as Total
                    FROM
                    quotations_detail
                    INNER JOIN course ON course.course_id =quotations_detail.course_id
                    WHERE MONTH(quotations_detail.created_at) = 7
                    GROUP BY
                    DAY(quotations_detail.created_at) ")));
    }

    public function reportCourseMonth() {
        $data = \DB::select((\DB::raw("
                SELECT
                course.course_name,
                SUM(course_price) as Total
                FROM
                quotations_detail
                INNER JOIN course ON course.course_id =quotations_detail.course_id
                WHERE MONTH(quotations_detail.created_at) = 7
                GROUP BY
                course.course_name
                   ")));

    }

    public function arrayToChartData($array,$name){
        $text = "[";
        foreach($array as $row ){
            $text .=  $row->$name .',';
        }
        $text .= ']';
        return $text;
    }
}
