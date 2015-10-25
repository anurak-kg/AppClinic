<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mail;
use Redirect;
use Session;

class UpdateController extends Controller
{
    private $email = "imannn.99@gmail.com";
    private $urlServer = "";

    public function getSendEmailSummary()
    {
        sendEmailSummary();
    }

    public function getLicenseCheck()
    {
        return env('APP_KEY');

    }

    public function getLang(){
        echo $lang = \Input::get("lang");
       Session::put('language',$lang);
        return Redirect::back();
    }
}
