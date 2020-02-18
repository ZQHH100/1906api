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
    public function count1(){
      //使用UA识别用户
      $ua=$_SERVER['HTTP_USER_AGENT'];
      //echo $ua;echo "<br>";
      $u = md5($ua);
     // echo "md5 ua:".$u;echo "<br>";
      $u =substr($u,5,5);
      //echo "u:".$u;echo "<br>";

      //限制次数
      $max = env('API_ACCESS_COUNT');

      //判断次数是否已到上限
      $key=$u.':count1';
      echo $key;echo "<br>";
      $number = Redis::get($key);
      echo "现有访问次数:".$number;echo "<br>";
       
      //超过上限
      if($number > $max){
        $timeout=env('API_TIMEOUT_SECOND');
        Redis::expire($key,$timeout);
          echo "接口访问受限,超过了访问次数".$max;echo "<br>";
          echo "请".$timeout.'秒后访问';echo "<br>";
          die;
      }
      //计数
      $count = Redis::incr($key);
      echo $count;echo "<br>";
      echo "访问正常";
    }

    public function api2(){
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u = md5($ua);
        $u =substr($u,5,5);
        echo "U:".$u;echo "<br>";
        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI:".$uri;echo "<br>";

        $md5_uri = substr(md5($uri),0,8);
        echo $md5_uri;echo "<br>";

        //$key = $u.':'.$md5_uri.':count';
        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key:'.$key;echo "<br>";

        echo '<hr>';
        $count=Redis::get($key);
        echo "当前接口计数:".$count;
        $max=env('API_ACCESS_COUNT');echo "<br>";//接口访问限制
        echo "接口最大访问次数".$max;echo "<br>";

        if($count>$max){
            echo "少年你在玩儿火";
            die;
        }
        Redis::incr($key);
    }
    public function api3(){
        $ua=$_SERVER['HTTP_USER_AGENT'];
        $u = md5($ua);
        $u =substr($u,5,5);
        echo "U:".$u;echo "<br>";
        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI:".$uri;echo "<br>";

        $md5_uri = substr(md5($uri),0,8);
        echo $md5_uri;echo "<br>";

        //$key = $u.':'.$md5_uri.':count';
        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key:'.$key;echo "<br>";

        echo '<hr>';
        $count=Redis::get($key);
        echo "当前接口计数:".$count;
        $max=env('API_ACCESS_COUNT');echo "<br>";//接口访问限制
        echo "接口最大访问次数".$max;echo "<br>";

        if($count>$max){
            echo "少年你在玩儿火";
            die;
        }
        Redis::incr($key);
    }
}
