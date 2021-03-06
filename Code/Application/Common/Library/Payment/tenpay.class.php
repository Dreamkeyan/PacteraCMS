<?php

namespace Common\Library\Payment;

class  tenpay{
    
    
    
     /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function tenpay()
    {
    }

    function __construct()
    {
        $this->tenpay();
    }

    /**
     * 生成支付代码
     * @param   array    $order       订单信息
     * @param   array    $payment     支付方式信息
     */
    function getCode($logs, $payment)
    {
        $cmd_no = '1';

        /* 获得订单的流水号，补零到10位 */
        $sp_billno = $logs['log_id'];

        /* 交易日期 */
        $today = date('Ymd');

        /* 将商户号+年月日+流水号 */
        $bill_no = str_pad($logs['log_id'], 10, 0, STR_PAD_LEFT);
        $transaction_id = $payment['tenpay_account'].$today.$bill_no;

        $bank_type = '0';

        $desc = $logs['subject'] . $logs['logs_id'];
        $attach = '';
       
     
        $return_url = __HOST__. U('payment/respond', array('code' => 'tenpay'));

        
        $total_fee = $logs['need_pay'];

 
        $fee_type = '1';

        $spbill_create_ip = $_SERVER['REMOTE_ADDR'];

    
        $sign_text = "cmdno=" . $cmd_no . "&date=" . $today . "&bargainor_id=" . $payment['tenpay_account'] .
          "&transaction_id=" . $transaction_id . "&sp_billno=" . $sp_billno .
          "&total_fee=" . $total_fee . "&fee_type=" . $fee_type . "&return_url=" . $return_url .
          "&attach=" . $attach . "&spbill_create_ip=" . $spbill_create_ip . "&key=" . $payment['tenpay_key'];
        $sign = strtoupper(md5($sign_text));

        /* 交易参数 */
        $parameter = array(
            'cmdno'             => $cmd_no,                     // 业务代码, 财付通支付支付接口填  1
            'date'              => $today,                      // 商户日期：如20051212
            'bank_type'         => $bank_type,                  // 银行类型:支持纯网关和财付通
            'desc'              => $desc,                       // 交易的商品名称
            'purchaser_id'      => '',                          // 用户(买方)的财付通帐户,可以为空
            'bargainor_id'      => $payment['tenpay_account'],  // 商家的财付通商户号
            'transaction_id'    => $transaction_id,             // 交易号(订单号)，由商户网站产生(建议顺序累加)
            'sp_billno'         => $sp_billno,                  // 商户系统内部的定单号,最多10位
            'total_fee'         => $total_fee,                  // 订单金额
            'fee_type'          => $fee_type,                   // 现金支付币种
            'return_url'        => $return_url,                 // 接收财付通返回结果的URL
            'attach'            => $attach,                     // 用户自定义签名
            'sign'              => $sign,                       // MD5签名
            'spbill_create_ip'  => $spbill_create_ip,           //财付通风险防范参数
        );

        $button  = '<br /><form style="text-align:center;" action="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi" target="_blank" style="margin:0px;padding:0px" >';

        foreach ($parameter AS $key=>$val)
        {
            $button  .= "<input type='hidden' name='$key' value='$val' />";
        }

        $button  .= '<input type="submit" class="payment"  value=" 立即支付 " /></form><br />';

        return $button;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        /*取返回参数*/
        $cmd_no         = $_GET['cmdno'];
        $pay_result     = $_GET['pay_result'];
        $pay_info       = $_GET['pay_info'];
        $bill_date      = $_GET['date'];
        $bargainor_id   = $_GET['bargainor_id'];
        $transaction_id = $_GET['transaction_id'];
        $sp_billno      = $_GET['sp_billno'];
        $total_fee      = $_GET['total_fee'];
        $fee_type       = $_GET['fee_type'];
        $attach         = $_GET['attach'];
        $sign           = $_GET['sign'];

        $payment    = D('Payment')->getPayment('tenpay');
 
        

        /* 如果pay_result大于0则表示支付失败 */
        if ($pay_result > 0)
        {
            return false;
        }

        /* 检查支付的金额是否相符 */
        if (!D('Payment')->checkMoney($sp_billno, $total_fee)) {
            return false;
        }


        /* 检查数字签名是否正确 */
        $sign_text  = "cmdno=" . $cmd_no . "&pay_result=" . $pay_result .
                          "&date=" . $bill_date . "&transaction_id=" . $transaction_id .
                            "&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee .
                            "&fee_type=" . $fee_type . "&attach=" . $attach .
                            "&key=" . $payment['tenpay_key'];
        $sign_md5 = strtoupper(md5($sign_text));
        if ($sign_md5 != $sign)
        {
            return false;
        }
        else
        {
            /* 改变订单状态 */
            D('Payment')->logsPaid($sp_billno);
            return true;
        }
    }
    
    
    
}