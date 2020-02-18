<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class ApiFilter
{
   
    public function handle($request, Closure $next)
    {
        //echo "你是猪吗";echo "<br>";
       // echo date("Y-m-d H:i:s");die;
       $uri = $_SERVER['REQUEST_URI'];
       $ua = $_SERVER['HTTP_USER_AGENT'];

       $md5_ua = substr(md5($ua),5,8);
       $md5_uri = substr(md5($uri),5,8);
       
       $key = 'count:uri:'.$md5_uri.':'.$md5_ua;
       echo $key;echo '<br>';

       $count= Redis::get($key);
       echo "当前访问次数:".$count;echo '<br>';
       $max = env('API_ACCESS_COUNT');

       if($count > $max){
            $time=env('API_TIMEOUT_SECOND');
          echo "哦,我的上帝,请停止你那愚蠢的行为,地球人";echo "<br>";
          Redis::expire($key,$time);
          echo "请".$time.'秒后访问,蠢货';echo "<br>";
          
      }
      Redis::incr($key);
      echo '<hr>';

      return $next($request);
    }
}
