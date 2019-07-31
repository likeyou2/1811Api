<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test','Test\TestController@test');
Route::get('/curl1','Test\TestController@curl1');
Route::get('/accessToken','Test\TestController@accessToken');
Route::get('/cuPost','Test\TestController@cuPost');
Route::post('/register','Test\TestController@register');
Route::get('/menu','Test\TestController@menu');
Route::get('/encryption','Test\TestController@encryption');  //加密
Route::get('/rsa','Test\TestController@rsa');  //非对称加密
Route::get('/st','Test\TestController@st');  //签名
Route::get('/pay','Test\TestController@pay');  //签名
Route::get('/test1','Test\TestController@test1');  //测试模板布局
Route::get('/test2','Test\TestController@test2');  //测试模板布局
Route::get('/exam','Test\TestController@exam');  //测试模板布局

Route::get('/getToken','Test\TestController@getToken');  //测试 获取jwttoken
Route::get('/zongheng','Test\TestController@zongheng');  //测试 扒网站
Route::get('/test/upload','Test\TestController@upload');  //测试 文件流传输
Route::post('/test/uploadDo','Test\TestController@uploadDo');  //测试 文件流传输
Route::get('/test/publicKey','Test\TestController@publicKey');  //测试 公钥加密数据
Route::get('/test/privateKey','Test\TestController@privateKey');  //测试 私钥解密数据


Route::get('/test/testLogin','Test\LoginTestController@testLogin');  //测试 私钥解密数据
Route::post('/test/testLoginDo','Test\LoginTestController@testLoginDo');  //测试 私钥解密数据


Route::post('/exam/login','Exam\ExamController@login');  //周考 登录接口
Route::post('/exam/quit','Exam\ExamController@quit');  //周考 退出接口
Route::get('/exam/kick','Exam\KickController@kick');  //周考 互踢功能
Route::get('/exam/face','Exam\ExamController@face');  //考
Route::get('/exam/facedata','Exam\ExamController@faceData');  //考





//Route::group(['prefix'=>'text','middleware'=>'jwtAuth'],function (){
    Route::get('check','Test\TestController@check')->middleware('jwtAuth');  //测试 验证jwttoken
//});


Route::get('/export','PhpExcel\PhpExcelController@export');  //测试模板布局

Route::post('/login/reg','Login\LoginController@reg');  //注册
Route::post('/login/login','Login\LoginController@login');  //登录
Route::post('/index/index','Index\IndexController@index');  //首页
Route::post('/goods/details','Goods\GoodsController@details');  //商品详情页
Route::post('/goods/addCart','Goods\CartController@addCart');  //加入购物车详情页
Route::post('/goods/cart','Goods\CartController@cart');  //加入购物车详情页




Route::resources([
    '/posts' => 'Student\StudentController',
]);
Route::get('phpinfo', function () {
    phpinfo();
});
