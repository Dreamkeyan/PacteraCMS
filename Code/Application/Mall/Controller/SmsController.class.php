<?php

namespace Mall\Controller;

use Common\Library\Sms\Sms;
use Think\Controller;

/**
 * 短信
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-11-3
 * @version
 */
class SmsController extends Controller
{

    protected $mobile;
    //短信验证码
    protected $mobile_code;
    //安全码
    protected $sms_code;

    public function __construct() {
        parent::__construct();

        $this->mobile = $_POST['mobile'];
        $this->mobile_code = $_POST['mobile_code'];
        $this->sms_code = $_POST['sms_code'];
    }

    //发送
    public function send() {

        $flag = false;

        if (empty($this->sms_code) || $_SESSION['sms_code'] != $this->sms_code) {
            exit(json_encode(array('msg' => '验证码不匹配')));
        }
        if (empty($this->mobile)) {
            exit(json_encode(array('msg' => '手机号码不能为空')));
        }
        $preg = '/^1[0-9]{10}$/'; //简单的方法
        if (!preg_match($preg, $this->mobile)) {
            exit(json_encode(array('msg' => '手机号码格式不正确')));
        }

         /*if ($_SESSION['sms_mobile']) {
          if (strtotime(read_file($this->mobile)) > (time() - 60)) {
          exit(json_encode(array('msg' => '获取验证码太过频繁，一分钟之内只能获取一次。')));
          }
          } */

//        $map = array('phone' => $this->mobile);
        $msg = D('Member/Member')->getMemberBaseInfo($this->mobile);

        if ($_GET['flag'] == 'register') {
            //手机注册
            if ($msg['errCode']) {
                exit(json_encode(array('msg' => '手机号码已存在，请更换手机号码')));
            }
        } elseif ($_GET['flag'] == 'forget') {
            //找回密码
            if (!$msg['errCode']) {
                exit(json_encode(array('msg' => "手机号码不存在\n无法通过该号码找回密码")));
            }
        } elseif ($_GET['flag'] == 'login_with_phone') {
            //手机登陆 @sunny5156
            if (!$msg['errCode']) {
                exit(json_encode(array('msg' => $msg['errMsg'])));
            }
        } elseif ($_GET['flag'] == 'check_mobile') {
            //验证旧手机
            $res = $this->checkMobile();
            if ($res !== true) {
                exit(json_encode(array('msg' => $res)));
            }
        } elseif ($_GET['flag'] == 'check_new_mobile') {
            //验证新手机
            if ($msg['errCode'] == 1) {
                exit(json_encode(array('msg' => "新手机号码已存在，请更换其他手机号码")));
            }
        }elseif ($_GET['flag'] == 'bind'){
            if (!empty($msg)) {
                exit(json_encode(array('msg' => "新手机号码已存在，请更换其他手机号码")));
            }
        }

        if ($flag == false) {
            $this->mobile_code = '123456';
        } else {
            $this->mobile_code = $this->random(6, 1);
        }
        
        $message = "您的验证码是：" . $this->mobile_code . "，请不要把验证码泄露给其他人，如非本人操作，可不用理会！";

        $sms = new Sms();
        $sms_error = '';

        if($flag == false){
            $send_result = 1;
        }else{
            $send_result = $sms->send($this->mobile, $message, $sms_error);
        }
        $this->write_file($this->mobile, date("Y-m-d H:i:s"));

        if ($send_result) {
            $_SESSION['sms_mobile'] = $this->mobile;
            $_SESSION['sms_mobile_code'] = $this->mobile_code;
            //session(array('name'=>'sms_mobile_code','expire'=>180),$this->mobile_code);
            exit(json_encode(array('code' => 2, 'msg' => '手机验证码已经成功发送到您的手机')));
        } else {
            exit(json_encode(array('msg' => $sms_error)));
        }
    }

    /**
     * 修改手机号验证是否正确
     */
    public function checkMobile()
    {
        if (in_array($_SESSION['userInfo']['userType'], array(21, 11))) {
            $user_info = $_SESSION['userInfo']['staff'];
        }
        if (in_array($_SESSION['userInfo']['userType'], array(10, 20))) {
            $user_info = $_SESSION['userInfo']['masterInfo'];
        }
        if ($user_info['mobile'] != $this->mobile) {
            return '原手机号码不正确';
        } else {
            return true;
        }
    }

    //验证
    public function check() {
        if ($this->mobile != $_SESSION['sms_mobile'] or $this->mobile_code != $_SESSION['sms_mobile_code']) {
            exit(json_encode(array('msg' => '手机验证码输入错误。')));
        } else {
            exit(json_encode(array('code' => '2')));
        }
    }

    private function random($length = 6, $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double) microtime() * 1000000);
        if ($numeric) {
            $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for ($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    private function write_file($file_name, $content) {
        $this->mkdirs('./Public/sms/smslog/' . date('Ymd'));
        $filename = "./Public/sms/smslog/" . date('Ymd') . '/' . $file_name . '.log';
        $Ts = fopen($filename, "a+");
        fputs($Ts, "\r\n" . $content);
        fclose($Ts);
    }

    private function mkdirs($dir, $mode = 0777) {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return TRUE;
        if (!$this->mkdirs(dirname($dir), $mode))
            return FALSE;
        return @mkdir($dir, $mode);
    }

    private function read_file($file_name) {
        $content = '';
        $filename = './Public/sms/smslog/' . date('Ymd') . '/' . $file_name . '.log';
        if (function_exists('file_get_contents')) {
            @$content = file_get_contents($filename);
        } else {
            if (@$fp = fopen($filename, 'r')) {
                @$content = fread($fp, filesize($filename));
                @fclose($fp);
            }
        }
        $content = explode("\r\n", $content);
        return end($content);
    }

}
