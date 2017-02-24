<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;

class SettingController extends CommonController {

    /**
     * 站点信息
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:21:08
     * @version
     */
    public function site() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            $insert_data = array(
                'k' => 'site',
                'v' => $data
            );
            $model = D('Setting');
            if(false !== $model->save($insert_data)){
                D('Manage/Clean')->cleanCache();
                $this->simpleSuccess('设置成功', U('setting/site'));
            }
            $this->simpleSuccess('设置失败');
        } else {
            $this->display();
        }
    }

    /**
     * 附件信息
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:21:17
     * @version
     */
    public function attachs() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            $insert_data = array(
                'k' => 'attachs',
                'v' => $data
            );
            $model = D('Setting');
            if(false !== $model->save($insert_data)){
                D('Manage/Clean')->cleanCache();
                $this->simpleSuccess('设置成功', U('setting/attachs'));
            }
        } else {
            $this->display();
        }
    }

    /**
     * ucenter设置
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:21:26
     * @version
     */
    public function ucenter() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'ucenter', 'v' => $data));
            D('Setting')->cleanCache();//S方法缓存
            D('Manage/Clean')->cleanCache();//Runtime 缓存
            $this->simpleSuccess('设置成功', U('setting/ucenter'));
        } else {
            $this->display();
        }
    }

    /**
     * 短信设置
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:21:36
     * @version
     */
    public function sms() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            $insert_data = array(
                'k' => 'sms',
                'v' => $data
            );
            $model = D('Setting');
            if(false !== $model->save($insert_data)){
                $this->simpleSuccess('设置成功', U('setting/sms'));
            }
        } else {
            $this->display();
        }
    }

    /**
     * 微信设置
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:21:49
     * @version
     */
    public function wechat() {

        if (IS_POST) {
            $data = I('post.', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'wechat', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/wechat'));
        } else {

            $this->display();
        }
    }

    public function weixinmenu() {
        if (IS_POST) {
            $data = I('post.data', false);

            D('Weixin')->weixinmenu($data);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'weixinmenu', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/weixinmenu'));
        } else {

            $this->display();
        }
    }

    public function connect() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'connect', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/connect'));
        } else {
            $this->display();
        }
    }

    public function integral() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'integral', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/integral'));
        } else {
            $this->display();
        }
    }

    public function prestige() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'prestige', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/prestige'));
        } else {
            $this->display();
        }
    }

    public function mail() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            $insert_data = array(
                'k' => 'mail',
                'v' => $data
            );
            $model = D('Setting');
            if(false !== $model->save($insert_data)){
                $this->simpleSuccess('设置成功', U('setting/mail'));
            }
        } else {
            $this->display();
        }
    }

    public function shop() {

        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'shop', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/shop'));
        } else {
            $this->display();
        }
    }

    public function mobile() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'mobile', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/mobile'));
        } else {
            $this->display();
        }
    }

    public function index() {
        if (IS_POST) {
            $data = I('post.data', false);
            $data = serialize($data);
            D('Setting')->save(array('k' => 'index', 'v' => $data));
            D('Setting')->cleanCache();
            $this->simpleSuccess('设置成功', U('setting/index'));
        } else {
            $this->assign('cates', D('Shopcate')->fetchAll());
            $this->display();
        }
    }

}
