<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class TranslateHandler
{
    //初始化配置信息
    private $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
    private $appid;
    private $key;

    //配置翻译方式
    private $from;
    private $to;

    public function __construct($from = 'zh', $to = 'en')
    {
        $this->appid = $_ENV['BAIDU_TRANSLATE_APPID'];
        $this->key = $_ENV['BAIDU_TRANSLATE_KEY'];
        $this->from = $from;
        $this->to = $to;
    }

    public function translate($text)
    {
        //如果没有配置百度翻译，自动使用兼容的拼音方案
        //按照个需，这里应该要有报错信息，API配置不全
        if (empty($this->appid) || empty($this->key)){
            return app(Pinyin::class)->permalink($text);
        }

        //实例化 HTTP 客户端
        $http = new Client;

        //发生 HTTP GET 请求
        $response = $http->get($this->query($text));

        //将获取到的结果（JSON格式的数据）通过解码获取其中的数据
        $result = json_decode($response->getBody(), true);
        if (isset($result['trans_result'][0]['dst']) && $result['trans_result'][0]['dst'] != ''){
            return $result['trans_result'][0]['dst'];
        }else{
            //如果百度翻译没有结果，使用拼音作为后备计划
            return app(Pinyin::class)->permalink($text);
        }
    }

    //创建请求语句
    private function query($text)
    {
        //根据百度翻译API文档，生成 sign
        //http://api.fanyi.baidu.com/api/trans/product/apidoc
        //appid+q+salt+密钥 的MD5值
        $salt = time();
        $sign = md5($this->appid . $text . $salt . $this->key);

        //构建请求参数
        $query = http_build_query([
            'q' => $text,
            'from' => $this->from,
            'to' => $this->to,
            'appid' => $this->appid,
            'salt' => $salt,
            'sign' => $sign,
        ]);

        return $this->api . $query;
    }
}
