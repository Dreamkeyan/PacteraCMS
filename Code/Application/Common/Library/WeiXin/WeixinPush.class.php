<?php

namespace Common\Library\WeiXin;

/**
 * 模板推送
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-11-9
 * @version
 */
class WeixinPush {

    protected $appid;
    protected $secrect;
    protected $accessToken = '';
    protected $config = array();
    protected $curl = null;
    protected $topcolor = '#7B68EE';

    function __construct() {
        $this->config = D('Setting')->fetchAll();
        $this->appid = $this->config['weixin']['appid'];
        $this->secrect = $this->config['weixin']['appsecret'];
        $this->accessToken = $this->getToken($this->appid, $this->secrect);
    }

    /**
     * 发送post请求
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init(); //初始化curl
//debug($ch,0);
        curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        return $data;
    }

    /**
     * curl post 和 get请求
     * @param string $url
     * @param array $data
     * @return bool
     */
    function https_request($url, $data = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 发送get请求
     * @param string $url
     * @return bool|mixed
     */
    function request_get($url = '') {
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $appid
     * @param $appsecret
     * @return mixed
     * 获取token
     */
    protected function getToken($appid, $appsecret) {
        if (S('access_token')) {
            $access_token = S('access_token');
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $token = $this->request_get($url);
            $token = json_decode(stripslashes($token));
            $arr = json_decode(json_encode($token), true);
            $access_token = $arr['access_token'];
            S('access_token', $access_token, 7200);
        }
        return $access_token;
    }

    /**
     * 发送自定义的模板消息
     * @param $touser
     * @param $template_id
     * @param $url
     * @param $data
     * @param string $topcolor
     * @return bool
     */
    public function doSends($touser, $data) {
        if (!empty($touser)) {
            foreach ($touser as $value) {
                $template = array(
                    'touser' => $value,
                    'template_id' => $data['template_id'],
                    'url' => $data['url'],
                    'topcolor' => $this->topcolor,
                    'data' => $data['info']
                );
                $json_template = json_encode($template);
                $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->accessToken;
                $dataRes[] = json_decode($this->https_request($url, urldecode($json_template)), true);
            }
        }
        foreach ($dataRes as $value) {
            if ($value['errcode'] == 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}
