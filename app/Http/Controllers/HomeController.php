<?php
namespace App\Http\Controllers;

use DB;

class HomeController extends Controller {

	public function dashboard(){

		$coursehot = DB::table('quotations_detail')
			->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('count(quo_de_price) as Total'))
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
			->select(DB::raw('product.product_name as productname'),DB::raw('count(sales_detail.sales_de_price) AS Total'))
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

		$exp = DB::table('inventory_transaction')
			->select('inventory_transaction.product_id','product.product_name','inventory_transaction.expiry_date',
				DB::raw('DATEDIFF(inventory_transaction.expiry_date,NOW()) as day'))
			->join('product','product.product_id','=','inventory_transaction.product_id')
			->having('day','<',30)
			->orderBy('inventory_transaction.expiry_date','desc')
			->get();
		//return response()->json($exp);

		$order = DB::table('order')
			->select('order.order_id', 'vendor.ven_name','users.name','order.order_date','order.order_status')
			->join('users', 'order.emp_id', '=', 'users.id')
			->join('vendor', 'order.ven_id', '=', 'vendor.ven_id')
			->where('order.order_id', '=', 1);
		$dataorder = $order->take(5)->get();

		// return response()->json($dataorder);

		return view("dashboard",[
			'data' => $dataCourse ,
			'datapro' => $dataProduct ,
			'exp'=>$exp,
			'dataorder'=>$dataorder,
			'dataCourse' => json_encode($data),
			'dataProduct' => json_encode($datapro)
		]);
	}




}
