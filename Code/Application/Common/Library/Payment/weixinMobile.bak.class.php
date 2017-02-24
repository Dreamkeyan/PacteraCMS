<?php

namespace Common\Library\Payment;

use Common\Library\Net\Curl;
/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-9-9
 * @version
 */
class weixinMobile {

    private $api = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    private $curl = '';

    public function __construct() {
        $this->curl = new Curl();
    }

    public function getCode($logs, $payment) {

        $params = array(
            'openid' => session('openid'),
            'appid' => $payment['appid'],
            'mch_id' => $payment['mchid'] ,
//             'nonce_str' => md5(uniqid()),
            'nonce_str' => $this->createNoncestr(),
            //'body' => $payment['subject'],
            'body' => $logs['subject'],
            'attach' => $logs['subject'],
            'goods_tag' => $logs['subject'],
            //'out_trade_no' => $payment['logs_id'],
            'out_trade_no' => date('YmdHis').$logs['logs_id'],
            //'total_fee' => $payment['logs_amount'],
            'total_fee' => $logs['logs_amount']*100,
            'time_start' => date("YmdHis",NOW_TIME),
            'time_expire' =>  date("YmdHis", NOW_TIME + 600),
            'spbill_create_ip' => get_client_ip(),
            'notify_url' => __HOST__ . U('payment/respond', array('code' => 'weixin')),
            'trade_type' => 'JSAPI',
            'input_charset' => 'UTF-8'
        );

        ksort($params);
        //reset($params);
        $local = array();
        foreach ($params as $key => $val) {
            $local[] = $key . '=' . $val;
        }
        debug($params,0);
        $local[] = 'key='.$payment['appkey'];
        echo join('&', $local);
        echo implode('&', $local);
        $sign = strtoupper(md5(join('&', $local)));
        $params['sign'] = $sign;
//         $params['sign'] = $this->getSign($params,$payment['appkey']);
        
        $str = "<xml>";
        foreach ($params as $key => $val) {
            if (is_numeric($val)) {
                $str .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $str .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $str.="</xml>";
        
        /**
         * 
         * 
         * appid=wxa40b9747297380d4&amp;
         * body=SimpleO2O商城购物&amp;
         * input_charset=UTF-8&amp;
         * mch_id=1249047501&amp;
         * nonce_str=d58c44c9f454d59db3cfac26729c4290
         * ¬ify_url=http://gxsc.51unite.com/index.php?m=Mobile&amp;c=payment&amp;a=respond&amp;code=weixin&amp;
         * openid=oUdhTswNlLs8Tiryxp440VISJNfA&amp;
         * out_trade_no=2015090917182610&amp;
         * spbill_create_ip=123.151.42.48&amp;
         * total_fee=12&amp;
         * trade_type=JSAPI&amp;
         * key=9cafaa9a50782d2fa199799dc26ebba4

    
        
         */
        
        /**
<xml><openid><!--[CDATA[ovdv0t0x1P0F5mbA9VsOCanhyTsw]]--></openid>
<body>2015090805666</body>
<out_trade_no><!--[CDATA[2015090805666O132]]--></out_trade_no>
<total_fee>190</total_fee>
<notify_url><!--[CDATA[https://sxp.51unite.com/mobile/respond.php?code=YToyOntzOjQ6InR5cGUiO2k6MDtzOjQ6ImNvZGUiO3M6NToid3hwYXkiO30=]]--></notify_url>
<trade_type><!--[CDATA[JSAPI]]--></trade_type>
<input_charset><!--[CDATA[UTF-8]]--></input_charset>
<appid><!--[CDATA[wxa23cd265a9bf6f2b]]--></appid>
<mch_id><a href="faketel:1268872501" style="text-decoration: none; color: rgb(0, 0, 0); ">1268872501</a></mch_id>
<spbill_create_ip><!--[CDATA[113.140.156.23]]--></spbill_create_ip>
<nonce_str><!--[CDATA[yw4suqsaf2q3d40xaq0sbliiwtd7lz8i]]--></nonce_str>
<sign><!--[CDATA[71B0B087F142320693AC9FB27D8EE8A0]]--></sign></xml>
         */
        
/*         $str = '<xml>
            <appid>wxb315a53500625570</appid>
            <body>SimpleO2O商城购物</body>
            <mch_id>1249047501</mch_id>
            <nonce_str>e45de632fbf86e3e9c6bae0ff6ee6e42</nonce_str>
            <notify_url>http://gxsc.51unite.com/index.php?m=Mobile&amp;c=payment&amp;a=respond&amp;code=weixin</notify_url>
            <out_trade_no>5</out_trade_no>
            <spbill_create_ip>123.151.42.47</spbill_create_ip>
            <total_fee>12</total_fee>
            <trade_type>JSAPI</trade_type>
            <sign>CD3B04841AA751264525CC49487697E6</sign>
            </xml>'; */
//         $xml = "<xml>";
//         foreach ($params as $key => $val) {
//             if (is_numeric($val)) {
//                 $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
//             } else {
//                 $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
//             }
//         }
//         $xml .= "</xml>";
        
//         $str = $xml;
        $result = $this->curl->post($this->api, $str);
        if (empty($result)) {
            exit('微信支付接口错误！1');
        }
        $xml = new \SimpleXMLElement($result);
        $data = array();
        $xml || exit;
        foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
        }
        
        if(empty($data['return_code']) || empty($data['result_code'])) {
            exit('微信支付接口错误！2');
        }
        
        if($data['return_code'] != 'SUCCESS' || $data['result_code'] != 'SUCCESS'){
            exit('微信支付接口错误！3'); 
        }
        if(empty($data['prepay_id'])){
            exit('微信预支付订单生成失败！');
        }
        $str = '<input type="button" class="payment" id="jq_payment_button" value=" 立即支付 " /><script>function onBridgeReady(){
                    WeixinJSBridge.invoke(
                       \'getBrandWCPayRequest\', {
                            "appId" : "'.$payment['appid'].'",     //公众号名称，由商户传入     
                            "timeStamp":" '.NOW_TIME.'",         //时间戳，自1970年以来的秒数     
                            "nonceStr" : "'.$params['nonce_str'].'", //随机串     
                            "package" : "prepay_id='.$data['prepay_id'].'",     
                            "signType" : "MD5",         //微信签名方式:     
                            "paySign" : "'.$params['sign'].'" //微信签名 
                        },
                        function(res){     
                            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                                location.href="'.U('public/payyes').'";
                            }     
                        }
                    ); 
                 }
                 if (typeof WeixinJSBridge == "undefined"){
                    if( document.addEventListener ){
                        document.addEventListener(\'WeixinJSBridgeReady\', onBridgeReady, false);
                    }else if (document.attachEvent){
                        document.attachEvent(\'WeixinJSBridgeReady\', onBridgeReady); 
                        document.attachEvent(\'onWeixinJSBridgeReady\', onBridgeReady);
                    }
                 }else{
                    $("#jq_payment_button").click(function(){
                        onBridgeReady();
                    });
                 }
                 </script>
        ';
        
/*         $js = '<script language="javascript">
        function jsApiCall(){WeixinJSBridge.invoke("getBrandWCPayRequest",{
                            "appId" : "'.$payment['appid'].'",     //公众号名称，由商户传入     
                            "timeStamp":" '.time().'",         //时间戳，自1970年以来的秒数     
                            "nonceStr" : "'.$params['nonce_str'].'", //随机串     
                            "package" : "prepay_id='.$data['prepay_id'].'",     
                            "signType" : "MD5",         //微信签名方式:     
                            "paySign" : "'.$params['sign'].'" //微信签名 
                        },function(res){if(res.err_msg == "get_brand_wcpay_request:ok"){location.href="' .U('public/payyes'). '"}});}
                    function callpay()
                    {if (typeof WeixinJSBridge == "undefined")
                        {if( document.addEventListener ){document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);}else if (document.attachEvent){document.attachEvent("WeixinJSBridgeReady", jsApiCall);document.attachEvent("onWeixinJSBridgeReady", jsApiCall);}}else{jsApiCall();}}
            </script>';
        
        $button = '<button class="t1" onclick="callpay()">微信安全支付</button>' . $js; */
        $time = time();
        $okCallbackUrl = U('public/payyes');
        $errCallbackUrl = U('index/index');
        $js = <<<EOF
        <script language="javascript">
        function jsApiCall() {
	WeixinJSBridge
			.invoke(
					"getBrandWCPayRequest",
					{
						"appId" : "{$payment['appid']}",
						"timeStamp" : "{$time}",
						"nonceStr" : "{$params['nonce_str']}",
						"package" : "prepay_id={$data['prepay_id']}",
						"signType" : "MD5",
						"paySign" : "{$params['sign']}"
					},
					function(res) {
						if (res.err_msg == "get_brand_wcpay_request:ok") {
							location.href = "{$okCallbackUrl}"
						} else {
							location.href = "{$errCallbackUrl}"
						}
					});
}
function callpay() {
	if (typeof WeixinJSBridge == "undefined") {
		if (document.addEventListener) {
			document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
		} else if (document.attachEvent) {
			document.attachEvent("WeixinJSBridgeReady", jsApiCall);
			document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
		}
	} else {
		jsApiCall();
	}
}
</script>
EOF;
        
        $js = <<<EOF
        <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			{
                "appId" : "{$payment['appid']}",
				"timeStamp" : "{$time}",
				"nonceStr" : "{$params['nonce_str']}",
				"package" : "prepay_id={$data['prepay_id']}",
				"signType" : "MD5",
				"paySign" : "{$params['sign']}"
            },
			function(res){
				WeixinJSBridge.log(res.err_msg);
				alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
EOF;
        $button = '<button class="t1" onclick="callpay()">微信安全支付</button>' . $js;
        return $button;
        
//         return $str;
        
    }

    public function respond() {
         $xml = file_get_contents("php://input");
         if(empty($xml)) return false;
         $xml = new \SimpleXMLElement($xml);
         if(!$xml) return false;
         $data = array();
         foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
         }
         if(empty($data['return_code']) || $data['return_code']!='SUCCESS'){
             return false;
         }
         if(empty($data['result_code']) || $data['result_code'] != 'SUCCESS'){
             return false;
         }
         if(empty($data['out_trade_no'])) return false;
         ksort($data);
         reset($data);
         $payment = D('Payment')->getPayment('weixin');
          /* 检查支付的金额是否相符 */
         if (!D('Payment')->checkMoney($data['out_trade_no'], $data['total_fee'])) {
            return false;
         }
         
         $sign =  array();
         foreach($data as $key=>$val){
             if($key != 'sign'){
                 $sign[] = $key . '=' . $val;
             }
         }
         $sign[] =  'key='.$payment['appkey'];
         $signstr = strtoupper(md5(join('&',$sign)));
         if($signstr != $data['sign'] ) return false;
         D('Payment')->logsPaid($data['out_trade_no']);

        return true;
        
    }
    
    /**
     * 作用：生成签名
     */
    public function getSign($Obj,$appkey)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
    
        $buff = "";
        foreach ($Parameters as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }
        $String="";
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        // echo '【string1】'.$String.'</br>';
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $appkey;
        // echo "【string2】".$String."</br>";
        // 签名步骤三：MD5加密
        $String = md5($String);
        // echo "【string3】 ".$String."</br>";
        // 签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        // echo "【result】 ".$result_."</br>";
        return $result_;
    }
    
    
    public function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i ++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


}