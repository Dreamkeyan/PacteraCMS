<?php
/**
 * 购物车控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 **/
namespace Mall\Controller;
use Think\Exception;

class CartController extends MobileBaseController {

    public function index() {
        session('cart_order', null);
        $scan = I('get.scan');
        $where = array(
            'member_id' => $this->mid,
        );
        if($scan){
            $where['is_scan'] = $scan;
        }
        $res = D("Cart")->cartList($where);
        
        $message_count = D('NotificationReceive')->getUnReadCount($this->mid);

        $this->assign('mcount', $message_count);
        $this->assign('data', $res['valid']);
        $this->assign('invalid', $res['invalid']);
        $this->display();
    }
    
    public function add() {
        try {
            $param = I('post.');
//            debug($param);
            natsort($param['goods_spec']);
            $cid = isset($param['cid'])?$param['cid']:0;
            
            $data = array(
                'member_id'=>$this->mid,
                'goods_id'=> $param['gid'],
                'goods_number'=>isset($param['num'])?$param['num']:1,
                'is_scan' => $param['t'] ?  $param['t']:0,
                'shop_id' => $param['sid'],
                'goods_name' => $param['gname'],
                'spec_key' => implode(',', $param['goods_spec']),
                'goods_spec' => $param['specname'],
                'goods_price' => $param['goodsprice'],
                'market_price' => $param['marketprice'],
                'remark' => $param['remark']
            );
            $m = M();
            $m->startTrans();
            $res = D('Cart')->update($data, $cid);
            
            //购物车编辑修改商品规格时操作
            if($cid !=0 && $res != $cid ){
                if(FALSE == D('Cart')->delete($cid)){
                    throw new Exception('删除失败');
                }
            }
               
            
            $m->commit();
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
            
        } catch (Exception $e) {
            $m->rollback();
            $this->ajaxReturn(array('status' => 0, 'msg' => $e->getmessage()));
        }
    }
    
    public function update() {
        $param = I('post.');
  
        if( D('Cart')->saveAllSql($param) != FALSE){
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => "操作失败"));
    }
    
    public function moveToCollect() {
        $param = I('post.');
        $res = D('Cart')->moveCollect($param);

        if(is_array($res)){
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功", 'data' => $res));
        }

        $this->ajaxReturn(array('status' => 0, 'msg' => "操作失败"));
    }
    
    public function delete() {
        $param = I('post.');
        $ids = implode(',', $param['del']);
//        debug($ids);
        if( FALSE != D('Cart')->delete($ids)){
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => "操作失败"));
    }
}
