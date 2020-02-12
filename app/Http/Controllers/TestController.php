<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
}
