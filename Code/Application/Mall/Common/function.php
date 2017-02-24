<?php

/**
 * 格式化规格区域
 *
 * @param array $data
 *
 * @return string
 */
function getSpecItem(array $data)
{
    $html = '';
    foreach ($data as $key => $item) {
        if ($key > 0) {
            $html .= '#';
        }
        $html .= $item['item'];
    }
    return $html;
}

/**
 * 格式化属性区域
 *
 * @param array $data
 *
 * @return string
 */
function getAttrItem(array $data)
{
    $html = '';
    foreach ($data as $key => $item) {
        if ($key > 0) {
            $html .= '#';
        }
        $html .= $item;
    }
    return $html;
}

/**
 * 获取订单状态
 *
 * @param int|string $status 状态id
 *
 * @author liym  <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.11.11
 */
function orderStatus($status)
{

    $status_list = array('0' => '交易关闭', '1' => '待付款', '2' => '待发货', '3' => '待发货', '4' => '已发货', '5' => '交易完成', '6' => '交易完成');

    return $status_list[$status] ? $status_list[$status] : null;
}

/**
 * 获取订单支付
 *
 * @param int|string $type 类型id
 *
 * @author liym  <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.11.24
 */
function payType($type)
{
    $type_list = array('1' => '余额', '2' => '银行卡', '3' => '微信', '4' => '支付宝');

    return isset($type_list[$type]) ? $type_list[$type] : '';
}

/**
 * 订单相应操作
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.7.6
 */
function returnOrderAction()
{
    return array(
        '1' => array(
            "cancel" => array("text" => "取消订单", 'url' => U('Order/operateOrder'), 'type' => 'cancel'),
            "submit" => array("text" => "付款", 'url' => U('Payment/pay'), 'type' => 'pay'),
        ),
        '2' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
            "cancel" => array("text" => "快递到家", 'url' => U('Order/operateOrder'), 'type' => 'deliver'),
        ),
        '3' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
            "cancel" => array("text" => "快递到家", 'url' => U('Order/operateOrder'), 'type' => 'deliver'),
        ),
        '4' => array(
            "view" => array("text" => "查看物流", 'url' => U('Order/shippment'), 'type' => 'view'),
            "submit" => array("text" => "确认收货", 'url' => U('Order/operateOrder'), 'type' => 'submit')
        ),
        '5' => array(
            "view" => array("text" => "查看物流", 'url' => U('Order/shippment'), 'type' => 'view'),
            "submit" => array("text" => "评价", 'url' => U('Appraise/order'), 'type' => 'appraise')
        ),
        '6' => ''
    );
}

/**
 * 订单相应操作
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.7.6
 */
function orderButton($status, $type = 0)
{
    $all = returnOrderAction();
    $str = '';
    $orange = array('评价', '确认收货', '付款');
    foreach ($all[$status] as $key => $value) {
        if (($type == 1 && ($value['text'] == '查看物流' || $value['text'] == '提醒发货')) || ($type == 2 && $value['text'] == '快递到家')) {
            continue;
        }
        if (in_array($value['text'], $orange)) {
            $str .= "<span class='add-orange j-operate' data-type='" . $value['type'] . "' data-url='" . $value['url'] . "'>";
        } else {
            $str .= "<span class='j-operate' data-type='" . $value['type'] . "' data-url='" . $value['url'] . "'>";
        }

        $str .= $value['text'];
        $str .= "</span>";
    }

    return $str;
}

/**
 * 订单详情页的操作
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.12.7
 */
function returnOrderDetail()
{
    return array(
        '0' => array(
            "cancel" => array("text" => "删除订单", 'url' => U('Order/operateOrder'), 'type' => 'del'),
        ),
        '1' => array(
            "cancel" => array("text" => "取消订单", 'url' => U('Order/operateOrder'), 'type' => 'cancel'),
            "submit" => array("text" => "付款", 'url' => U('Payment/pay'), 'type' => 'pay'),
        ),
        '2' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
            "cancel" => array("text" => "快递到家", 'url' => U('Order/operateOrder'), 'type' => 'deliver'),
        ),
        '3' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
            "cancel" => array("text" => "快递到家", 'url' => U('Order/operateOrder'), 'type' => 'deliver'),
        ),
        '4' => array(
            "view" => array("text" => "查看物流", 'url' => U('Order/shippment'), 'type' => 'view'),
            "submit" => array("text" => "确认收货", 'url' => U('Order/operateOrder'), 'type' => 'submit')
        ),
        '5' => array(
            "view" => array("text" => "查看物流", 'url' => U('Order/shippment'), 'type' => 'view'),
            "submit" => array("text" => "评价", 'url' => U('Appraise/order'), 'type' => 'appraise')
        ),
        '6' => ''
    );
}

