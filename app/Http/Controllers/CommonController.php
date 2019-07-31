<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\ali_sms\SignatureHelper;

class CommonController extends Controller
{
    //
    function sendSms($tel , $code, $type = 1){
        $params = array();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = 'LTAIPE8OfHqma21u';
        $accessKeySecret = 'VUTc9AbwVQtNAivZCI6X1GYeKWRAKd';

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = 'layui';

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template

        #type==1 注册 2找回密码
        if($type=1){
            $params["TemplateCode"] = 'SMS_144853328';
        }else{
            $params["TemplateCode"] = 'SMS_144853328';
        }
//         fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array(
            "code" => $code,
            // "product" => "短信验证"
        );

        // fixme 可选: 设置发送短信流水号
        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        //include('third/aliyun/SignatureHelper.php');
        $helper = new SignatureHelper();
        //    var_dump($helper);exit;
        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
        if($content){
            return true;
        }else{
            return false;
        }
    }

    /*  随机生成短信发送的验证码**/
    function createCode(){
        $str='01234567890123456789123456789';
        $res=substr(str_shuffle($str),rand(0,15),6);
        return $res;
    }
}
