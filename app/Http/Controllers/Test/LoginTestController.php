<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginTestController extends Controller
{
    //
    public function testLogin(){
        return view('test.testLogin');
    }
    public function testLoginDo(Request $request){
        $tel = $request->tel;
        $code = new CommonController;
        var_dump($code);
    }
}
