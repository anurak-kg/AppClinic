<?php
namespace App\Http\Controllers;

use DB;

class HomeController extends Controller {

	public function dashboard(){

		$coursehot = DB::table('quotations_detail')
			->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('SUM(quo_de_price) as Total'))
			->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
		$coursehot->groupBy('coursename')->orderBy('Total', 'desc');
		$dataCourse = $coursehot->take(10)->get();
		$array = [];
		$data=[];
		foreach($dataCourse as $item){

			$array['value'] =  (float)$item->Total;
			$array['color'] =  '#' . strtoupper(dechex(rand(0,10000000)));
			$array['highlight'] =  '#' . strtoupper(dechex(rand(0,10000000)));
			$array['label'] = $item->coursename;
			array_push($data,$array);
		}

		$producthot = DB::table('sales_detail')
			->select(DB::raw('product.product_name as productname'),DB::raw('SUM(sales_detail.sales_de_price) AS Total'))
			->join('product','product.product_id','=','sales_detail.product_id');
		$producthot->groupBy('productname')->orderBy('Total','desc');
		$dataProduct = $producthot->take(10)->get();
		$array = [];
		$datapro=[];
		foreach($dataProduct as $item){

			$array['value'] =  (float)$item->Total;
			$array['color'] =  '#' . strtoupper(dechex(rand(0,10000000)));
			$array['highlight'] =  '#' . strtoupper(dechex(rand(0,10000000)));
			$array['label'] = $item->productname;
			array_push($datapro,$array);
		}

		//return response()->json($dataProduct);

		return view("dashboard",[
			'data' => $dataCourse ,
			'datapro' => $dataProduct ,
			'dataCourse' => json_encode($data),
			'dataProduct' => json_encode($datapro)
		]);
	}


}
