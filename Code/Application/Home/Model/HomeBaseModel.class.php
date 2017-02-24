<?php
namespace Home\Model;
use Common\Model\CommonModel;

class HomeBaseModel extends CommonModel {
    
    protected $page;

    /**
     * 获取列表
     * @param  string   $where    查询条件
     * @param  string   $order   排序
     * @param  string   $field    字段 true-所有字段
     * @return array              列表
     */
    public function lists($where, $order, $field = true){
        return $this->field($field)->where($where)->order($order)->select();
    }
    
    /**
     * 获取分类
     * @param  string   $where    查询条件
     * @param  string   $order   排序
     * @param  string   $field    字段 true-所有字段
     * @return array              列表
     */
    public function category($where, $order, $field = true){
        return $this->field($field)->where($where)->order($order)->select();
    }
    
    /**
     * 获取详情页数据
     * @param  integer $id 文档ID
     * @return array       详细数据
     */
    public function detail($id){
        /* 获取基础数据 */
        $info = $this->field(true)->find($id);
        return $info;
    }
}

