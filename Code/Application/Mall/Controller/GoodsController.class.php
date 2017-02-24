<?php
/**
 * 商品控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 **/
namespace Mall\Controller;

class GoodsController extends MobileBaseController {

    public function detail($id) {
        session('cart_order', null);

        $detail = D("goods")->detail($id);
        
        $all_spec = D('GoodsSpecPrice')->get_spec($id);
        $detail['spec'] = $all_spec;
        
        $spec_goods_price  = D('GoodsSpecPrice')->where("goods_id = $id")->getField("key,key_name,price,store_count"); // 规格 对应 价格 库存表
        
//        debug($spec_goods_price);
        $this->assign('spec_goods_price', json_encode($spec_goods_price,true));
        $this->assign('data', $detail);
        $this->display();
    }
    
    /**
     * 获取商品列表
     * @param int $cate_id 分类id
     * @author liym <yanming.li1@pactera.com>
     * @return array 
     * @date 2016.10.27
     **/
    public function goodsList($id = 0, $type = 0) {
        
        if($type == 1){
            $result = D('Category')->getByPid($id);
            $ids = array_column($result, 'id');
            array_push($ids, $id);
            $id = $ids;
        }
        
        $list = D('Goods')->getlist($id, $type);
        if($type == 2){
            $this->assign('search_id', $id);
        }
        
        $this->assign('list', $list);
        $this->display();
    }
    
    /**
     * 获取商品规格信息
     * @param int $goods_id
     * @author liym <yanming.li1@pactera.com>
     * @return array 
     * @date 2017.1.2
     **/
    public function goodsSpecInfo() {
        $param = I('post.');
        $goods_id = isset($param['goods_id']) ? $param['goods_id']:0;
        
        array_walk($param, function(&$value, $key) {
            if($key=='default_key'){
                $value = explode(',', $value);
            }
        });

        $detail = D("goods")->detail($goods_id);
        
        $all_spec = D('GoodsSpecPrice')->get_spec($goods_id);
        $detail['spec'] = $all_spec;
        
        $spec_goods_price  = D('GoodsSpecPrice')->where("goods_id = $goods_id")->getField("key,key_name,price,store_count"); // 规格 对应 价格 库存表
        
        $this->assign('spec_goods_price', json_encode($spec_goods_price,true));
        $this->assign('data', $detail);
        $this->assign('param', $param);
        $this->display();
    }
}
