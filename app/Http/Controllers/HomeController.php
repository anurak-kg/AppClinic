<?php
namespace App\Http\Controllers;

class HomeController extends Controller {

	public function dashboard(){
		return view("dashboard");
	}

}
