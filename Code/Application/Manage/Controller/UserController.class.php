<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;

use Think\Page;
class UserController extends CommonController {

    private $create_fields = array('account', 'username','module','password', 'role_id', 'mobile');
    private $edit_fields = array('role_id', 'mobile');

    public function index() {
        $Admin = D('User');
        $map = array('closed' => 0);
        $order = 'create_time desc';
        $list = $Admin->toPage(I(),$map,$order);
        foreach ($list as $k => $val) {
            $val['create_ip_area'] = $this->ipToArea($val['create_ip']);
            $val['last_ip_area']   = $this->ipToArea($val['last_ip']);
            $list[$k] = $Admin->_format($val);
        }
        $this->assign(array(
            'list' => $list,
            'page' => $Admin->getPage(),
            'data' => I(),
        ));
        $this->display(); // 输出模板
    }

    public function create() {
        if (IS_POST) {
            $data = $this->createCheck();
            $obj = D('User');
            if ($obj->add($data)) {
                $this->simpleSuccess('添加成功', U('user/index'));
            }
            $this->simpleError('操作失败！');
        } else {
            $this->assign('roles', D('Role')->fetchAll());
            $this->display();
        }
    }

    public function add() {
        if (IS_POST) {
            $data = $this->createCheck();
            $obj = D('User');
            if ($adminId = $obj->add($data)) {
                $this->simpleSuccess('添加成功', U('index'));
            }
            $this->simpleError('操作失败！');
        } else {
            $this->assign('roles', D('Role')->fetchAll());
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields(I('post.data', false), $this->create_fields);
        $data['account'] = htmlspecialchars($data['account']);
        if (empty($data['account'])) {
            $this->simpleError('账号不能为空');
        }
        if (empty($data['username'])) {
            $this->simpleError('用户名不能为空');
        }
        if (D('User')->getUserInfo(array('account'=>$data['username'],'closed'=>0))) {
            $this->simpleError('用户名已经存在');
        }
        $data['password'] = htmlspecialchars($data['password']);
        if (empty($data['password'])) {
            $this->simpleError('密码不能为空');
        }
        $data['password'] = md5($data['password']);
        $data['role_id'] = (int) $data['role_id'];
        if (empty($data['role_id'])) {
            $this->simpleError('角色不能为空');
        }
        $data['mobile'] = htmlspecialchars($data['mobile']);

        if (empty($data['mobile'])) {
            $this->simpleError('手机不能为空');
        }
/*        if (!is_mobile($data['mobile'])) {
            $this->simpleError('手机格式不正确');
        }*/
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        return $data;
    }

    public function edit($admin_id = 0) {
        if ($admin_id = (int) $admin_id) {
            $obj = D('User');
            if (!$detail = $obj->find($admin_id)) {
                $this->simpleError('请选择要编辑的管理员');
            }
            if (IS_POST) {
                $data = $this->editCheck();
                unset($data['admin_id']);
                if ($obj->where(array('id'=>$admin_id))->save($data)) {
                    $this->simpleSuccess('操作成功', U('user/index'));
                }else{
                    $this->simpleError('操作失败');
                }

            } else {
                $this->assign('roles', D('Role')->fetchAll());
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->simpleError('请选择要编辑的管理员');
        }
    }

    private function editCheck() {
        $data = $this->checkFields(I('post.data', false), $this->edit_fields);
        if ($this->_admin['role_id'] != 1) { //非超级管理员不允许修改用户的角色信息
            unset($data['role_id']);
        } else {
            $data['role_id'] = (int) $data['role_id'];
            if (empty($data['role_id'])) {
                $this->simpleError('角色不能为空');
            }
        }
        $data['mobile'] = htmlspecialchars($data['mobile']);
        if (empty($data['mobile'])) {
            $this->simpleError('手机不能为空');
        }
        return $data;
    }

    public function delete() {
        $adminId = I("get.admin_id");
        if (!empty($adminId)) {
            $res = D("User")->where(array('id'=>$adminId))->setField(array('closed'=>1));
            if($res !== false){
                $this->simpleSuccess('删除成功！', U('user/index'));
            }else{
                $this->simpleError('删除失败！');
            }
        } else {
            $this->simpleError('用户信息获取失败！');
        }
    }

    /**
     * 重置密码
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日11:48:45
     */
    public function reset($admin_id = 0)
    {
        if ($admin_id = (int) $admin_id) {
            $obj = D('User');
            if (!$detail = $obj->find($admin_id)) {
                $this->simpleError('请选择要编辑的管理员');
            }
            if (IS_POST) {
                $data = $this->editCheck();
                unset($data['admin_id']);
                if ($obj->where(array('id'=>$admin_id))->save($data)) {
                    $this->simpleSuccess('操作成功', U('user/index'));
                }else{
                    $this->simpleError('操作失败');
                }
            } else {
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->simpleError('请选择要编辑的管理员');
        }

    }

    /**
     * 检查密码
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日15:28:07
     */
    public function checkPassword()
    {
        $password = md5(I("post.password"));
        $userId = I("post.userId");
        if(D('User')->getUserInfo(array('id'=>$userId,'password'=>$password,'closed'=>0))){
            echo "true";
        }else{
            echo "false";
        }
    }

    /**
     * 检查账号
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日15:28:07
     */
    public function checkAccount()
    {
        $account = I("post.account");
        if(D('User')->getUserInfo(array('account'=>$account,'closed'=>0))){
            echo "false";
        }else{
            echo "true";
        }
    }
    /**
     * 检查密码
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日15:28:07
     */
    public function checkMobile()
    {
        $account = I("post.mobile");
        if(D('User')->getUserInfo(array('mobile'=>$account,'closed'=>0))){
            echo "false";
        }else{
            echo "true";
        }
    }
    /**
     * 检查用户名
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日15:28:07
     */
    public function checkUsername()
    {
        $username = I("post.username");
        if(D('User')->getUserInfo(array('username'=>$username,'closed'=>0))){
            echo "false";
        }else{
            echo "true";
        }
    }


    public function savePassword()
    {
        $data = I("post.");
        if(md5($data['oldPassword']) === md5($data['newPassword'])){
            $this->simpleError('新密码不能和原密码一致！');
        }
        if(md5($data['newPassword']) !== md5($data['rePassword'])){
            $this->simpleError('两次输入的密码不一致！');
        }
        $res = D("User")->where(array('id'=>$data['userId']))->setField(array('password'=>md5($data['newPassword'])));
        if($res !== false){
            $this->simpleSuccess('密码修改成功！', U('user/index'));
        }else{
            $this->simpleError('密码修改失败！');
        }
    }

}
