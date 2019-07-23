<?php

namespace App\Http\Controllers\work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
class WorkController extends Controller
{
    /**
     * App用户登录 页面
     */
    public function applogin()
    {
        return view('work/applogin');
    }

    /**
     * App用户登录 页面
     */
    public function pclogin()
    {
        return view('work/pclogin');
    }
    /**
     * 用户登录 执行方法
     */
    public function apploginDo()
    {
//        echo  11111;
        $data = request()->input();
//        dd($data);
        $res = Redis::get('pctoken'.$data['username']);
//        dd($res);
        if(!empty($res)){
            Redis::del('pctoken'.$data['username']);
            echo "<script>alert('你已经在PC端登陆是否继续登录?');location.href='http://wangxin.1811lar.com/app/login'</script>";
        }else{
            $userInfo = \DB::table('user')->where(['username'=>$data['username']])->first();
            if($userInfo) {
                if (md5($data['pwd']) != $userInfo->pwd) {
                    echo "密码错误！";
                    die;
                } else {
                     Redis::set('apptoken'.$data['username'],$userInfo,7200);
//                    dd($res);
                    $up =[
                        'status'=>2
                    ];
                    $res = \DB::table('user')->where(['u_id'=>$userInfo->u_id])->update($up);
//                    dd($res);
                    echo "<script>alert('登录成功！');location.href='http://wangxin.1811lar.com/app/list'</script>";
                }
            }
        }

    }
    public function pcloginDo()
    {
//        echo 22222;
        $data = request()->input();
//        dd($data);
        $userInfo = \DB::table('user')->where(['username'=>$data['username']])->first();
        $res = Redis::get('apptoken'.$data['username']);
//        dd($res);
        if(!empty($res)){
            Redis::del('apptoken'.$data['username']);
            echo "<script>alert('你已经在APP端登陆是否继续登录?');location.href='http://wangxin.1811lar.com/pc/login'</script>";

        }else{
            if($userInfo){
                if(md5($data['pwd']) != $userInfo->pwd){
                    echo "密码错误！";die;
                }else{
                    Redis::set('pctoken'.$data['username'],$userInfo,7200);
//                    dd($res);
                    $up =[
                        'status'=>1
                    ];
                    $res = \DB::table('user')->where(['u_id'=>$userInfo->u_id])->update($up);
//                    dd($res);
                    echo "<script>alert('登录成功！');location.href='http://wangxin.1811lar.com/app/list'</script>";
                }
            }
        }

    }


    /**
     * 用户列表  展示
     */
    public function list()
    {
        $userInfo = \DB::table('user')->get();
//        dd($userInfo);
        return view('work/list',['data'=>$userInfo]);
    }
}
