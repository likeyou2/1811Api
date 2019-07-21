<?php

namespace App\Http\Middleware;

use App\Http\Controllers\JWT\JWTAuthClass;
use Closure;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->token;
        if($token){
            $jwt = JWTAuthClass::getInstance();
            $re = $jwt->setToken($token);
            if($jwt->verify() && $jwt->validate()){
                return $next($request);
            }else{
                $arr = [
                    'code' => 40002,
                    'msg' => '登录已失效，请重新登录',
                    'data' => []
                ];
                echo json_encode($arr,JSON_UNESCAPED_UNICODE);die;
            }
        }else{
            $arr = [
                'code' => 40001,
                'msg' => '缺少必要的参数',
                'data' => []
            ];
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);die;
        }

    }
}
