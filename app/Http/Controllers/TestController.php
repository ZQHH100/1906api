<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class TestController extends Controller
{
    public function testRedis(){
        $key = '1906';
        $val = 'hello world';
        Redis::set($key,$val);
        $value=Redis::get($key);
        echo 'value:'.$val;
    }
    public function test002(){
        echo "HELLO world zqhh";
    }
    public function test003(){
       $user_info = [
            'user_name' => 'zqhh',
            'email' => 'zqhh@qq.com',
            'age' => 11
       ];
       return $user_info;
    }
    public function getAccessToken(){
        $app_id='wxa6b3840740a4b135';
        $appsecret = 'd5338c1d3433874ccfe5ec0d548ce87d';
        $url= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        echo $url;
        echo "<br>";echo '<hr>';
        //使用file get contents 发起get请求
        $response = file_get_contents($url);
        var_dump($response);
        $arr = json_decode($response,true);
        echo "<pre>";print_r($arr);echo "</pre>";
    }
    public function curl1(){
        $app_id='wxa6b3840740a4b135';
        $appsecret = 'd5338c1d3433874ccfe5ec0d548ce87d';
        $url= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        //echo $url;

        // 初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //执行会话
        $response = curl_exec($ch);

        //关闭会话
        curl_close($ch);
        var_dump($response);

        
       // $arr = json_decode($response,true);
    
    }
    public function curl2(){
        $access_token='30_AwaIwNqOnosipNSWhVzIE1TWZXNiknCoUILYxOpikSysKEu8aUoG0YsbmnTPK5Ipx6eiE_K0txL_JL9ODuQi8DTVvwt82UDsTsQxvC2w2W3IeqNIG6XjdB2732AF446nkABrVLtZtb9yQ6bFYBVfAFAQTN';
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;

        $menu = [
            "button" => [
                [
                    "type" => "click",
                    "name" => "CURL",
                    "key"  => "curl001"
                ]
             ]
        ];
        // 初始化
        $ch = curl_init($url);

        //设置参数选项
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //POST请求
        curl_setopt($ch,CURLOPT_POST,true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type: application/json']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($menu));

          //执行会话
          $response = curl_exec($ch);
           
          //捕获错误
          //处理错误
          $errno = curl_errno($ch);
          $error = curl_error($ch);
          if($errno >0) 
          {
              echo "错误码:".$errno;echo "<br>";
              echo "错误信息:".$error;die;
              die;
          }

          //关闭会话
          curl_close($ch);
         
          //数据处理
          var_dump($response);

    }
    public function guzzle1(){
        $app_id='wxa6b3840740a4b135';
        $appsecret = 'd5338c1d3433874ccfe5ec0d548ce87d';
        $url= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret;
        $client = new Client();
        $response = $client->request('GET',$url);
        $data = $response->getBody();
        echo $data;
    }
    public function guzzle(){
        echo "<pre>";print_r($_SERVER);echo "</pre>";
    }
}
