<?php
namespace Common\Library\Sms;
/**
 * 短信模块
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-11-3
 * @version
 */
class Sms {

    var $sms_name = NULL; //用户名
    var $sms_password = NULL; //密码

    function __construct() {
        /* 直接赋值 */
        $this->sms_name = 0;
        $this->sms_password = 0;
    }

    // 发送短消息
    function send($phones, $msg, $send_date = '', $send_num = 1, $sms_type = '', $version = '1.0', &$sms_error = '') {
        
        /*新短信发送*/
        $flag   = 0;
        $params = '';

        //要post的数据
        /**
                漫道短信接口
                序列号 SDK-BBX-010-24867
                密码 31a)-d29
         */
        $argv = array(
            'sn'      => 'SDK-BBX-010-24867', ////替换成您自己的序列号
            'pwd'     => strtoupper(md5('SDK-BBX-010-24867'.'31a)-d29')), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
            'mobile'  => $phones,//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content' => urlencode('【CGL2016】'.$msg),//短信内容
            'ext'     => '',
            'stime'   => '',//定时时间 格式为2011-6-29 11:09:21
            'msgfmt'  => '',
            'rrid'    => ''
        );

        //构造要post的字符串
        foreach ($argv as $key => $value) {
            if ($flag != 0) {
                $params .= "&";
                $flag = 1;
            }
            $params .= $key."=";
            $params .= urlencode($value);
            $flag = 1;
        }
        $length = strlen($params);

        //创建socket连接
        $fp = fsockopen("sdk.entinfo.cn", 8061, $errno, $errstr, 10) or exit($errstr."--->".$errno);

        //构造post请求的头
        $header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
        $header .= "Host:sdk.entinfo.cn\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";

        //添加post的字符串
        $header .= $params."\r\n";

        //发送post的数据
        fputs($fp, $header);
        $inheader = 1;
        while (!feof($fp)) {
            $line = fgets($fp, 1024); //去除请求包的头只显示页面的返回数据
            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
            if ($inheader == 0) {
                // echo $line;
            }
        }

        preg_match('/<string xmlns=\"http:\/\/tempuri.org\/\">(.*)<\/string>/', $line, $str);
        $result = explode("-",$str[1]);

        if (count($result) > 1) {
            $sms_error = $phones.'发送失败返回值为:'.$line."请查看webservice返回值";
            $this->logResult($sms_error);
            return false;
        } else {
            $sms_success = $phones.'发送成功 返回值为:'.$line;
            $this->logResult($sms_success);
            return true;
        }

    }

    function Post($curlPost, $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    function xml_to_array($xml) {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = $this->xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    //检查手机号和发送的内容并生成生成短信队列
    function get_contents($phones, $msg) {
        if (empty($phones) || empty($msg)) {
            return false;
        }
        //$msg.='【'. $GLOBALS['_CFG']['shop_name'].'】'; //by wanganlin delete
        $phone_key = 0;
        $i = 0;
        $phones = explode(',', $phones);
        foreach ($phones as $key => $value) {
            if ($i < 200) {
                $i++;
            } else {
                $i = 0;
                $phone_key++;
            }
            if ($this->is_moblie($value)) {
                $phone[$phone_key][] = $value;
            } else {
                $i--;
            }
        }
        if (!empty($phone)) {
            foreach ($phone as $phone_key => $val) {
                if (EC_CHARSET != 'utf-8') {
                    $phone_array[$phone_key]['phones'] = implode(',', $val);
                    $phone_array[$phone_key]['content'] = $this->auto_charset($msg);
                } else {
                    $phone_array[$phone_key]['phones'] = implode(',', $val);
                    $phone_array[$phone_key]['content'] = $msg;
                }
            }
            return $phone_array;
        } else {
            return false;
        }
    }

    // 自动转换字符集 支持数组转换
    function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
            //如果编码相同或者非字符串标量则不转换
            return $fContents;
        }
        if (is_string($fContents)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($fContents, $to, $from);
            } elseif (function_exists('iconv')) {
                return iconv($from, $to, $fContents);
            } else {
                return $fContents;
            }
        } elseif (is_array($fContents)) {
            foreach ($fContents as $key => $val) {
                $_key = auto_charset($key, $from, $to);
                $fContents[$_key] = auto_charset($val, $from, $to);
                if ($key != $_key)
                    unset($fContents[$key]);
            }
            return $fContents;
        }
        else {
            return $fContents;
        }
    }

    // 检测手机号码是否正确
    function is_moblie($moblie) {
        return preg_match("/^0?1((3|8)[0-9]|5[0-35-9]|4[57])\d{8}$/", $moblie);
    }

    //打印日志
    function logResult($word = '') {

        $filename = ROOT_DIR . '/Cache/cgllog/' . date('Ymd') . '/' .'CGLlog.txt';
        $fp = fopen($filename, "a");

        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . strftime("%Y%m%d%H%M%S", time()) . "\n" . $word . "\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

}

?>