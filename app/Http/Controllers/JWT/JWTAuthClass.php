<?php

namespace App\Http\Controllers\JWT;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class JWTAuthClass
{
    private static $instance;

    private $iss='http://vm.index.com';

    private $aud='http://vm.b.com';

    private $uid;

    private $salt='qwe123asd321zxc456rty654fgh465vbn645jkluiopmn';

    private $token;

    private $decodetoken;


    /**
     *
     * @return mixed
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function uId($id){
        $this->uid = $id;
        return $this;
    }

    public function getToken(){
        $token = (string)$this->token;
        return $token;
    }

    public function setToken($token){
        $this->token = $token;
        return $this;
    }


     public function encode(){
        $time = time();
        $this->token = (new Builder())->setHeader('alg','HS256')
                                ->setIssuer($this->iss)                     // 服务签发者 服务端
                                ->setAudience($this->aud)                   //签发给谁 客户端
                                ->set('uid',$this->uid)                     // 设置用户ID
                                ->setIssuedAt($time)                        //设置创建时间
                                ->setExpiration($time + 3700)               //设置过期时间
                                ->sign(new Sha256(),$this->salt)            //设置盐值
                                ->getToken();
        return $this;
     }

    /**
     * 将token 强制转换为字符串
     * @return \Lcobucci\JWT\Token
     */
     public function decode(){
        if(!$this->decodetoken){
            $this->decodetoken = (new Parser())->parse((string)$this->token);
        }
        return $this->decodetoken;
     }

    /**
     * 验证 token 数据的有效性
     * @return bool
     */
     public function validate(){
        $data = new ValidationData();
         $data->setIssuer($this->iss);
         $data->setAudience($this->aud);
         return $this->decode()->validate($data);
     }

    /**
     * 鉴权
     */
     public function verify(){
        $result = $this->decode()->verify(new Sha256(),$this->salt);
        return $result;
     }

}
