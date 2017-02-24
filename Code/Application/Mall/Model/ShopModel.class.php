<?php
namespace Mall\Model;

/**
 * Class ShopModel
 *
 * @package Mall\Model
 */
class ShopModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'mall_shop';

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
    );

    /**
     * This function is for search init
     */
    protected function _initSearch()
    {
        $this->where['is_del'] = array('eq', 1);
        $this->order = 'create_time desc';
    }

    /**
     * This function is handle the request params
     *
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {
        if ($params['keywords']) {
            $this->where['_complex'] = array(
                'id' => array('like', '%' . $params['keywords'] . '%'),
                'member_id' => array('like', '%' . $params['keywords'] . '%'),
                '_logic' => 'or'
            );
        }
        if ($params['hatcher'] || $params['hatcher'] === '0') {
            $this->where['is_hatcher'] = $params['hatcher'];
        }
        if ($params['status'] || $params['status'] === '0') {
            $this->where['status'] = $params['status'];
        }
    }

    /**
     * Get shop list by member id
     *
     * @param $member_id
     *
     * @return mixed
     */
    public function getListByMember($member_id)
    {
        $where = array(
            'member_id' => $member_id,
            'is_del' => 1,
            'status' => 1
        );

        return $this->where($where)->relation(true)->Select();
    }

    /**
     * Get shop detail by where
     *
     * @param $where
     *
     * @return mixed
     */
    public function getDetailByWhere($where)
    {
        return $this->where($where)->find();
    }

    /**
     * get the shops options
     */
    public function getOptions()
    {
        return $this->where(array('is_del' => array('neq', -1)))->getField('id, name');
    }

}