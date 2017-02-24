<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;


use Think\Exception;

class MenuController extends CommonController {

    private $create_fields = array('parent_id', 'menu_name' ,'icon');
    private $edit_fields = array('menu_id', 'menu_name','icon');

    public function index() {
        $menu = D('Menu')->fetchAll();
        $this->assign('datas', $menu);
        $this->display();
    }

    /**
     * 添加菜单
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月20日10:55:56
     */
    public function add()
    {
        $parent_id = I("get.parent_id",0);
        $this->assign('parent_id',$parent_id);
        $this->display();
    }

    /**
     * 编辑
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月20日11:37:49
     */
    public function edit() {
        $obj = D('Menu');
        $menu_id = I("get.menu_id");
        $menu = $obj->fetchAll();
        try{
            if(empty($menu_id)){
                throw new Exception('参数不完整!');
            }
            if(!isset($menu[$menu_id])){
                throw new Exception('请选择要编辑的菜单!');
            }
            $this->assign('detail', $menu[$menu_id]);
            $this->display();
        }catch (Exception $e){
            $this->simpleError($e->getMessage());
        }
    }



    /**
     * 保存菜单
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月20日10:58:18
     */
    public function save()
    {
        if (IS_POST) {
            $data = I("post.data");
            $obj = D('Menu');
            try{
                //有menu_id  则为修改
                if(isset($data['menu_id'])){
                    $data = $this->editCheck();
                    $res = $obj->where(array('menu_id'=>$data['menu_id']))->save($data);
                }
                //有parent_id  则为添加
                if(isset($data['parent_id'])){
                    $data = $this->createCheck();
                    $res = $obj->add($data);
                }
                if(!$res){
                    throw new Exception('操作失败');
                }
                $obj->cleanCache();
                $this->simpleSuccess('操作成功', U('menu/index'));
            }catch (Exception $e){
                $this->simpleError($e->getMessage());
            }
        } else{
            $this->simpleError('请求错误！');
        }
    }

    public function action($parent_id = 0) {
        if (!$parent_id = (int) $parent_id)
            $this->simpleError('请选择正确的父级菜单');
        if (IS_POST) {
            $data = I('post.data', false);
            $new = I('post.new', false);
            $obj = D('Menu');
            foreach ($data as $k => $val) {
                $local = array();
                $local['menu_id'] = (int) $k;
                $local['menu_name'] = htmlspecialchars($val['menu_name'], ENT_QUOTES, 'UTF-8');
                $local['orderby'] = (int) $val['orderby'];
                $local['menu_action'] = htmlspecialchars($val['menu_action'], ENT_QUOTES, 'UTF-8');
                $local['is_show'] = (int) $val['is_show'];
                if (!empty($local['menu_name']) && !empty($local['menu_id']) && !empty($val['menu_action'])) {
                    $obj->save($local);
                }
            }
            if (!empty($new)) {
                foreach ($new as $k => $val) {
                    $local = array();
                    $local['menu_name'] = htmlspecialchars($val['menu_name'], ENT_QUOTES, 'UTF-8');
                    $local['orderby'] = (int) $val['orderby'];
                    $local['menu_action'] = htmlspecialchars($val['menu_action'], ENT_QUOTES, 'UTF-8');
                    $local['is_show'] = (int) $val['is_show'];
                    $local['parent_id'] = $parent_id;
                    if (!empty($local['menu_name']) && !empty($val['menu_action'])) {
                        $obj->add($local);
                    }
                }
            }
            $obj->cleanCache();
            $this->simpleSuccess('更新成功', U('menu/index'));
        } else {
            $menu = D('Menu')->fetchAll();
            $this->assign('datas', $menu);
            $this->assign('parent_id', $parent_id);
            $this->display();
        }
    }

    public function update() {
        $orderby = I('post.orderby', false);
        $obj = D('Menu');
        foreach ($orderby as $key => $val) {
            $data = array(
                'menu_id' => (int) $key,
                'orderby' => (int) $val
            );
            $obj->save($data);
        }
        $obj->cleanCache();
        $this->simpleSuccess('更新成功', U('menu/index'));
    }
    /**
     * 删除
     * @param int $menu_id
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月20日11:55:43
     */
    public function delete($menu_id = 0) {
        if ($menu_id = (int) $menu_id) {
            $obj = D('Menu');
            $menu = $obj->fetchAll();
            foreach ($menu as $val) {
                if ($val['parent_id'] == $menu_id)
                    $this->simpleError('该菜单下还有其他子菜单');
            }
            $obj->delete($menu_id);
            $obj->cleanCache();
            $this->simpleSuccess('删除成功！', U('menu/index'));
        }else{
            $this->simpleError('请选择要删除的菜单');
        }
    }

    /**
     * 菜单图标管理
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月20日10:54:19
     */
    public function icon()
    {
        $id = I("get.id");
        $this->assign('id',$id);
        $this->display();
    }

    private function createCheck() {
        $data = $this->checkFields(I('post.data', false), $this->create_fields);
        $data['parent_id'] = (int) $data['parent_id'];
        if (empty($data['menu_name'])) {
            $this->simpleError('请输入菜单名称');
        }
        $data['menu_name'] = htmlspecialchars($data['menu_name'], ENT_QUOTES, 'UTF-8');
        $data['is_show'] = 1;
        $data['icon'] = $data['icon'];
        return $data;
    }

    private function editCheck() {
        $data = $this->checkFields(I('post.data', false), $this->edit_fields);
        $data['menu_id'] = (int) $data['menu_id'];
        if (empty($data['menu_name'])) {
            $this->simpleError('请输入菜单名称');
        }
        $data['menu_name'] = htmlspecialchars($data['menu_name'], ENT_QUOTES, 'UTF-8');
        $data['is_show'] = 1;
        $data['icon'] = $data['icon'];
        return $data;
    }

}