/**
 * 订单详情页的按钮
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.7.6
 */
function orderDetailButton($status, $type = 0)
{
    $all = returnOrderDetail();
    $str = '';
    $orange = array('评价', '确认收货', '付款');
    foreach ($all[$status] as $key => $value) {
        if (($type == 1 && ($value['text'] == '查看物流' || $value['text'] == '提醒发货')) || ($type == 2 && $value['text'] == '快递到家')) {
            continue;
        }
        if (in_array($value['text'], $orange)) {
            $str .= "<span class='add-delivery-color j-operate' data-type='" . $value['type'] . "' data-url='" . $value['url'] . "'>";
        } else {
            $str .= "<span class='j-operate' data-type='" . $value['type'] . "' data-url='" . $value['url'] . "'>";
        }

        $str .= $value['text'];
        $str .= "</span>";
    }
    return $str;
}

/**
 * 订单详情页的商品的操作
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.12.7
 */
function returnOrderDetailGoods()
{
    return array(
        '1' => array(
            "cancel" => array("text" => "取消订单", 'url' => U('Order/operateOrder'), 'type' => 'cancel'),
            "submit" => array("text" => "继续付款", 'url' => U('Payment/pay'), 'type' => 'pay'),
        ),
        '2' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
        ),
        '3' => array(
            "warn" => array("text" => "提醒发货", 'url' => U('Order/operateOrder'), 'type' => 'warn'),
            "submit" => array("text" => "确认收货", 'url' => U('Order/operateOrder'), 'type' => 'submit'),
        ),
        '4' => array(
            "submit" => array("text" => "确认收货", 'url' => U('Order/operateOrder'), 'type' => 'submit')
        ),
        '5' => array(
            "cancel" => array("text" => "删除订单", 'url' => U('Order/operateOrder'), 'type' => 'submit'),
            "submit" => array("text" => "评价", 'url' => U('Appraise/order'), 'type' => 'appraise')
        ),
        '6' => ''
    );
}

/**
 * 订单详情页商品的按钮
 * @author liym  <yanming.li1@pactera.com>
 * @version 2016.7.6
 */
function orderDetailGoodsButton($status)
{
    $all = returnOrderDetail();
    $str = '';
    array_walk($all[$status], function ($value, $key) use (&$str) {
        $str .= "<span class='j-operate-button' data-type='" . $value['type'] . "' data-url='" . $value['url'] . "'>";
        $str .= $value['text'];
        $str .= "</span>";
    });
    return $str;
}

/**
 * 获取商品信息
 * @author liym <yanming.li1@pactera.com>
 * @version 2016.11.24
 */
function get_goods_info($goods_id, $field = '*')
{
    $data = D('Goods')->cache('goods')->getField('id, brand_id, category_id, name, stock_price, market_price, sale_price, express_price, is_putaway, status');
    return $field == '*' ? $data[$goods_id] : $data[$goods_id][$field];
}


/**
 * 生成订单sn
 * @author sunny5156  <137898350@qq.com>
 * @return string
 */
function createOrderSN()
{
    return date('YmdHi') . rand('100000', '999999');
}


/**
 * 银行卡号显示后四位
 * @author liym
 * @return string
 */
function cardNoToSign($no)
{
    $len = strlen($no);
    $tail = preg_replace('/^(\d*)(\d{4})$/', '$2', $no);
    $res = '';
    return str_pad($res, $len - 4, '*') . $tail;
}


//php获取当前访问的完整url地址 
function get_current_url(){ 
    $current_url='http://'; 
    if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'){ 
        $current_url='https://'; 
    } 
    if($_SERVER['SERVER_PORT']!='80'){ 
        $current_url.=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']; 
    }else{ 
        $current_url.=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; 
    } 
    return $current_url; 
}
