<?php
namespace App\Http\Controllers;

use DB;

class HomeController extends Controller {



	public function dashboard()
	{

		$coursehot = DB::table('quotations_detail')
			->select('course.course_id', DB::raw('course.course_name as coursename'), DB::raw('count(quo_de_price) as Total'))
			->join('course', 'course.course_id', '=', 'quotations_detail.course_id');
		$coursehot->groupBy('coursename')->orderBy('Total', 'desc');
		$dataCourse = $coursehot->take(3)->get();
		$array = [];
		$data = [];
		foreach ($dataCourse as $item) {

				$array['value'] = (float)$item->Total;

				$array['color'] = '#' . strtoupper(dechex(rand(0, 10000000)));

				$array['highlight'] = $array['color'];

				$array['label'] = $item->coursename;
				array_push($data, $array);

			}

			$producthot = DB::table('sales_detail')
				->select(DB::raw('product.product_name as productname'), DB::raw('Sum(sales_detail.sales_de_qty) AS Total'))
				->join('product', 'product.product_id', '=', 'sales_detail.product_id');
			$producthot->groupBy('productname')->orderBy('Total','desc');
			$dataProduct = $producthot->take(3)->get();
			$array = [];
			$datapro = [];
			foreach ($dataProduct as $item) {

				$array['value'] = (float)$item->Total;
				$array['color'] = '#' . strtoupper(dechex(rand(0, 10000000)));
				$array['highlight'] = $array['color'];
				$array['label'] = $item->productname;
				array_push($datapro, $array);
			}

			//return response()->json($data);
		$exp = DB::table('receive_detail')
			->select('receive_detail.product_id','product.product_name','receive_detail.product_exp',
				DB::raw('DATEDIFF(receive_detail.product_exp,NOW()) as day'))
			->join('product','product.product_id','=','receive_detail.product_id')
			->having('day','<',30)
			->orderBy('receive_detail.product_exp','asc')
			->get();
			//return response()->json($exp);

		$stock = DB::table('inventory_transaction')
			->select('branch.branch_name','inventory_transaction.product_id','product.product_name',
				DB::raw('Sum(inventory_transaction.qty) as total'))
			->join('product','product.product_id','=','inventory_transaction.product_id')
			->join('branch','branch.branch_id','=','inventory_transaction.branch_id')
			->groupBy('inventory_transaction.product_id')
			->orderBy('Total','asc')
			->get();

			$order = DB::table('order')
				->select('order.order_id', 'vendor.ven_name', 'users.name', 'order.order_date', 'order.order_status')
				->join('users', 'order.emp_id', '=', 'users.id')
				->join('vendor', 'order.ven_id', '=', 'vendor.ven_id');

			$dataorder = $order->take(5)->get();

			// return response()->json($dataorder);

			return view("dashboard", [
				'data' => $data,
				'datapro' => $datapro,
				'exp' => $exp,
				'stock' => $stock,
				'dataorder' => $dataorder,
				'dataCourse' => json_encode($data),
				'dataProduct' => json_encode($datapro)
			]);
		}



}