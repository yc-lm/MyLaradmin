<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 14:22
 */
namespace App\helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CommonHelper{

    //get请求
    public static function getMethod($api_url,$time_out=5){
        $client = new Client(['timeout'=>$time_out]);
        $res = $client->request('GET', $api_url);
        if($res->getStatusCode() == '200'){
            return $res->getBody();
        }else{
            Log::info($res);
        }
    }

    public static function postMethod($api_url,$data=[],$time_out=5){

    }
}