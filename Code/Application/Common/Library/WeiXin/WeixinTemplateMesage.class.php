<?php

/**
 * 微信消息模板
 * Created by PhpStorm.
 * @author kevin_ren <330202207@qq.com>
 * @date: 2015/12/30
 */

namespace Common\Library\WeiXin;

use Common\Library\WeiXin\WeixinPush;

class WeixinTemplateMesage {

    protected $weixin;

    public function __construct() {
        $this->weixin = new WeixinPush();
    }

    /**
     * 消息模板
     * @author kevin_ren <330202207@qq.com>
     */
    private function getTemplate($info) {
        $data = array();
        switch ($info['status']) {
            //订单提交成功
            case 10:
                //通联
                //$data['template_id'] = 'sEQ0hqfiPWZSa2_OrqxS6j5sMr4aC5VW0fDD1YIoPlM';
                //菜农
                $data['template_id'] = '7ajSXZF7SK3gstgrNcT1WjNaMk8zORKBGa_eLpj4LF0';
                $info['total_price'] = '未报价';
                if ($info['type'] == 'buyer') {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index', array('status' => 30, 'type' => 'unsend'));
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您好,您已下单成功"), 'color' => "#CC0033"),
                        'orderID' => array('value' => urlencode($info['sn']), 'color' => "#000000"),
                        'orderMoneySum' => array('value' => urlencode($info['total_price']), 'color' => "#000000"),
                        'backupFieldName' => array('value' => urlencode('供应商：'), 'color' => '#000000'),
                        'backupFieldData' => array('value' => urlencode($info['supplier_name']), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商(' . $info['supplier_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                } else {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index');
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您收到一个新订单，请及时报价"), 'color' => "#CC0033"),
                        'orderID' => array('value' => urlencode($info['sn']), 'color' => "#000000"),
                        'orderMoneySum' => array('value' => urlencode($info['total_price']), 'color' => "#000000"),
                        'backupFieldName' => array('value' => urlencode('采购商：'), 'color' => '#000000'),
                        'backupFieldData' => array('value' => urlencode($info['buyer_name']), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与采购商(' . $info['buyer_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                }
                return $data;
            //订单已报价
            case 20:
                $data['template_id'] = '7Q7Oby6BokUnN5b2SkkbmdZx06oQZL-sgSxccJfGSp4';
                if ($info['type'] == 'buyer') {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("你有一条报价提醒"), 'color' => "#743A3A"),
                        'keyword1' => array('value' => urlencode($info['order_sn']), 'color' => '#0000FF'),
                        'keyword2' => array('value' => urlencode(date('Y-m-d  H:i:s', $info['create_time'])), 'color' => '#0000FF'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商联系~~~'), 'color' => '#000000'),
                    );
                } else {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("你有一条报价提醒"), 'color' => "#743A3A"),
                        'keyword1' => array('value' => urlencode($info['order_sn']), 'color' => '#0000FF'),
                        'keyword2' => array('value' => urlencode(date('Y-m-d  H:i:s', $info['create_time'])), 'color' => '#0000FF'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与采购商联系~~~'), 'color' => '#000000'),
                    );
                }
                return $data;
            //订单已配货
            case 30:
                $data['template_id'] = 'OkG6oXEZ4Dg4kWfeOMrGbuTEcIpV_YccKHOfiCQvND0';
                if ($info['type'] == 'buyer') {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您好,您的货物已成功"), 'color' => "#743A3A"),
                        'keyword1' => array('value' => urlencode("2件"), 'color' => '#0000FF'),
                        'keyword2' => array('value' => urlencode("香蕉2斤，苹果2个"), 'color' => '#0000FF'),
                        'keyword3' => array('value' => urlencode($info['price']), 'color' => '#0000FF'),
                        'keyword4' => array('value' => urlencode($info['supplier_name']), 'color' => '#0000FF'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商(' . $info['supplier_name'] . ')联系~~~'), 'color' => '#000000')
                    );
                } else {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您好,您的货物已成功"), 'color' => "#743A3A"),
                        'keyword1' => array('value' => urlencode("2件"), 'color' => '#0000FF'),
                        'keyword2' => array('value' => urlencode("香蕉2斤，苹果2个"), 'color' => '#0000FF'),
                        'keyword3' => array('value' => urlencode($info['price']), 'color' => '#0000FF'),
                        'keyword4' => array('value' => urlencode($info['supplier_name']), 'color' => '#0000FF'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与采购商(' . $info['buyer_name'] . ')联系~~~'), 'color' => '#000000')
                    );
                }
                return $data;
            //订单已发货
            case 40:
                //通联
                //$data['template_id'] = 'IQ_w11kjuHcmJX9qS0TFdndq3HmIbO1zftaZeMyK4LM';
                //菜农
                $data['template_id'] = 'hbwtfB6Arck_44YTT_A6R10ZFua_vVFVT7KICcCijzI';
                if ($info['type'] == 'buyer') {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index', array('status' => 40, 'type' => 'receive'));
                    $data['info'] = array(
                        'first' => array('value' => urlencode("收到一条发货提醒"), 'color' => "#CC0033"),
                        'keyword1' => array('value' => urlencode($info['buyer_name']), 'color' => '#000000'),
                        'keyword2' => array('value' => urlencode($info['buyer_mobile']), 'color' => '#000000'),
                        'keyword3' => array('value' => urlencode($info['address']), 'color' => '#000000'),
                        'keyword4' => array('value' => urlencode($info['total_price'] . '元'), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商(' . $info['supplier_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                } else {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index', array('status' => 40, 't' => 'shipping'));
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您好,您已发货"), 'color' => "#CC0033"),
                        'keyword1' => array('value' => urlencode($info['buyer_name']), 'color' => '#000000'),
                        'keyword2' => array('value' => urlencode($info['buyer_mobile']), 'color' => '#000000'),
                        'keyword3' => array('value' => urlencode($info['address']), 'color' => '#000000'),
                        'keyword4' => array('value' => urlencode($info['total_price'] . '元'), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与采购商(' . $info['buyer_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                }
                return $data;
            //订单支付成功
            case 60:
                $data['template_id'] = '9GKWyMGO7Foj_YzNmjjNbSgaxW0WkPNParTGlilVmcQ';
                if ($info['type'] == 'buyer') {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("订单支付成功"), 'color' => "#743A3A"),
                        'orderMoneySum' => array('value' => urlencode($info['price']), 'color' => '#0000FF'),
                        'orderProductName' => array('value' => urlencode($info['goods_name'] . '元'), 'color' => '#0000FF'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商(' . $info['supplier_name'] . ')联系~~~'), 'color' => '#000000')
                    );
                } else {
                    $data['info'] = array(
                        'first' => array('value' => urlencode("订单支付成功"), 'color' => "#743A3A"),
                        'orderMoneySum' => array('value' => urlencode($info['price']), 'color' => '#0000FF'),
                        'orderProductName' => array('value' => urlencode($info['goods_name'] . '元'), 'color' => '#0000FF'),
                        'Remark' => array('value' => urlencode('\\n如有问题请及时与采购商联系~~~'), 'color' => '#000000'),
                    );
                }
                return $data;
            //订单已收货
            case 70:
                //通联
                //$data['template_id'] = 'NnuB84HnutE6h1Wax5X4e8A40ypo4-40-QhRe885qbw';
                //菜农
                $data['template_id'] = '3KhojwNcIsq0qlGgXqh2fSzG71rgSyuhdX4CTgmYch4';
                if ($info['type'] == 'buyer') {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index');
                    $data['info'] = array(
                        'first' => array('value' => urlencode("您的订单已经确认收货，点击“详情”查询订单信息"), 'color' => "#CC0033"),
                        'keyword1' => array('value' => urlencode($info['sn']), 'color' => '#000000'),
                        'keyword2' => array('value' => urlencode($info['buyer_name']), 'color' => '#000000'),
                        'keyword3' => array('value' => urlencode('已收货'), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与供应商(' . $info['supplier_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                } else {
                    $data['url'] = $_SERVER["SERVER_NAME"] . U('order/index', array('t' => 'all'));
                    $data['info'] = array(
                        'first' => array('value' => urlencode("【" . $info['buyer_name'] . "】" . "的订单已经确认收货，点击“详情”查询订单信息"), 'color' => "#CC0033"),
                        'keyword1' => array('value' => urlencode($info['sn']), 'color' => '#000000'),
                        'keyword2' => array('value' => urlencode($info['buyer_name']), 'color' => '#000000'),
                        'keyword3' => array('value' => urlencode('已收货'), 'color' => '#000000'),
                        'remark' => array('value' => urlencode('\\n如有问题请及时与采购商(' . $info['buyer_mobile'] . ')联系~~~'), 'color' => '#000000')
                    );
                }
                return $data;
        }
    }

    /**
     * 推送微信消息(采购商)  
     * 判断应该推送的消息类型
     * @author kevin_ren <330202207@qq.com>
     */
    public function weixin_send_buyer_message($info) {
        switch ($info['mark']) {
            //采购商提交订单
            //采购商收货
            case 'cgstjdd':
            case 'cgssh':
                $res = $this->buyer_cgstjddandsh($info);
                return $res;
                break;
            //供货商发货
            case 'ghsfh':
                $res = $this->buyer_ghsfh($info);
                return $res;
                break;
            default:
                break;
        }
    }

    /**
     * 采购商提交订单和收货  ->采购商推送
     * @param string $info
     * @return boolean
     */
    public function buyer_cgstjddandsh($info) {
        $uids = $this->getBuyerStaffIds($info['buyer_id']);
        $buyer_uid[]['user_id'] = $info['buyer_user_id'];
        $ids = array_merge($uids, $buyer_uid);
        $touser = $this->getOpenIds($ids);
        if ($touser) {
            return $this->sendData($info, $touser, 'buyer');
        } else {
            return FALSE;
        }
    }

    /**
     * 供应商发货 =》 采购商
     * @param type $info
     */
    public function buyer_ghsfh($info) {
        $uids = $this->getBuyerStaffIds($info['buyer_id']);
        $buyer_uid[] = D('Buyer')->where(array('id' => $info['buyer_id']))->Field('user_id')->find();
        $ids = array_merge($uids, $buyer_uid);
        $touser = $this->getOpenIds($ids);
        if ($touser) {
            return $this->sendData($info, $touser, 'buyer');
        } else {
            return FALSE;
        }
    }

    /**
     * 获取子账号的id
     * @param id $buyer_id
     * @return array
     * @author xiongfei.ma 
     * 2016-1-6
     */
    public function getBuyerStaffIds($buyer_id) {
        return D('BuyerStaff')->where(array('buyer_id' => $buyer_id, 'status' => 1))->field('user_id')->select();
    }

    /**
     * 获取所有用户的open_id
     * @param id $uids
     * @return false or array
     * @author xiongfei.ma 
     * 2016-1-6
     */
    public function getOpenIds($uids) {
        foreach ($uids as $key => $value) {
            $open_id = D('Connect')->where(array('uid' => $value['user_id']))->getField('open_id');
            if ($open_id) {
                $touser[] = $open_id;
            }
        }
        return $touser;
    }

    /**
     * 推送微信消息(供应商)
     * @author kevin_ren <330202207@qq.com>
     */
    public function weixin_send_supplier_message($info) {
        switch ($info['mark']) {
            case 'cgstjdd':
            case 'cgssh':
                $res = $this->supplier_cgstjddandsh($info);
                return $res;
                break;
            case 'ghsfh':
                $res = $this->supplier_ghsfh($info);
                return $res;
                break;
            default:
                break;
        }
    }

    /**
     * 采购商提交订单通知 =》 供应商
     * @param array $info
     * @return boolean|string
     */
    public function supplier_cgstjddandsh($info) {
        $uids = $this->getSupplierIds($info['supplier_id']);
        $supplier_id[] = D('Supplier')->where(array('id' => $info['supplier_id']))->Field('user_id')->find();
        $ids = array_merge($uids, $supplier_id);
        $touser = $this->getOpenIds($ids);
        if ($touser) {
            return $this->sendData($info, $touser, 'supplier');
        } else {
            return FALSE;
        }
    }

    /**
     * 供货商发货 =》 供货商
     * @param array $info
     * @return boolean|string
     */
    public function supplier_ghsfh($info) {
        //判断身份
        $uids = $this->getSupplierIds($info['supplier_id']);
        $supplier_uid[]['user_id'] = $info['supplier_user_id'];
        $ids = array_merge($uids, $supplier_uid);
        $touser = $this->getOpenIds($ids);
        if ($touser) {
            return $this->sendData($info, $touser, 'supplier');
        } else {
            return FALSE;
        }
    }

    /**
     * 得到采购商id
     * @param id $supplier_id
     * @return array
     */
    public function getSupplierIds($supplier_id) {
        return D('SupplierStaff')->where(array('supplier_id' => $supplier_id, 'status' => 1))->field('user_id')->select();
    }

    /**
     * 调用个微信发送消息的接口
     * @param array $info
     * @param type $touser
     * @param type $name
     * @return boolean
     */
    public function sendData($info, $touser, $name) {
        $info['type'] = $name;
        $data = $this->getTemplate($info);
        $res = $this->weixin->doSends($touser, $data);
        if ($res) {
            return true;
        }
    }

}
