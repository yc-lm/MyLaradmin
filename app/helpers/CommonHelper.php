<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/7
 * Time: 14:22
 */
namespace App\helpers;
use GuzzleHttp\Client;
use Illuminate\Mail\Transport\LogTransport;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class CommonHelper{
    static $success_result = [];
    static $fail_result = [];
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

    public static function httpPool($urls,$time_out=10){
        $client = new Client();
        $requests = function ($total) use($urls,$time_out){

            for ($i = 0; $i < $total; $i++) {
                yield new Request('GET', $urls[$i],['timeout'=>$time_out]);
            }
        };

        $pool = new Pool($client, $requests(count($urls)), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index){
                // this is delivered each successful response
                $body = json_decode($response->getBody(),true);
                if(isset($body['code']) && $body['code']=='000000'){
                    array_push(self::$success_result,['index'=>$index,'response'=>$body['result']]);
                }else{
                    array_push(self::$fail_result,$index);//未成功返回也算失败
                }
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                array_push(self::$fail_result,$index);
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        return ['success'=>self::$success_result,'fail'=>self::$fail_result];
    }
}