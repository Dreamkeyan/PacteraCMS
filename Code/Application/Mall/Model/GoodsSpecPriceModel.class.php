<?php


/**
 * 商品规格模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-1-4
 * @version
 */

namespace Mall\Model;

class GoodsSpecPriceModel extends MallBaseModel
{

    protected $pk = 'id';
    protected $tableName = 'mall_goods_spec_price';

    /**
     * @var array
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT)
    );

    /**
     * 获取商品规格
     */
    public function get_spec($goods_id)
    {
        //商品规格 价钱 库存表 找出 所有 规格项id  (getField 函数的原因使用_)
        $keys = $this->where("goods_id = $goods_id")->getField("GROUP_CONCAT(`key` SEPARATOR '_')");
        $result = array();
        if ($keys) {
            $keys = str_replace('_', ',', $keys);
            $sql = "SELECT a.spec_name,a.sort,b.* FROM pactera_mall_spec AS a INNER JOIN pactera_mall_spec_item AS b ON a.id = b.spec_id WHERE b.id IN($keys) ORDER BY b.id";
            $filter_spec = M()->query($sql);
            foreach ($filter_spec as $key => $val) {
                $result[$val['spec_name']][] = array(
                    'item_id' => $val['id'],
                    'item' => $val['item'],
                );
            }
        }
        return $result;
    }

    /**
     * 获取商品规格列表
     */
    public function getListByWhere($where)
    {
        return $this->where($where)->select();;
    }

}

