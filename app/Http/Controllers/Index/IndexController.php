<?php

namespace App\Http\Controllers\Index;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        $cookie = $request->cookie;
        $type = $request->type;
        if($type == 'type_cookie'){  //类型等于cookie 就
            if($cookie){
                //$cookie = substr($cookie,10);
                $decrypt_token = decrypt($cookie);
                $token = unserialize($decrypt_token);
                //var_dump($token);die;
                $success = [
                    'code' => 200,
                    'msg' => 'success',
                    'data' => [
                        'id' => $token['id'],
                        'username' => $token['username']
                    ]
                ];
                echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
            }else{
                $error = [
                    'code' => 20000,
                    'msg' => 'Token 到期请重新登录',
                    'data' => []
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }
        }else if($type == 'type_data'){
            $goodsData = GoodsModel::orderBy('createtime','desc')->limit(4)->get();
            if(count($goodsData)){
                $goodsData = GoodsModel::orderBy('createtime','desc')->limit(4)->get()->toArray();
                $success = [
                    'code' =>200,
                    'msg' => 'success',
                    'data' => [
                        'goodsData' => $goodsData
                    ]
                ];
                echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
            }else{
                $error = [
                    'code' =>20001,
                    'msg' => '没有最新的数据',
                    'data' => []
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }

        }else if ($type == 'type_top'){
            $goodsData = GoodsModel::orderBy('goods_ishot','desc')->limit(4)->get();
            if(count($goodsData)){
                $goodsData = GoodsModel::orderBy('goods_ishot','desc')->limit(4)->get()->toArray();
                $success = [
                    'code' =>200,
                    'msg' => 'success',
                    'data' => [
                        'goodsData' => $goodsData
                    ]
                ];
                echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
            }else{
                $error = [
                    'code' =>20002,
                    'msg' => '没有最热的数据',
                    'data' => []
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }
        }



    }
}
