<?php

namespace Common\Library\Payment;

use Common\Library\Net\Curl;
use Common\Library\Payment\weixin\JsApiPay;
use Common\Library\Payment\weixin\WxPayUnifiedOrder;
use Common\Library\Payment\weixin\WxPayApi;
/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-9-9
 * @version
 */
class weixinMobile {

    public function init($payment) {
        define('WEIXIN_APPID', $payment['appid']);
        define('WEIXIN_MCHID', $payment['mchid']);
        define('WEIXIN_APPSECRET', $payment['appsecret']);
        define('WEIXIN_KEY',$payment['appkey']);
        //=======【证书路径设置】=====================================
        /**
         * TODO：设置商户证书路径
         * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
         * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
         * @var path
         */
        define('WEIXIN_SSLCERT_PATH', '../cert/apiclient_cert.pem');
        define('WEIXIN_SSLKEY_PATH', '../cert/apiclient_key.pem');

        //=======【curl代理设置】===================================
        /**
         * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
         * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
         * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
         * @var unknown_type
         */
        define('WEIXIN_CURL_PROXY_HOST', "0.0.0.0"); //"10.152.18.220";
        define('WEIXIN_CURL_PROXY_PORT', 0); //8080;
        //=======【上报信息配置】===================================
        /**
         * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
         * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
         * 开启错误上报。
         * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
         * @var int
         */
        define('WEIXIN_REPORT_LEVENL', 1);

        
        
        //require_once "weixin/WxPay.Notify.php";
        
    }

    public function getCode($logs, $payment) {
        
        $this->init($payment);
        //①、获取用户openid
        $tools = new JsApiPay();
       
//         $openId = $tools->GetOpenid();
        $openId = $_SESSION['openid'];
        
        if(empty($openId)){
            return false;
        }
      
        $input = new WxPayUnifiedOrder();
        $input->SetBody($logs['subject']);
        $input->SetAttach($logs['subject']);
        $input->SetOut_trade_no(date("YmdHis").'_'.$logs['logs_id']);
        //换算为分
        $logs['logs_amount'] = $logs['logs_amount'] *100;
        
        $input->SetTotal_fee("{$logs['logs_amount']}");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($logs['subject']);
        $input->SetNotify_url(__HOST__ . U( 'payment/respond', array('code' => 'weixin')));
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        
        $order = WxPayApi::unifiedOrder($input);
     //   echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        
        if($order['result_code'] == 'FAIL'){
            echo $order['err_code_des'];
            exit;
        }
        

        $jsApiParameters = $tools->GetJsApiParameters($order);
       
        $str = '<script>function jsApiCall()
	{
		WeixinJSBridge.invoke(
			\'getBrandWCPayRequest\',
			'.$jsApiParameters.',
			function(res){
                            if(res.err_msg ==\'get_brand_wcpay_request:ok\'){ 
                                location.href="'.U('Payment/payyes',array('log_id'=>$logs['logs_id'])).'";
                            }
                                
            				//WeixinJSBridge.log(res.err_msg);
                            //console.log(res);
            				//alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener(\'WeixinJSBridgeReady\', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent(\'WeixinJSBridgeReady\', jsApiCall); 
		        document.attachEvent(\'onWeixinJSBridgeReady\', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}</script>
        
<button   class="btn payment" type="button" onclick="callpay()" >立即支付</button>
        ';
        
        
        return $str;
    }

    public function respond() {
        
        $xml = file_get_contents("php://input");
        if (empty($xml))
            return false;
        $xml = new \SimpleXMLElement($xml);
        if (!$xml)
            return false;
        $data = array();
        foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
        }
       // file_put_contents('ccc.txt', var_export($data,true));
        if (empty($data['return_code']) || $data['return_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['result_code']) || $data['result_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['out_trade_no'])){
            return false;
        }
        ksort($data);
        reset($data);
        $payment = D('Payment')->getPayment('weixin');
        /* 检查支付的金额是否相符 */
        $tmp = explode('_', $data['out_trade_no']);
        if (!D('Payment')->checkMoney($tmp[1], $data['total_fee'])) {
            return false;
        }

        $sign = array();
        foreach ($data as $key => $val) {
            if ($key != 'sign') {
                $sign[] = $key . '=' . $val;
            }
        }
        $sign[] = 'key=' . $payment['appkey'];
        $signstr = strtoupper(md5(join('&', $sign)));
        if ($signstr != $data['sign']){
           
            return false;
        }    
        //D('Payment')->logsPaid($data['out_trade_no']);
        
        echo '验证';

        return true;
    }

}