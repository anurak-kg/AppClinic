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
}
