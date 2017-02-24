<?php

/**
 * Created by PhpStorm.
 * @author kevin_ren <330202207@qq.com>
 * @time: 15:49
 */

namespace Common\Library\Message;

class MessagesTemplate {

    /**
     * 消息模板
     * @author kevin_ren <330202207@qq.com>
     */
    private function get_template($data) {
        switch ($data['status']) {
            //订单提交成功
            case 10:
                if ($data['type'] == 'buyer') {
                    $content = '您已经成功下单。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['sn'];
                } else {
                    $content = '您收到一个新订单，请及时报价。采购商【' . $data['buyer_name'] . '】订单编号：' . $data['sn'];
                }
                return $content;
            //已报价
            case 20:
                if ($data['type'] == 'buyer') {
                    $content = '已经报价。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['order_sn'];
                } else {
                    $content = '报价成功，请及时配货。订单编号：' . $data['order_sn'] . ',来自【' . $data['buyer_name'] . '】';
                }
                return $content;
            //已配货
            case 30:
                if ($data['type'] == 'buyer') {
                    $content = '产品已经配货。等待收货。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['order_sn'];
                } else {
                    $content = '配货成功，请及时发货。订单编号：' . $data['order_sn'] . ',来自【' . $data['buyer_name'] . '】';
                }
                return $content;
            //已发货
            case 40:
                if ($data['type'] == 'buyer') {
                    $content = '您的订单已发货，请注意查收。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['sn'];
                } else {
                    $content = '订单已发货，等待对方收货。采购商【' . $data['buyer_name'] . '】订单编号：' . $data['sn'];
                }
                return $content;
            //已付款
            case 60:
                if ($data['type'] == 'buyer') {
                    $content = '您已成功付款。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['order_sn'];
                } else {
                    $content = '对方已付款。订单编号：' . $data['order_sn'] . ',来自【' . $data['buyer_name'] . '】';
                }
                return $content;
            //已收货
            case 70:
                if ($data['type'] == 'buyer') {
                    $content = '您已成功收货，订单完成。供应商【' . $data['supplier_name'] . '】订单编号：' . $data['sn'];
                } else {
                    $content = '对方已收货。订单完成。订单编号：' . $data['sn'];
                }
                return $content;
            case 100:
                if ($data['type'] == 'buyer') {
                    $content = '你已经和供应商【'.$data['supplier_name'].'】达成供求关系';
                } else {
                    $content = '你已经和采购商【'.$data['buyer_name'].'】达成供求关系';
                }
                return $content;
        }
    }

    /**
     * 推送消息(采购商)
     * @author kevin_ren <330202207@qq.com>
     */
    public function send_buyer_message($info) {
        $messages['user_id'] = $info['buyer_user_id'];
        $messages['messages_data'] = json_encode($info);
        $messages['buyer_id'] = $info['buyer_id'];
        $messages['supplier_id'] = 0;
        $messages['create_time'] = $info['create_time'];
        $messages['order_sn'] = $info['sn'];
        $info['type'] = 'buyer';
        $messages['content'] = $this->get_template($info);
        $res = D('Messages')->add($messages);
        return $res;
    }

    /**
     * 推送消息(供应商)
     * @author kevin_ren <330202207@qq.com>
     */
    public function send_supplier_message($info) {

        $messages['user_id'] = $info['supplier_user_id'];
        $messages['messages_data'] = json_encode($info);
        $messages['buyer_id'] = 0;
        $messages['supplier_id'] = $info['supplier_id'];
        $messages['create_time'] = $info['create_time'];
        $messages['order_sn'] = $info['sn'];
        $info['type'] = 'supplier';
        $messages['content'] = $this->get_template($info);
        $res = D('Messages')->add($messages);
        return $res;
    }

}
