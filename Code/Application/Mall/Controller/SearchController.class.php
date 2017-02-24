<?php
/**
 * 搜索控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 **/
namespace Mall\Controller;

class SearchController extends MobileBaseController {

    public function index($cate_id = 0) {
//        $data = D("Search")->getList($cate_id);
        $this->display();
    }
    
    public function searchGoodsById($search_id = 0) {
        $goods_data = D("Search")->getGoodsBySearch($search_id);
        $this->display();
    }
    
    public function searchGoodsByKey($keyword = '') {

    }

}
