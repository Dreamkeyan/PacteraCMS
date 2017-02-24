<?php

namespace Common\Library\Payment;

class money{//余额支付
    
    public function  getCode($logs,$setting=array()){
        
        return '<input type="button" class="payment" onclick="window.open(\''.U('member/pay',array('logs_id'=>$logs['logs_id'])).'\')" value=" 立刻支付 " />';
    }

    public function respond(){
        
    }
    
}