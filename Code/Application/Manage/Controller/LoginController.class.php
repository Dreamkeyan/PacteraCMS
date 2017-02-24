<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;

use Common\Controller\ManageCommonController;

class LoginController extends ManageCommonController {

    public function index() {
        $this->display();
    }

    public function loging() {
        $yzm = I('post.verify');
        if (!check_verify($yzm)) {
            session('verify',null);
            $this->Error('验证码不正确!',U('Manage/Login/index'));
        }
        $username = I('post.account', '', 'trim');
        $password = I('post.password', '', 'trim,md5');
        $adminObj = D('User');
        $admin = $adminObj->getAdminByUsername($username);
        if (empty($admin) || $admin['password'] != $password) {
            session('verify', null);
            $this->error('用户名或密码不正确!');
        }
        if ($admin['closed'] == 1) {
            session('verify', null);
            $this->error('该账户已经被禁用!');
        }
        $admin['last_time'] = NOW_TIME;
        $admin['last_ip'] = get_client_ip();
        $adminObj->where("id=%d", $admin['id'])->save(array('last_time' => $admin['last_time'], 'last_login_ip' => $admin['last_ip']));
        session('admin', $admin);
        redirect(U('index/index'));
    }

    public function logout() {
        session(null);
        $this->success('退出成功', U('login/index'));
    }

    public function verify() {
        $config = array();
        $config = C('VERIFY');
        $verify = new \Think\Verify($config);
        $verify->codeSet = '0123456789';
        $verify->entry(1);
    }

}
