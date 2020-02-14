<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class UserController extends Controller
{
    //获取用户信息
    public function info(){
        $user_info = [
             'user_name' => 'zqhh',
             'sex'       =>1,
             'email'     => 'zqhh@qq.com',
             'age'       => 11,
             'date'      =>date('Y-m-d H:i:s')
        ];
        return $user_info;
     }
     //用户注册
     public function reg(Request $request){
        
        $user_info = [
            'user_name' =>$request->input('user_name'),
            'email'     =>$request->input('email'),
            'pass'      =>'12345',
        ];
        //入库
        $id = UserModel::insertGetId($user_info);

        echo "自增id: ".$id;
     }
}
