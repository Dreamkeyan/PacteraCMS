<?php

namespace Addons\Sms\Controller;

/**
 * Description of SmsController
 *
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016-9-18  15:13:18
 */
class SmsController extends \Think\Controller
{
    
    public function send()
    {
        $mobile = I('get.mobile');
        if($mobile){
            $string = new \Org\Util\String();
            $code = $string->randString(6, 1);
            $text = str_replace('CODE', $code, C('SMS.TEMPLATE_REGISTER'));
            
            $sms = new \Common\Library\Sms\Sms();
            
            $result = C('SMS.DEBUG') ? 1 : $sms->send($mobile, $text);
            
            if($result){
                //日志
                $data = [
                    'mobile' => $mobile,
                    'code' => $code,
                    'text' => $text,
                    'status' => $result
                ];
                $sms_model = new \Common\Model\SystemSmsModel();

                $data = $sms_model->create($data);
                
                $sms_model->add($data);
                
                //输出可重发秒数
                echo C('SMS.RESEND_SECOND');
            }else{
                echo 0;
            }
            
        }

    }
    
}
