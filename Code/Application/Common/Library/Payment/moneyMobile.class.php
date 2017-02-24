<?php

namespace Common\Library\Payment;
/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-9-9
 * @version
 */
class moneyMobile {//余额支付
    
    public function  getCode($logs){
        
        return '<input type="button" class="payment" onclick="window.open(\''.U('member/pay',array('logs_id'=>$logs['logs_id'])).'\')" value=" 立刻支付 " />';
    }

    public function respond(){
        
    }
    
}