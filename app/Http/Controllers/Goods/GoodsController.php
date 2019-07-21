<?php

namespace App\Http\Controllers\Goods;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    //
    public function details(Request $request){
        $goods_id = $request->goods_id;
        if(empty($goods_id)){
            $error = [
                'code' => 3000,
                'msg' => '未找到商品,非法请求',
                'data' => []
            ];
            echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
        }else{
            $goodsData = GoodsModel::where('goods_id',$goods_id)->first();
            if(empty($goodsData)){
                $error = [
                    'code' => 3001,
                    'msg' => '该商品已下线',
                    'data' => []
                ];
                echo json_encode($error,JSON_UNESCAPED_UNICODE);die;
            }else{
                $goodsData = GoodsModel::where('goods_id',$goods_id)->first()->toArray();
                $success = [
                    'code' => 200,
                    'msg' => 'success',
                    'data' => [
                        'goodsData'=>$goodsData,
                    ]
                ];
                echo json_encode($success,JSON_UNESCAPED_UNICODE);die;
            }
        }

    }
}
