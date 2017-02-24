<?php

namespace Mall\Service;

use Think\Model;

/**
 * This is the rule tree service
 *
 * @author 柴懋 <mao.chai@pactera.com>
 */
class CategoryService extends Model
{

    /**
     * @var string
     */
    protected $tableName = 'mall_category';

    /**
     * @var array
     */
    private $treeData = array();

    /**
     * @var array
     */
    private $treeList = array();

    /**
     * @return mixed
     */
    private function _getAllCates()
    {
        return $this->where(array(
            'is_del' => array('neq', 1)
        ))->getField('id, pid, name');
    }

    /**
     * Get tree data
     *
     * @param bool $json
     *
     * @return array|string
     */
    public function getTreeData($json = false)
    {
        $allCates = $this->_getAllCates();
        // handle
        foreach ($allCates as $cate) {
            if (isset($allCates[$cate['pid']])) {
                $allCates[$cate['pid']]['children'][] = &$allCates[$cate['id']];
            } else {
                $this->treeData[] = &$allCates[$cate['id']];
            }
        }

        return $json ? json_encode($this->treeData) : $this->treeData;
    }

    /**
     * Get tree list data
     *
     * @return array
     */
    public function getTreeList()
    {
        $tree = $this->getTreeData();
        $this->_transformTreeData($tree);

        return $this->treeList;
    }

    /**
     * transform tree data to list data
     *
     * @param array $nodes
     * @param int   $level
     * @param bool  $p_last
     */
    private function _transformTreeData(array $nodes = array(), $level = 1, $p_last = false, $pkey = null)
    {
        // level total
        $total = count($nodes);
        // transform
        foreach ($nodes as $key => $node) {
            $data = array_filter($node, function ($v) {
                return !is_array($v);
            });
            $last = ($key + 1) == $total ? true : false;
            $children = isset($node['children']) ? count($node['children']) : '';
            $skey = $pkey ? $pkey . '_' . $node['id'] : $node['id'];
            $this->treeList[] = array_merge($data, array(
                'key' => $skey,
                'level' => $level,
                'last' => $last,
                'plast' => $p_last,
                'children' => $children
            ));
            if ($node['children']) {
                $this->_transformTreeData($node['children'], $level + 1, $last, $skey);
            }
        }
    }

}
