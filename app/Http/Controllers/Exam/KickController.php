<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KickController extends Controller
{
    //
    public function kick(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,'Windows ')){

        }
    }
}
