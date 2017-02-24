<?php
/**
 * 订单控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 **/
namespace Mall\Controller;

use Think\Exception;

class OrderController extends MobileBaseController {
    
    /**
     * 订单列表
     * 
     * @autho liym<yanming.li1@pactera.com>
     * @version 
     * @todo  2016.11.24
     */
    public function index() {
        $param = I('get.');
        $param['member_id'] = $this->mid;
        if($param['status'] == 3){
            $param['status'] = array('in', array(2, 3));
        }
        $list = D('order')->getListInfo($param);

        $this->assign('list', $list);
        $this->display();
    }
    
    /**
     * 订单详情
     * 
     * @autho liym<yanming.li1@pactera.com>
     * @version 
     * @todo  2016.11.24
     */
    public function detail() {
        $param = I('get.');
        //订单信息
        $param['member_id'] = $this->mid;
        $detail = D('Order')->getDetailInfo($param);

        //地址信息
        $addr = D('Member/MemberAddress')->getAddressInfo($detail['addr_id']);
        $detail['addr'] = $addr;
        
        //商铺信息
        $shop = D("Shop")->getDetailByWhere(array('id'=>$detail['shop_id']));
        $detail['shop'] = $shop;
        $this->assign('data', $detail);
        $this->display();
    }
    
    /**
     * 生成订单
     * 
     * @autho liym<yanming.li1@pactera.com>
     * @version 
     * @todo  2016.11.24
     */
    public function makeOrder() {

        $get_param = I('get.');
        $param = I('post.');
        $addr_id = 0;
        if($this->mid){
            //默认地址
            if($this->member['extend']['default_addr_id'] != 0){
                $addr_id = $this->member['extend']['default_addr_id'];
            }
            
            //选择地址
            if ($get_param['addr_id'] && $get_param['from'] == 'order') {
                $addr_id = $get_param['addr_id'];
            }
            //地址信息
            $address = D('Member/MemberAddress')->getAddressInfo($addr_id);
            if(!empty($address)){
                $addr = $address;
                $addr['addr'] = get_province($addr['province_id'], 'province_name').get_city($addr['city_id'], 'city_name').get_county($addr['county_id'], 'county_name').$addr['address'];
            }
        }
        //选择地址插入session
        if ($get_param['addr_id'] && $get_param['from'] == 'order' && session('cart_order')) {
            session('cart_order.addr_id', $addr['id']);
            session('cart_order.address', $addr['addr']);
            session('cart_order.mobile', $addr['phone']);
            session('cart_order.realname', $addr['name']); 
        }
        
        //提交信息
        if(IS_POST){
            $shop_order = array();
            $order = array();
            $order['count'] = 0;
            $order['price'] = 0;
            //购物车结算
            if($get_param['from'] == 'cart'){
                $order['is_scan'] = $get_param['scan'] ? $get_param['scan']:0;
                $cart_list = D('Cart')->cartList(array('id'=>array('in', implode(',', $param['cart']))));
                $goods_info = $cart_list['valid'];
                foreach ($goods_info as $key => $value) {
                    $shop_order[$key]['total_count'] = count($value);
                    $shop_order[$key]['total_price'] = 0;
                    $order['count'] += $shop_order[$key]['total_count'];
                    $shop_order[$key]['express_price'] = 0;
                    foreach ($value as $k => $v) {
                        $shop_order[$v['shop_id']]['total_price'] += $v['goods_number']*$v['goods_price'];
                        $express_price = get_goods_info($v['goods_id'], 'express_price');
                        $shop_order[$v['shop_id']]['express_price'] = $express_price > $shop_order[$v['shop_id']]['express_price'] ? $express_price: $shop_order[$v['shop_id']]['express_price'];
                    }
                    $order['price'] += $shop_order[$key]['total_price'];
                    $shop_order[$key]['remark'] = '';
                    $shop_order[$key]['pay_type'] = 1; 
                    $shop_order[$key]['deliver_type'] = 1;
                    $shop_order[$key]['sn'] = createOrderSN();
                    $shop_order[$key]['actual_amount'] =  $shop_order[$key]['total_price'];
                }

            }else if($get_param['from'] == 'goods'){//商品页立即购买
                
                asort($param['goods_spec']);
                
                $goods_info = array();
                $list = array($param['sid']=>$param);
                
                foreach ($list as $key => $value) {
                    $goods_id = $value['gid'];
                    $shop_order[$key]['total_count'] = $value['num'];
                    $shop_order[$key]['total_price'] = $value['num']*$value['goodsprice'];
                    $shop_order[$key]['remark'] = '';
                    $shop_order[$key]['pay_type'] = 1; 
                    $shop_order[$key]['deliver_type'] = 1;
                    $shop_order[$key]['sn'] = createOrderSN();
                    $shop_order[$key]['express_price'] = $value['expressprice'];
                    $shop_order[$key]['actual_amount'] = $shop_order[$key]['total_price'];
                    
                    $order['count'] = $shop_order[$key]['total_count'];
                    $order['price'] = $shop_order[$key]['total_price'];
                    
                    $goods_info[$key][0]['goods_id'] = $value['gid'];
                    $goods_info[$key][0]['goods_name'] = $value['gname'];
                    $goods_info[$key][0]['member_id'] = $this->mid;
                    $goods_info[$key][0]['goods_number'] = $value['num']; 
                    $goods_info[$key][0]['shop_id'] = $value['sid'];
                    $goods_info[$key][0]['spec_key'] = implode(',', $value['goods_spec']);
                    $goods_info[$key][0]['goods_spec'] = $value['specname'];
                    $goods_info[$key][0]['market_price'] = $value['marketprice']; 
                    $goods_info[$key][0]['goods_price'] = $value['goodsprice'];
                    $goods_info[$key][0]['is_scan'] = $value['t'] ? $value['t']:0;
                }
            }
            
            //商品信息不为空的时候
            if(!empty($addr) && !empty($goods_info)){
                $order['addr_id'] = $addr['id'];
                $order['address'] = $addr['addr'];
                $order['mobile'] = $addr['phone'];
                $order['realname'] = $addr['name'];
            }
            $order['member_id'] = $this->mid;
            $order['goods'] = $goods_info;
            $order['shops'] = $shop_order;
//            debug($order);
            if (!session('cart_order') && !empty($goods_info)) {
                session('cart_order', $order);
            } 
            
        }
//        debug(session('cart_order'));
        if (session('cart_order')) {
            $order = session('cart_order');
            $this->assign('data', $order);
            $this->assign('addr', $addr);
            $this->assign('shops', $order['shops']);
            $this->assign('goods', $order['goods']);
        }else{
            $this->redirect('Cart/index');
        }
        

        $this->assign('self_out_time', strtotime("+1 day"));
        $this->display();
    }
    
