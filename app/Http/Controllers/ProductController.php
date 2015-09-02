<?php
/**
 * Created by PhpStorm.
 * User: Salmon
 * Date: 10/7/2558
 * Time: 1:45
 */

namespace App\Http\Controllers;

use App\Branch;
use App\Product;
use App\Product_group;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Zofe\Rapyd\Facades\DataForm;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataEdit;

class ProductController extends Controller
{
    public function expday()
    {

        $exp = DB::table('receive_detail')
            ->select('receive_detail.product_id', 'product.product_name', 'receive_detail.product_exp',
                DB::raw('DATEDIFF(receive_detail.product_exp,NOW()) as day'))
            ->join('product', 'product.product_id', '=', 'receive_detail.product_id')
            ->orderBy('receive_detail.product_exp', 'asc')
            ->get();

        //return response()->json($exp);

        return view("product/expday", ['exp' => $exp]);
    }


    public function stock()
    {
        $branch_id = Input::get('branch');
        $data = DB::table('inventory_transaction')
            ->select('branch.branch_name', 'product.product_id', 'product.product_name',
                DB::raw('Sum(inventory_transaction.qty) as total'))
            ->join('product', 'product.product_id', '=', 'inventory_transaction.product_id')
            ->join('branch', 'branch.branch_id', '=', 'inventory_transaction.branch_id');

       if ($branch_id > 0) {
            $data->where('inventory_transaction.branch_id', $branch_id);
        }
        $stock = $data->groupBy('product.product_id', 'branch.branch_name')
            ->orderBy('branch.branch_name', 'asc')
            ->get();

       // dd($branch_id);
        $branch = Branch::all();
        //return response()->json($data);
        return view('product/stock', compact('stock', 'branch'));
    }

    public function stockmanage()
    {
        $branch_id = Input::get('branch');
        $data = DB::table('inventory_transaction')
            ->select('branch.branch_name', 'product.product_id', 'product.product_name',
                DB::raw('Sum(inventory_transaction.qty) as total'))
            ->join('product', 'product.product_id', '=', 'inventory_transaction.product_id')
            ->join('branch', 'branch.branch_id', '=', 'inventory_transaction.branch_id');

        if ($branch_id > 0) {
            $data->where('inventory_transaction.branch_id', $branch_id);
        }
        $stock = $data->groupBy('product.product_id', 'branch.branch_name')
            ->orderBy('branch.branch_name', 'asc')
            ->get();

        // dd($branch_id);
        $branch = Branch::all();
        //return response()->json($data);
        return view('product/stockmanage', compact('stock', 'branch'));
    }


    public function getDataGrid()
    {
        $grid = DataGrid::source(Product::with('product_group'));
        $grid->attributes(array("class" => "table table-bordered", 'id' => 'product_table'));
        $grid->add('product_id', 'รหัสสินค้า');
        $grid->add('{{ $product_group->pg_name }}', 'กลุ่มสินค้า');
        $grid->add('product_name', 'ชื่อสินค้า');
        $grid->add('product_qty_order', 'Order point');

        $grid->add('product_price', 'ราคา/หน่วย');
        $grid->add('product_unit', 'หน่วยนับ');
        $grid->edit('/product/edit', 'กระทำ', 'show|modify|delete');

        return $grid;
    }

    public function grid()
    {

        $grid = $this->getDataGrid();

        return view('product/index', compact('grid'));
    }

    public function create()
    {
        $form = DataEdit::source(new Product());
        $form->text('product_id', 'รหัสสินค้า')->rule('required|unique:product,product_id')->attributes(array('placeholder' => 'โปรดระบุรหัสสินค้า....'));
        $form->add('pg_id', 'กลุ่มสินค้า', 'select')->options(Product_group::lists('pg_name', 'pg_id')->toarray())->rule('required');
        $form->text('product_name', 'ชื่อสินค้า')->rule('required')->attributes(array('rows' => 4, 'placeholder' => 'โปรดระบุชื่อสินค้า....'));

        $form->text('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ')->rule('required|integer')->attributes(array('placeholder' => 'โปรดระบุจำนวนสินค้าที่ถึงจุดสั่งซื้อ....'));
        $form->text('product_price', 'ราคาขาย')->rule('required|integer')->attributes(array('placeholder' => 'โปรดระบุราคา/หน่วย....'));
        $form->text('product_unit', 'หน่วยนับ')->rule('required')->attributes(array('placeholder' => 'โปรดระบุหน่วยนับ....'));
        $form->attributes(array("class" => " "));

        $form->saved(function () use ($form) {
            $user = new Product();
            $user->product_id = Input::get('product_id');
            $user->save();
            $form->message("เพิ่มข้อมูลเรียบร้อย");
            $form->link("product/index", "ย้อนกลับ");
            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product',
                'description'=>'เพิ่มสินค้า : รหัสสินค้า '.  $user->product_id
            ]);
        });

        return view('product/create', compact('form'));
    }

    public function edit()
    {
        if (Input::get('do_delete') == 1) return "not the first";

        $edit = DataEdit::source(new Product());
        $edit->text('product_id', 'รหัสสินค้า');

        $edit->text('product_name', 'ชื่อสินค้า');
        $edit->add('pg_id', 'กลุ่มสินค้า', 'select')->options(Product_group::lists('pg_name', 'pg_id')->toarray())->rule('required');
        $edit->text('product_qty_order', 'จำนวนสินค้าที่ถึงจุดสั่งซื้อ');
        $edit->text('product_price', 'ราคา/หน่วย');
        $edit->text('product_unit', 'หน่วยนับ');
        $edit->attributes(array("class" => " "));
        $edit->link("product/index", "ย้อนกลับ");
        $edit->saved(function () use ($edit) {

            systemLogs([
                'emp_id' => auth()->user()->getAuthIdentifier() ,
                'logs_type' => 'info' ,
                'logs_where'=>'Product',
                'description'=>'เพิ่มสินค้า : รหัสสินค้า '. Input::get('product_id')
            ]);
        });
        return $edit->view('product/edit', compact('edit'));
    }

}
