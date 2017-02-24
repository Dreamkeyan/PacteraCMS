<?php

/**
 * 分类模型
 * @author liym  <yanming.li1@pactera.com>
 * @date 2016-10-27
 * @version
 */

namespace Mall\Model;

class CategoryModel extends MallBaseModel
{

    /**
     * @var string
     */
    protected $pk = 'id';

    /**
     * @var string
     */
    protected $tableName = 'mall_category';

    /**
     * @var array
     */
    protected $_auto = array(
        array('is_del', 0, self::MODEL_INSERT, 'string'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * @var array
     */
    protected $_validate = array(
        array('name', 'require', '类目名称不能为空！', 1),
        array('name', '', '类目名称已经存在！', 0, 'unique', 1),
    );

    /**
     * Get category by pid
     *
     * @param int $pid
     *
     * @return mixed
     */
    public function getByPid($pid = 0)
    {
        return $this->where(array(
            'pid' => array('eq', $pid),
            'is_del' => array('eq', 0)
        ))->select();
    }

    /**
     * Get the tree data
     *
     * @return mixed
     */
    public function getTreeData()
    {
        $cateids = $this->where(array('pid' => array('eq', 0)))->getField('id', true);

        return $this->where(array(
            'pid' => array(
                array('in', $cateids),
                array('eq', 0), 'or'),
            'is_del' => array('eq', 0)
        ))->getField('id, pid, name as text, sort');
    }


    /**
     * get sub cate tree data by pid
     *
     * @param $pid
     *
     * @return mixed
     */
    public function getSubCateTreeData($pid)
    {
        return $this->where(array(
            'pid' => array('eq', $pid),
            'is_del' => array('eq', 0)
        ))->getField('id, pid, name as text, sort');
    }

    /**
     * save the category
     *
     * @param     $name
     * @param int $pid
     *
     * @return bool|mixed
     */
    public function saveCate($name, $pid = 0)
    {
        $data = array(
            'name' => $name,
            'pid' => $pid
        );
        if ($this->create($data)) {
            return $this->add();
        } else {
            return false;
        }
    }

    /**
     * get options all
     *
     * @return mixed
     */
    public function getOptionAll()
    {
        return $this->where(array('is_del' => 0))->field('id, pid, name')->select();
    }

    /**
     * get level 3 cat ids
     *
     * @param $cid
     * @param $leaf
     *
     * @return mixed
     */
    public function getLev3CatIds($cid, $leaf)
    {
        if ($leaf) {
            return array($cid);
        }
        $ids = array($cid);
        $data = $this->find($cid);
        if (!$data['pid']) {
            $ids = $this->where(array('pid' => $cid))->getField('id', true);
        }
        return $this->where(array('pid' => array('in', $ids)))->getField('id', true);
    }

    /**
     * get select category data
     *
     * @param $cateid
     *
     * @return array
     */
    public function getSelectData($cateid)
    {
        $cate = $this->find($cateid);
        $children = $this->where(array('pid' => $cateid))->count();
        if ($children) {
            if ($cate['pid']) {
                $level1 = $this->find($cate['pid']);
                return array(
                    'Level1' => $level1['id'],
                    'Level2' => $cate['id'],
                );
            } else {
                return array('Level1' => $cate['id']);
            }
        } else {
            $level2 = $this->find($cate['pid']);
            $level1 = $this->find($level2['pid']);
            return array(
                'Level1' => $level1['id'],
                'Level2' => $level2['id'],
                'Level3' => $cate,
            );
        }
    }

    /**
     * check the delete category
     *
     * @param $cateid
     *
     * @return bool
     */
    public function delCheck($cateid)
    {
        $children = $this->where(array(
            'pid' => $cateid,
            'is_del' => 0
        ))->count();
        $goods = D('Goods')->where(array(
            'category_id' => $cateid,
            'is_del' => 0
        ))->count();

        return ($children > 0 || $goods > 0) ? false : true;
    }

    /**
     * get the shops options
     */
    public function getOptions()
    {
        return $this->where(array('is_del' => array('neq', 1)))->getField('id, pid, name');
    }

}
