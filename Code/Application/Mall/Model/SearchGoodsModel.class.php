<?php

/**
 * 搜索商品模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

use Common\Model\CommonModel;

class SearchGoodsModel extends MallBaseModel {

    protected $pk = 'id';
    protected $tableName = 'mall_search_goods';

    /**
     * 获取搜索商品的列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function getGoodsIdBySearch($search_id) {
        $where = array(
            'search_id' => $search_id,
            'status' => 1
        );
        
        return $this->where($where)->select();
    }

}
