<?php
namespace App\Http\Controllers;

class HomeController extends Controller {

	public function dashboard(){
		return view("dashboard");
	}
    public function test(){
        return view("test");
    }
    public function customer(){
        return view("customer");
    }
}
