<?php

namespace Mall\Model;

use Think\model;

/**
 * Class MemberModel
 * @package Mall\Model
 */
class MemberModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $tableName = 'member';

    /**
     * This function is for search init
     */
    protected function _initSearch()
    {
        $this->order = 'id desc';
    }

    /**
     * This function is handle the request params
     *
     * @param array $params
     */
    protected function _searchPrams(array $params = array())
    {

    }

    /**
     * This function is search by keyword for select2 options
     *
     * @param $q
     *
     * @return mixed
     */
    public function searchKeyword($q)
    {
        return $this->where(array(
            'name' => array('like', '%' . $q . '%')
        ))->field('id, name')->select();
    }

    /**
     * get member by number
     *
     * @param $num
     *
     * @return mixed
     */
    public function getByNumber($num)
    {
        return $this->where(array('member_number' => $num))->find();
    }

}
