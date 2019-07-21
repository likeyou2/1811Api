<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\JWT\JWTAuthClass;
use App\Model\StudentModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public  function reg(Request $request){
        $regData = $request->input();
        if($regData['username'] == "" || $regData['pwd'] == "" || $regData['pwd_confirm'] == "" || $regData['email'] == ""){
            $error = [
                'code' => 40000,
                'msg' => '内容 不能为空',
                'data' => [],
            ];
            echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
        }else{
            if($regData['pwd'] == $regData['pwd_confirm']){
                unset($regData['pwd_confirm']);
                $regData['pwd'] = password_hash($regData['pwd'],PASSWORD_DEFAULT);
                $regData['addtime'] = time();
                $regData['status'] = 1;
                $userReg = UserModel::insertGetId($regData);
                if($userReg){
                    $success = [
                        'code' => 200,
                        'msg' => 'success 注册成功请等待跳转',
                        'data' => $userReg,
                    ];
                    echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
                }else{
                    $error = [
                        'code' => 40002,
                        'msg' => '注册失败请重新尝试',
                        'data' => [],
                    ];
                    echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
                }
            }else{
                $error = [
                    'code' => 40001,
                    'msg' => '请检查确认密码和密码是否一致',
                    'data' => [],
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }
        }

    }

    /**
     * 登录接口
     * @param Request $request
     */
    public function login(Request $request){
        $loginEmail = $request->email;
        $loginPwd = $request->pwd;

        if($loginEmail == "" || $loginPwd == ""){
            $error = [
                'code' => 40000,
                'msg' => '内容 不能为空',
                'data' => [],
            ];
            echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
        }else{
            $userData = UserModel::where('email',$loginEmail)->first();
            if(empty($userData)){
                $error = [
                    'code' => 40004,
                    'msg' => '用户不存在',
                    'data' => [],
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }else{
                if(password_verify($loginPwd,$userData->pwd)){
                    $tokenData = [
                        'id' => $userData->id,
                        'username' => $userData->username,
                        'time' => time(),
                        'expire' => time()+3600,
                        'salt' => env('SALT'),
                    ];
                    $serialize_token = serialize($tokenData);
                    $token = encrypt($serialize_token);
                    $error = [
                        'code' => 200,
                        'msg' => 'success 请等待跳转',
                        'data' => [
                            'token'=>$token,
                        ],
                    ];
                    echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
                }else{
                    $error = [
                        'code' => 40003,
                        'msg' => '密码不正确',
                        'data' => [],
                    ];
                    echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
                }
            }

        }
    }

}
