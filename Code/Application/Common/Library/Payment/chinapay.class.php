<?php

namespace Common\Library\Payment;

class chinapay {

    // cvn2加密 1：加密 0:不加密

    private $_SDK_CVN2_ENC = 0;
// 有效期加密 1:加密 0:不加密
    private $_SDK_DATE_ENC = 0;
// 卡号加密 1：加密 0:不加密
    private $_SDK_PAN_ENC = 0;
// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
    private $_SDK_SIGN_CERT_PATH = 'D:/certs/PM_700000000000001_acp.pfx';
// 签名证书密码
    private $_SDK_SIGN_CERT_PWD = '000000';
// 密码加密证书（这条用不到的请随便配）
    private $_SDK_ENCRYPT_CERT_PATH = 'D:/certs/verify_sign_acp.cer';
// 验签证书路径（请配到文件夹，不要配到具体文件）
    private $_SDK_VERIFY_CERT_DIR = 'D:/certs/';
// 前台请求地址
    private $_SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';
// 后台请求地址
    private $_SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';

    private $_VERSION = '5.0.0'; //版本
    private $_CHARSET = 'utf-8';


    public function getCode($logs, $setting) {
        //这些值由后台配置
        $this->_SDK_SIGN_CERT_PATH = $setting['file'];
        $this->_SDK_SIGN_CERT_PWD = $setting['pwd'];
        $this->_SDK_ENCRYPT_CERT_PATH = $setting['pwdfile'];
        $this->_SDK_VERIFY_CERT_DIR = $setting['path'];

        $params = array(
            'version' => $this->_VERSION, //版本号
            'encoding' => $this->_CHARSET, //编码方式
            'certId' => $this->getCertId(), //证书ID
            'txnType' => '01', //交易类型	
            'txnSubType' => '01', //交易子类
            'bizType' => '000201', //业务类型
            'frontUrl' => __HOST__ . U('payment/respond', array('code' => 'chinapay')), //前台通知地址
            'backUrl' => __HOST__ . U('payment/respond', array('code' => 'chinapay')), //后台通知地址	
            'signMethod' => '01', //签名方法
            'channelType' => '07', //渠道类型，07-PC，08-手机
            'accessType' => '0', //接入类型
            'merId' => $setting['merid'], //商户代码，请改自己的测试商户号
            'orderId' => $logs['logs_id'], //商户订单号
            'txnTime' => date('YmdHis', NOW_TIME), //订单发送时间
            'txnAmt' => $logs['logs_amount'], //交易金额，单位分
            'currencyCode' => '156', //交易币种
            'defaultPayType' => '0001', //默认支付方式	
            'reqReserved' => $logs['subject'], //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );
        $this->_sign($params);

        return $this->_create_html($params, $this->_SDK_FRONT_TRANS_URL);
    }

    public function respond() {
        $payment = D('Payment')->getPayment($_GET['code']);
        if(empty($payment)) return false;
        $this->_SDK_SIGN_CERT_PATH = $payment['file'];
        $this->_SDK_SIGN_CERT_PWD = $payment['pwd'];
        $this->_SDK_ENCRYPT_CERT_PATH = $payment['pwdfile'];
        $this->_SDK_VERIFY_CERT_DIR = $payment['path'];
        
        
        unset($_GET['_URL_'],$_GET['code'],$_GET['g'],$_GET['m'],$_GET['a']);
        if(!empty($_GET)){
            foreach($_GET as $key=>$val){
                $_POST[$key] = $val;
            }
        }
        if (isset($_POST ['signature'])) {
            $public_key = $this->getPulbicKeyByCertId($params ['certId']);
            $signature_str = $params ['signature'];
            unset($params ['signature']);
            $params_str = $this->_coverParamsToString($params);
            $signature = base64_decode($signature_str);
            $params_sha1x16 = sha1($params_str, FALSE);

            $isSuccess = openssl_verify($params_sha1x16, $signature, $public_key, OPENSSL_ALGO_SHA1);

            if ($isSuccess) {
                D('Payment')->logsPaid($logs_id);
                return true;
            }
        }
        return false;
    }

    private function _getPulbicKeyByCertId($certId) {

        // 证书目录
        $cert_dir = $this->_SDK_VERIFY_CERT_DIR;
        $handle = opendir($cert_dir);
        if ($handle) {
            while ($file = readdir($handle)) {
                clearstatcache();
                $filePath = $cert_dir . '/' . $file;
                if (is_file($filePath)) {
                    if (pathinfo($file, PATHINFO_EXTENSION) == 'cer') {
                        if ($this->getCertIdByCerPath($filePath) == $certId) {
                            closedir($handle);
                            return $this->getPublicKey($filePath);
                        }
                    }
                }
            }
        }
        closedir($handle);
        return null;
    }

    private function _getPublicKey($cert_path) {
        return file_get_contents($cert_path);
    }

    private function _getCertIdByCerPath($cert_path) {
        $x509data = file_get_contents($cert_path);
        openssl_x509_read($x509data);
        $certdata = openssl_x509_parse($x509data);
        $cert_id = $certdata ['serialNumber'];
        return $cert_id;
    }

    private function _sign(&$params) {

        if (isset($params['transTempUrl'])) {
            unset($params['transTempUrl']);
        }
        // 转换成key=val&串
        $params_str = $this->_coverParamsToString($params);
        $params_sha1x16 = sha1($params_str, FALSE);
        // 签名证书路径
        $private_key = $this->getPrivateKey();
        // 签名
        $sign_falg = openssl_sign($params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1);

        $signature_base64 = base64_encode($signature);
        $params ['signature'] = $signature_base64;
    }

    private function _getPrivateKey() {
        $pkcs12 = file_get_contents($this->_SDK_SIGN_CERT_PATH);

        openssl_pkcs12_read($pkcs12, $certs, $this->_SDK_SIGN_CERT_PWD);
        return $certs ['pkey'];
    }

    private function _coverParamsToString($params) {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {
            if ($key == 'signature') {
                continue;
            }
            $sign_str .= sprintf("%s=%s&", $key, $val);
            // $sign_str .= $key . '=' . $val . '&';
        }
        return substr($sign_str, 0, strlen($sign_str) - 1);
    }

    private function _create_html($params, $action) {
        $encodeType = isset($params ['encoding']) ? $params ['encoding'] : 'UTF-8';
        $html = <<<eot
    <form id="pay_form" name="pay_form" action="{$action}" method="post">
	
eot;
        foreach ($params as $key => $value) {
            $html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
        }
        $html .= <<<eot
    <input type="submit"  class="payment" value=" 立刻支付 ">
    </form>
eot;
        return $html;
    }

    private function _getCertId() {
        $pkcs12certdata = file_get_contents($this->_SDK_SIGN_CERT_PATH);
        openssl_pkcs12_read($pkcs12certdata, $certs, $this->_SDK_SIGN_CERT_PWD);
        $x509data = $certs ['cert'];
        openssl_x509_read($x509data);
        $certdata = openssl_x509_parse($x509data);
        $cert_id = $certdata ['serialNumber'];
        return $cert_id;
    }

}