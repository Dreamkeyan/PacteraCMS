<?php

/**
 * 商品图片模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

class GoodsImageModel extends MallBaseModel
{

    protected $pk = 'id';
    protected $tableName = 'mall_goods_image';

    /**
     * @var array
     */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 获取商品所有的图片
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function goodsImg($goods_id)
    {
        $where = array(
            'goods_id' => $goods_id,
            'status' => 1
        );
        return $this->field('img_url')->where($where)->select();
    }

    /**
     * 获取商品第一张图片
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function goodsIndexImg($goods_id)
    {
        $where = array(
            'goods_id' => $goods_id,
            'status' => 1
        );
        return $this->field('img_url')->where($where)->order('id ASC')->find();
    }
}