    /**
     * 保存订单
     * @author liym  <yanming.li1@pactera.com>
     * @version 2016.11.24
     */
    public function saveOrder() {
        if (IS_POST) {
            if ($_POST['data'] == 'save' && !empty($_SESSION['cart_order'])) {

                $data = $_SESSION['cart_order'];
//                debug($data);
                // 写入订单信息
                $model = M();
                try {
                    $shops = $data['shops'];
                    $goods = $data['goods'];
                    
                    $order_param = array();
                    $cart_ids = array();
                    $goods_ids = array();
                    $spec_keys = array();
                    $goods = array();
                    foreach ($shops as $key => $value) {
                        $order_param[$key] = array(
                            'shop_id' => $key,
                            'member_id' => $this->mid,
                            'order_sn' => $value['sn'],
                            'addr_id' => $data['addr_id'],
                            'deliver_type' => $value['deliver_type'], //1-自提，2-送货上门
                            'pay_type' => $value['pay_type'],//1-余额，2-银行卡，3-微信，4-支付宝
                            'is_scan' => $data['is_scan'] ? $data['is_scan']:0, //1-门店2-网店
                            'remark' => $value['remark'],
                            'total_count' => $value['total_count'],
                            'total_amount' => $value['total_price'],
                            'actual_amount' => $value['actual_amount'],
                            'express_price' => $value['express_price'],
                            'status'=>1
                        );
                        
                        $cart_ids = array_merge($cart_ids, array_column($data['goods'][$key], 'id'));
                        
                        $goods_ids = array_merge($goods_ids, array_column($data['goods'][$key], 'goods_id'));
                        
                        $spec_keys = array_merge($spec_keys, array_column($data['goods'][$key], 'spec_key'));
                        
                        $goods = array_merge($goods, $data['goods'][$key]);
                    }
                    
                    !$goods_ids && $goods_ids = [0]; 
                    !$spec_keys && $spec_keys = [0]; 
                    //验证商品库存
                    $goods_spec = D('GoodsSpecPrice')->getListByWhere(array('goods_id'=>array('in',$goods_ids), 'key'=>array('in',$spec_keys)));
                    foreach ($goods as $value) {
                        foreach ($goods_spec as $v) {
                            if($v['goods_id'] == $value['goods_id'] && $v['key'] == $value['spec_key']){
                                if($v['store_count'] < $value['goods_number']){
                                    throw new Exception($value['goods_name'].'库存不够');
                                }
                            }
                        }
                    }
                    //开启事物
                    $model->startTrans();

                    //删除购物车
                    if(!empty($cart_ids)){
                        $map['id'] = array('in', array_unique($cart_ids));
                        D('Cart')->where($map)->delete();
                    }

                    $res = D("Order")->insertOrder($order_param, $data['goods']);

                    session('cart_order', NULL);
                    
                    $model->commit();
                    
                    $return = array(
                            'status' => '1',
                            'data' => array(
                                'pay_type' => $data['pay_type'],
                                'order_id' => $res
                            )
                        );
                    $this->ajaxReturn($return);
                } catch (Exception $e) {
                    $model->rollback();
                    $return = array(
                            'status' => '0',
                            'msg' => $e->getMessage()
                        );
                    $this->ajaxReturn($return);
                }
            }
        }
    }
    
