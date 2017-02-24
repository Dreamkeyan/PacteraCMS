<?php

/**
 * 角色
 * @author liym  <724652240@qq.com>
 * @date 2016-04-25
 * @version
 */

namespace Manage\Controller;

use Think\Page;

class RoleController extends CommonController
{

    private $create_fields = array('role_name');
    private $edit_fields = array('role_name');

    public function index()
    {
        $Role = D('Role');
        $list = $Role->toPage(I());
        $this->assign(array(
            'list' => $list,
            'page' => $Role->getPage(),
            'data' => I(),
        ));
        $this->display(); // 输出模板
    }

    public function auth($role_id = 0)
    {
        if (($role_id = (int)$role_id) && $detail = D('role')->find($role_id)) {
            if (IS_POST) {
                $menu_ids = I('post.menu_id');
                $obj = D('RoleMaps');
                $obj->delete(array('where' => " role_id = '{$role_id}' "));
                foreach ($menu_ids as $val) {
                    if (!empty($val)) {
                        $data = array(
                            'role_id' => $role_id,
                            'menu_id' => (int)$val,
                        );
                        $obj->add($data);
                    }
                }
                $this->simpleSuccess('授权成功！', U('role/index'));
            } else {
                $menu = D('Menu')->fetchAll();
                $Menu_maps = D('RoleMaps')->getMenuIdsByRoleId($role_id);
                $menu_result = array();
                foreach ($menu as $value) {
                    foreach ($Menu_maps as $value2) {

                    }
                }
                $this->assign('menus', $menu);
                $this->assign('menuIds', $Menu_maps);
                $this->assign('role_id', $role_id);

                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->error('请选择正确的角色');
        }
    }

    public function add()
    {
        if (IS_POST) {
            $data = $this->createCheck();
            $obj = D('Role');
            if ($obj->add($data)) {
                $obj->cleanCache();
                $this->simpleSuccess('添加成功', U('role/index'));
            }
            $this->simpleError('操作失败！');
        } else {
            $this->display();
        }
    }

    public function edit($role_id = 0)
    {
        if ($role_id = (int)$role_id) {
            $obj = D('Role');
            $role = $obj->fetchAll();
            if (!isset($role[$role_id])) {
                $this->simpleError('请选择要编辑的角色');
            }
            if (IS_POST) {
                $detail = $obj->find($role_id);
                $data = $this->editCheck();
                $data['role_id'] = $role_id;
                if ($data['role_name'] == $detail['role_name']) {
                    $this->simpleSuccess('操作成功', U('role/index'));
                }
                if ($obj->save($data)) {
                    $obj->cleanCache();
                    $this->simpleSuccess('操作成功', U('role/index'));
                }
                $this->simpleError('操作失败');
            } else {
                $this->assign('detail', $role[$role_id]);
                $this->display();
            }
        } else {
            $this->simpleError('请选择要编辑的角色');
        }
    }

    public function delete($role_id = 0)
    {
        if ($role_id = (int)$role_id) {
            $obj = D('Role');
            $obj->delete($role_id);
            $obj->cleanCache();
            $this->simpleSuccess('删除成功！', U('role/index'));
        }
        $this->simpleError('请选择要删除的组');
    }

    private function createCheck()
    {
        $data = $this->checkFields(I('post.data', false), $this->create_fields);
        if (empty($data['role_name'])) {
            $this->simpleError('请输入角色名称');
        }
        $data['role_name'] = htmlspecialchars($data['role_name'], ENT_QUOTES, 'UTF-8');
        return $data;
    }

    private function editCheck()
    {
        $data = $this->checkFields(I('post.data', false), $this->edit_fields);
        if (empty($data['role_name'])) {
            $this->simpleError('请输入角色名称');
        }
        $data['role_name'] = htmlspecialchars($data['role_name'], ENT_QUOTES, 'UTF-8');
        return $data;
    }

}
