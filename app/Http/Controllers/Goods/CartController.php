<?php

namespace App\Http\Controllers\Goods;

use App\Model\CartModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //
    public function addCart(Request $request){
        $cookie = $request->cookie;
        $goods_id = $request->goods_id;
        $price = $request->price;
        if($cookie){
            //var_dump($cookie);die;
            $decrypt_token = decrypt($cookie);
            $token = unserialize($decrypt_token);
            $where = [
                'goods_id'=>$goods_id,
                'user_id'=>$token['id']
            ];
            $cartData = CartModel::where($where)->first();
            if(empty($cartData)){
                $arr = [
                    'user_id'=>$token['id'],
                    'goods_id'=>$goods_id,
                    'buy_number'=>1,
                    'create_time'=>time(),
                    'market_price' => $price,
                    'cart_status' => 1,
                ];
                $arr = CartModel::insertGetId($arr);
                if($arr){
                    $success = [
                        'code' => 200,
                        'msg' => 'success 添加成功请等待跳转',
                        'data' => []
                    ];
                    echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
                }else{
                    $error = [
                        'code' => 5001,
                        'msg' => '添加失败',
                        'data' => []
                    ];
                    echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
                }
            }else{
                $res = CartModel::where($where)->increment('buy_number');
                if($res){
                    $success = [
                        'code' => 200,
                        'msg' => 'success 添加成功请等待跳转',
                        'data' => []
                    ];
                    echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
                }else{
                    $error = [
                        'code' => 5001,
                        'msg' => '添加失败',
                        'data' => []
                    ];
                    echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
                }
            }
        }else{
            $error = [
                'code' => 5000,
                'msg' => '请先登录',
                'data' => []
            ];
            echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
        }
    }
    public function cart(Request $request){
        $cookie = $request->cookie;
        if($cookie) {
            //var_dump($cookie);die;
            $decrypt_token = decrypt($cookie);
            $token = unserialize($decrypt_token);
            $where = [
                'user_id' => $token['id'],
                'cart_status' => 1
            ];
            $cartData = CartModel::where($where)->get();
            if(count($cartData)){
                $cartData = CartModel::join('goods','goods.goods_id','=','shop_cart.goods_id')->where(['user_id'=>$token['id'],'cart_status'=>1])->first()->toArray();
                $success = [
                    'code' => 200,
                    'msg' => 'success',
                    'data' => [
                        'cartData'=>$cartData
                    ]
                ];
                echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
            }
        }else{
            $error = [
                'code' => 5000,
                'msg' => '请先登录',
                'data' => []
            ];
            echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
        }
    }
}
