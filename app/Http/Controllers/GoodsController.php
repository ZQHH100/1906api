<?php

namespace App\Http\Controllers;

use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\GoodsModel;
class GoodsController extends Controller
{
    public function goods(Request $request){
       $goods_id = $request->get('goods_id');
       $goods_key = 'str:goods:info:'.$goods_id;
       echo 'redis_key:'.$goods_key;echo "<br>";

       //判断是否有缓存信息
       $cache=Redis::get($goods_key);
      
       if($cache){
         echo "有缓存:";echo "<br>";
         //var_dump($cache);
         $goods_info=json_decode($cache,true);
         echo "<pre>";print_r($goods_info);echo "</pre>";
       }else{
        echo "无缓存:";echo "<br>";
        //去数据库中取数据,并保存在缓存中
        $goods_info =GoodsModel::where(['goods_id'=>$goods_id])->first();
        //echo "<pre>";print_r($goods_info);echo "</pre>";
        $arr=$goods_info->toArray();
        
        $j_goods_info=json_encode($arr);
         Redis::set($goods_key,$j_goods_info);
         Redis::expire($goods_key,5);
         echo "<pre>";print_r($goods_info);echo "</pre>";
       }

       die;


       echo "id:".$goods_id;echo "<br>";
       echo "商品名:Hello World";echo '<hr>';
    //    $name=$request->get('name');
       $ua = $_SERVER['HTTP_USER_AGENT'];
       $data=[
            'goods_id' => $goods_id,
          //  'name'=>$name,
            'ua' =>$ua,
            'ip' =>$_SERVER['REMOTE_ADDR'],
       ];
       $id = GoodsModel::insertGetId($data);
       
       $pv = GoodsModel::where(['goods_id'=>$goods_id])->count();
       echo "当前PV:".$pv;echo "<br>";

       //$uv = GoodsModel::select('ua')->where(['goods_id'=>$goods_id])->count();
      // echo "当前UV:".$uv;echo "<br>";
    }
}
