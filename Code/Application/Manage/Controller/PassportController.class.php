<?php

namespace Manage\Controller;
use Manage\Model\PassportModel;

/**
 * 会员
 *
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016-10-13  15:37:42
 */
class PassportController extends CommonController
{
    private $model;
    protected $field = 'id, email, username, regist_ip, regist_time';
    
    public function __construct()
    {
        parent::__construct();
        
//        $this->model = new \Member\Model\PassportModel();
        $this->model = new PassportModel();
    }
    
    /**
     * 会员列表
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 2016.10.18
     */
    public function index()
    {
        parent::index(null, $this->model);
    }
    
    /**
     * 编辑会员信息
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 2016.10.19
     */
    public function edit($id)
    {
        $this->username = $this->model->getFieldById($id, 'username');
        $this->display();
    }
    
    /**
     * 登陆指定会员
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 2016.10.19
     */
    public function login($id)
    {
        $memberInfo = $this->find($id);
        if($this->model->_setUserLogin($memberInfo)){
            //跳转Member
            $this->redirect(U('Member/Index/index'));
        }
    }
    
    /**
     * 修改个人资料
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.10.19
     */
    public function update()
    {
        if(IS_POST){ 
            $passport_model = $this->model;
            if($passport_model->update(I('post.id'), 2)){
				$this->success('修改成功！',U('index'));
			} else {
				$this->error($passport_model->getError() ?: '未知错误');
			}

		} else { 
			$this->display('edit');
		}
    }

    /**
     * 修改密码
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日16:30:12
     */

    public function updatePassword($admin_id = 0)
    {
        if(empty($admin_id) && empty(session("admin.id"))){
            session("admin",null);
            $this->redirect("Manage/Login/index");
        }
        $admin_id = I("get.admin_id",session("admin.id"));
        if ($admin_id = (int) $admin_id) {
            $obj = D('User');
            if (!$detail = $obj->find($admin_id)) {
                $this->simpleError('请选择要编辑的管理员');
            }
            if (IS_POST) {
                $data = $this->editCheck();
                unset($data['admin_id']);
                if ($obj->where(array('id'=>$admin_id))->save($data)) {
                    $this->simpleSuccess('操作成功', U('Manage/Index/main'));
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
     * 重置密码
     *
     * @author xiongfei.ma@pactera.com
     * @date 2017年1月10日11:48:45
     */
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
            $this->simpleSuccess('密码修改成功！', U('Manage/Index/main'));
        }else{
            $this->simpleError('密码修改失败！');
        }
    }
    
}
