<?php

/**
 * 商品模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

use Think\Exception;
use Mall\Model\SearchGoodsModel;

class GoodsModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_goods';

    /**
     * @var string
     */
    protected $relation = true;

    /**
     * @var array
     */
    protected $_link = array(
        'category' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Category',
            'foreign_key' => 'category_id',
            'mapping_fields' => 'id, pid, name'
        ),
        'brand' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name' => 'Brand',
            'foreign_key' => 'brand_id',
            'mapping_fields' => 'id, name, logo'
        ),
        'images' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'GoodsImage',
            'foreign_key' => 'goods_id',
        ),
        'attrs' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'GoodsAttr',
            'foreign_key' => 'goods_id',
        ),
        'specs' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name' => 'GoodsSpecPrice',
            'foreign_key' => 'goods_id',
        )
    );

    /**
     * 获取商品列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function getList($id = 0, $type = 0)
    {
        $where = array(
            'is_putaway' => 1,
            'status' => array('gt', 0)
        );
        if ($type == 1) {
            $where['category_id'] = array('in', $id);
        }
        if ($type == 2) {
            $search = D('SearchGoods')->getGoodsIdBySearch($id);
            $goods_id = array_column($search, 'goods_id');
            !$goods_id && $goods_id = [0];
            $where['id'] = array('in', $goods_id);
        }
        $push = $this->pushList($where);

        $hot = $this->hotList($where);

        $new = $this->newList($where);

        $price = $this->priceList($where);
        return array(
            'push' => $push,
            'hot' => $hot,
            'new' => $new,
            'price' => $price
        );
    }

    /**
     * 推荐商品
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function pushList($where = array())
    {
        if (empty($where)) {
            $where = array(
                'is_putaway' => 1,
                'status' => array('gt', 0)
            );
        }

        return $this->where($where)->order('collect_number DESC')->select();
    }

    /**
     * 人气商品
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function hotList($where = array())
    {
        if (empty($where)) {
            $where = array(
                'is_putaway' => 1,
                'status' => array('gt', 0)
            );
        }

        return $this->where($where)->order('sale_count DESC')->limit(10)->select();
    }

    /**
     * 最新商品
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function newList($where = array())
    {
        if (empty($where)) {
            $where = array(
                'is_putaway' => 1,
                'status' => array('gt', 0)
            );
        }

        return $this->where($where)->order('create_time DESC')->limit(10)->select();
    }

    /**
     * 商品价格排行
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function priceList($where = array())
    {
        if (empty($where)) {
            $where = array(
                'is_putaway' => 1,
                'status' => array('gt', 0)
            );
        }

        return $this->where($where)->order(' sale_price DESC')->limit(10)->select();
    }

    /**
     * 商品详情
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function detail($goods_id)
    {
        return $this->find($goods_id);
    }

    /**
     * This function is for search init
     */
    protected function _initSearch()
    {
        $this->where['is_del'] = array('neq', 1);
        $this->order = 'create_time desc';
    }

    /**
     * This function is handle the request params
     *
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {
        if ($params['category_id']) {
            $this->where['category_id'] = $params['category_id'];
        }
        if ($params['brand_id']) {
            $this->where['brand_id'] = $params['brand_id'];
        }
        if (isset($params['is_push']) && $params['is_push'] !== '') {
            $this->where['is_push'] = $params['is_push'];
        }
        if (isset($params['is_putaway']) && $params['is_putaway'] !== '') {
            $this->where['is_putaway'] = $params['is_putaway'];
        }
        if ($params['keywords']) {
            $this->where['name'] = array('like', '%' . $params['keywords'] . '%');;
        }
    }

    /**
     * 商品收藏数量的操作
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-27
     **/
    public function setCollectNumber($goods_id, $operation)
    {
        try {
            $sql = "UPDATE `pactera_mall_goods` SET `collect_number`= collect_number" . $operation . "1 WHERE `id` = " . $goods_id;
            $res = M()->execute($sql);
            if (empty($res)) {
                throw new Exception('收藏数量操作失败');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * get goods total num by category
     *
     * @param array $catids
     *
     * @return mixed
     */
    public function getNumByCatids(array $catids)
    {
        return $this->where(array('category_id' => array('in', $catids)))->count();
    }

    /**
     * get form data
     *
     * @param $id
     *
     * @return mixed
     */
    public function getFormData($id)
    {
        $data = D('Goods')->relation(true)->find($id);
        if ($data['specs']) {
            $data['specs'] = array_map(function ($item) {
                $item['key'] = implode('_', explode(',', $item['key']));
                return $item;
            }, $data['specs']);
        }

        return $data;
    }

}
