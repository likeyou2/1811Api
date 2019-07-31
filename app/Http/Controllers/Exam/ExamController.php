<?php

namespace App\Http\Controllers\Exam;

use App\Model\StudentModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    //
    public function login(Request $request){

        $username = $request->username;
        $pwd = $request->pwd;

        $method = 'AES-128-CBC';
        $key = '1';

        $options = OPENSSL_RAW_DATA;
        $iv = 'qwertyuiopasdfgh';
        $enName = openssl_encrypt($username,$method,$key,$options,$iv);
        $enPwd = openssl_encrypt($pwd,$method,$key,$options,$iv);

        $username = openssl_decrypt($enName,$method,$key,$options,$iv);
        $pwd = openssl_decrypt($enPwd,$method,$key,$options,$iv);

        $tokenTime = $request->tokenTime?3600:$request->tokenTime;
        $ip = $_SERVER['REMOTE_ADDR'];  //记录客户端IP
        $ip = Redis::incr($ip);
        Redis::expire($ip,60);
        if($ip > 21){
            $request = [
                'code' => 40004,
                'msg' => '调用接口上线',
                'data' => [],
            ];
            echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
        }else{
            if($username == "" || $pwd == ""){
                $request = [
                    'code' => 40000,
                    'msg' => '内容 不能为空',
                    'data' => [],
                ];
                echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
            }else{
                $studentData = StudentModel::where('username',$username)->first();
                if(empty($studentData)){
                    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];  //记录客户端IP
                    $num = Redis::incr($REMOTE_ADDR);
                    Redis::expire($REMOTE_ADDR,180);
                    if($num > 10 ){
                        $request = [
                            'code' => 40003,
                            'msg'  => '多次登陆失败请24小时再试',
                            'data' => []
                        ];
                        echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
                    }else{
                        $request = [
                            'code' => 40001,
                            'msg' => '用户不存在',
                            'REMOTE_ADDR' => $REMOTE_ADDR,  //记录客户端IP
                            'num' => $num,
                            'data' => [],
                        ];
                        echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
                    }
                }else{
                    if($pwd == $studentData->pwd){
                        $token = mb_substr( md5( $studentData->id.Str::random(8).mt_rand(11,999999) ) , 10 , 10 );
                        $redis_user_token_key = 'u:token:'.$studentData->id;  //token下标
                        Redis::setex($redis_user_token_key,$tokenTime,$token);
                        $request = [
                            'code' => 200,
                            'msg' => '登录成功',
                        ];
                        echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
                    }else{
                        $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];  //记录客户端IP
                        $num = Redis::incr($REMOTE_ADDR);
                        Redis::expire($REMOTE_ADDR,180);
                        if($num > 10 ){
                            $request = [
                                'code' => 40003,
                                'msg'  => '多次登陆失败请24小时再试',
                                'data' => []
                            ];
                            echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
                        }else{
                            $request = [
                                'code' => 40002,
                                'REMOTE_ADDR' => $REMOTE_ADDR,  //记录客户端IP
                                'num' => $num,
                                'msg' => '密码不正确',
                                'data' => [],
                            ];
                            echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
                        }

                    }
                }
            }
        }

    }

    public function quit(Request $request){
        $id = $request->id;
        if(empty($id)){
            $request = [
                "code"=>40005,
                "msg"=>"未登录,无法退出",
                "data"=>[]
            ];
            echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
        }//没有传输uid
        $first = StudentModel::where(['id'=>$id])->first();
        if(empty($first)){
            $request = [
                "code"=>40006,
                "msg"=>"非法的用户请求",
                "data"=>[]
            ];
            echo json_encode($request,JSON_UNESCAPED_UNICODE);die;
        }
        $ip = $_SERVER["REMOTE_ADDR"];
        $token = 'u:token:'.$id;
        Redis::del($ip);
        Redis::del($token);
        $request = [
            "code"=>200,
            "msg"=>"退出成功",
            "data"=>[]
        ];
        echo json_encode($request,JSON_UNESCAPED_UNICODE);die;

    }

    public function face(){
        return view('exam.face');
    }

    public function faceData(Request $request){
        $page = $request->page;
        $limit = $request->limit;
        $page = ($page -1 )* $limit

        $userData = UserModel::offset($page)->limit($limit)->get();
        $arr = [
            'code' => 0,
            'msg' => '',
            'count' => 1000,
            'data' => $userData
        ];
        return $arr;
    }
}