    /**
     * 动态修改支付方式 配送方式, 备注
     * @author liym  <yanming.li1@pactera.com>
     * @version 2016.11.24
     */
    public function setSessionOrder() {
        if (IS_POST) {
            $param = I('post.');
            if($param['type'] == 'shops'){
                $_SESSION['cart_order'][$param['type']][$param['sid']][$param['key']] = $param['value'];
                
            }
            
            if($param['key'] == 'deliver_type'){
                //店铺总价修改
                $actual_amount = $param['value'] == 1 ? 0 : $_SESSION['cart_order'][$param['type']][$param['sid']]['express_price'];
                $_SESSION['cart_order'][$param['type']][$param['sid']]['actual_amount'] = $_SESSION['cart_order'][$param['type']][$param['sid']]['total_price'] + $actual_amount;
                
                //总价修改
                $total = 0;
                foreach ($_SESSION['cart_order']['shops'] as $key => $value) {
                    $total += $value['actual_amount'];
                }
                $_SESSION['cart_order']['price'] = $total;
            }

            $this->ajaxReturn(array('status'=>1));
        }
    }
    
    /**
     * 订单操作
     * @author liym  <yanming.li1@pactera.com>
     * @version 2016.11.24
     */
    public function operateOrder() {
        if (IS_AJAX) {
            if (IS_POST) {
                $param = I('post.');

                // 修改订单信息
                $model = M();
                try {
                    $param['member_id'] = $this->mid;
                    $order = D('Order')->getDetailInfo($param);

                    //开启事物
                    $model->startTrans();

                    if ($param['type'] == 'cancel') {//取消订单

                        $data = array('status' => 0, 'update_time'=>NOW_TIME);
                    }  else if ($param['type'] == 'del') {//删除订单 

                        $data = array('is_del' => 1, 'update_time'=>NOW_TIME);
                    } else if ($param['type'] == 'submit') {//确认收货 

                        $data = array('status' => 5, 'update_time'=>NOW_TIME);
                    } else if ($param['type'] == 'warn') {//确认收货 

                        $data = array('is_warn' => $order['is_warn']+1, 'update_time'=>NOW_TIME);
                    } else if ($param['type'] == 'deliver') {//确认收货 

                        $data = array('deliver_type' => 2, 'update_time'=>NOW_TIME);
                    }
                    
                    
                    //修改微信端订单状态
                    $result = D('Order')->updateInfo($order['id'], $data);
      
                    if (!$result) {
                        throw new Exception('操作失败，稍后重试！');
                    }

                    $return = array('status' => 1, 'msg' => '操作成功！');
                    
                    // 提交事务
                    $model->commit();
                } catch (Exception $e) {

                    $model->rollback();

                    //返回消息
                    $return = array('status' => '0', 'msg' => $e->getMessage());
                }
            }
        } else {
            $return = array('status' => 0, 'msg' => '失败');
        }

        $this->ajaxReturn($return);
    }
}
