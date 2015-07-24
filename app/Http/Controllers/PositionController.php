<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;

class PositionController extends Controller
{
    public function index()
    {
        //
    }


    public function getDataGrid()
    {
        $grid = DataGrid::source(new Position());
        $grid->attributes(array("class"=>"table table-hover"));
        $grid->attributes(array("class"=>"table table-bordered"));
        $grid->add('position_id', 'ID',true);
        $grid->add('position_name', 'ชื่อต่ำแหน่ง',true);
        $grid->add('role','role');
        $grid->edit('/position/edit', 'กระทำ','modify|delete');

        $grid->paginate(10);
        return $grid;
    }
    public function grid(){

        $grid = $this->getDataGrid();
        $form = $this->create();
        $grid->row(function ($row) {
            if ($row->cell('position_id')) {
                $row->style("background-color:#EEEEEE");
            }
        });

        return view('position/index', compact('form','grid'));
    }


    public function create()
    {
       //
    }

    public function edit()
    {
        //

    }


}
