<?php

/**
 * 会员控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.10.27
 * @version  
 * */

namespace Mall\Controller;
use Think\Exception;

class MemberController extends MobileBaseController {

    public function index() {
        $this->display();
    }

    public function wallet() {

        $this->display();
    }
    
    /**
     * 银行卡列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-23
     **/
    public function bankCardList() {
        $this->display();
    }
    
    public function bankCardAdd() {
        if(IS_POST){
            $param = I('post.');
            
            try {
                $data = array(
                    'member_id' => $this->mid,
                    'bank_name' => '建设银行',
                    'card_type_name' => '储蓄卡',
                    'card_no' => $param['no'],
                    'card_name' => $param['name'],
                    'phone' => 0,
                    'is_verify' => 1,
                );
                $res = D('BankCard')->saveData($data);
                
                $this->redirect(U('Member/bankCardList'));
                
            } catch (Exception $e) {
                
            }
        }
        $this->display();
    }
    
    public function bankCardDelete() {
        $id = I('post.id');

        try {
            $data = array(
                'id' => $id,
                'status' => 0
            );
            $res = D('BankCard')->deleteData($data);

            $this->ajaxReturn(array('status'=>1));
        } catch (Exception $e) {
            $this->ajaxReturn(array('status'=>0, 'msg'=>$e->getMessage()));
        }
    }

    public function set() {

        $this->display();
    }
    
    /**
     * 用户收藏列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-23
     **/
    public function collectList() {
        
        $list = D('MemberCollect')->getListValid(array('member_id'=>  $this->mid));
        $this->assign('totalCount', count($list['goods']['valid']));
        $this->assign('invalidCount', count($list['goods']['invalid']));
        $this->assign('data', $list);
        $this->display();
    }
    
    /**
     * 用户收藏
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-12-23
     **/
    public function collect() {
        $param = I('post.');
        $collect_data = array(
            'collect_id' => $param['gid'],
            'status' => $param['s'],
            'member_id' => $this->mid,
            'type' => $param['t'],
        );
        
        try {
            $m = M();
            $m->startTrans();
            
            //用户收藏记录
            $res = D('MemberCollect')->update($collect_data);
            
            //商品收藏数量的操作
            if  ($param['t'] == 1) {
                $operation = ($param['s'] == 1) ? '+' : '-';
                $goods_res = D('Goods')->setCollectNumber($param['gid'], $operation);
            }

            $m->commit();
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
            
        } catch (Exception $e) {
            $m->rollback();
            $this->ajaxReturn(array('status' => 0, 'msg' => "操作失败"));
        }
    }
    
    /**
     * 用户地址列表
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-23
     **/
    public function address() {
        $param = I('get.');
        $list = D("Member/MemberAddress")->getMemberAddressInfo($this->mid);
//        debug($list);
        $this->assign('data', $list);
        $this->assign('param', $param);
        $this->display();
    }
    
    /**
     * 添加/修改用户地址
     * @author liym  <yanming.li1@pactera.com>
     * @date 2016-10-23
     **/
    public function addressUpdate() {
        $param_get = I('get.');

        $id = $param_get['id'];
        $detail = D('Member/MemberAddress')->getAddressInfo($id);
//        debug($detail);
        if (IS_POST) {
            $param = I('post.');

            try {
                //地址解析
                $area_list = explode(' ', trim($param['area']));
                $province = get_province($area_list[0], 'province_id');
                $city = get_city($area_list[1], 'city_id');
                $county = get_county($area_list[2], 'county_id');
                if(empty($province) || empty($city) || empty($county)){
                    throw new Exception('城市信息出错');
                }
                $data = array(
                    'member_id' => $this->mid,
                    'name' => $param['name'],
                    'phone' => $param['phone'],
                    'county_id' => $county,
                    'city_id' => $city,
                    'province_id' => $province,
                    'address' => $param['address'],
                    'zipcode' => $county,
                    'status' => 1,
                    'update_time' => NOW_TIME
                );
                
                $m = M();
                $m->startTrans();
                if(empty($param['id'])){
                    $res = D('Member/MemberAddress')->addMemberAddress($data);
                    $res = json_decode($res, true);
                    if($res['status'] == 0){
                        throw new Exception('地址添加失败');
                    }
                    $addr_id = $res['data'];
                }else{
                    $res = D('Member/MemberAddress')->editMemberAddress($param['id'], $data);
                    if(!$res){
                        throw new Exception('地址修改失败');
                    }
                    $addr_id = $param['id'];
                }
                
                
                //默认地址操作
                if($this->member['extend']['default_addr_id'] == $addr_id || !empty($param['is_default'])){
                    
                    $data_extend = array(
                        'default_addr_id' => (isset($param['is_default'])&&$param['is_default']) ?  $addr_id: 0,
                        'member_id' => $this->mid
                    );

                    $res_extend = D('MemberExtend')->defaultAddr($data_extend);

                }
                
                $m->commit();
                session('member_'.$this->fansinfo['openid'], Null);
                $this->redirect(U('Member/address', array('from' => $param_get['from'])));
                
            } catch (Exception $e) {
                $m->rollback();
            }
            
        } else {
            $this->assign('param', $param_get);
            $this->assign('detail', $detail);
            $this->display();
        }
    }
    
    public function addressDefault() {
        $address_id = I('post.id');
        $data_extend = array(
            'default_addr_id' => $address_id,
            'member_id' => $this->mid
        );
        try {
            $res = D('MemberExtend')->defaultAddr($data_extend);
            session('member_'.$this->fansinfo['openid'], Null);
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
        } catch (Exception $e) {
            $this->ajaxReturn(array('status' => 0, 'msg' => $e->getmessage()));
        }
        
    }
    
    public function addressDelete() {
        $address_id = I('post.id');

        if(D('Member/MemberAddress')->deleteAddress($address_id)){
            $this->ajaxReturn(array('status' => 1, 'msg' => "操作成功"));
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => "操作失败"));
    }
    
    public function memberInfo() {

        if(IS_POST){
            $param = I('post.');
            
            try {
                
                $member_data = array(
                    'name'=>isset($param['nickname'])?$param['nickname']:'',
                    'sex' => isset($param['sex'])?$param['sex']:0
                );
                $res = D('Member/Member')->changeMemberInfo($this->mid, $member_data);
                
                session('member_'.$this->fansinfo['openid'], NULL);
                
                $url = U('Member/index');
                $this->redirect($url);
                
            } catch (Exception $e) {
            }
        }

        $this->display();
    }
    
    public function memberPhone() {
        $id = $this->mid;
        $referer = I('get.referer');

        if(IS_POST){
            $param = I('post.');
            if ($_POST['sms_code'] != $_SESSION['sms_code']) {
                $this->error('验证码不匹配');
            }
            if ($_SESSION['sms_mobile_code'] !== $_POST['mobile_code']) {
                $this->error('手机验证码错误');
            }
            
            $member_data = array(
                'phone' =>$param['mobile'],
            );

            $res = D('Member/Member')->changeMemberInfo($id, $member_data);;

            if ($res) {
                session('member_'.$this->fansinfo['openid'], NULL);
                
                $url = $referer?$referer:U('Member/index');

                $this->redirect($url);
            }
        }else{
            $this->assign('referer', $referer);
            $this->assign('enabled_sms_signin', 123);
            // 随机code
            $_SESSION['sms_code'] = $sms_code = md5(mt_rand(1000, 9999));
            $this->assign('sms_code', $sms_code);
            $this->display();
        }
    }
    
    public function bankPassword() {
        $type = empty($this->member['extend']['pay_password']) ? 1 : 0;
        
        if(IS_POST){
            $param = I('post.');
            if ($_POST['sms_code'] != $_SESSION['sms_code']) {
                $this->error('验证码不匹配');
            }
            if ($_SESSION['sms_mobile_code'] !== $_POST['mobile_code']) {
                $this->error('手机验证码错误');
            }
            
            if($param['confirm_password'] != $param['new_password']){
                $this->error('确认密码错误');
            }
            
            if(isset($param['old_password'])){
                if(md5($param['old_password'].$this->member['salt']) != $this->member['extend']['pay_password']){
                    $this->error('原密码错误');
                }
                
                if($this->member['extend']['pay_password'] == md5($param['new_password'].$this->member['salt'])){
                    $this->error('新密码和原密码相同');
                }
            }
            
            try {
                $member_data = array(
                    'member_id' => $this->mid,
                    'pay_password' =>md5($param['new_password'].$this->member['salt']),
                );
                $res = D('MemberExtend')->update($member_data);

                session('member_'.$this->fansinfo['openid'], NULL);
                
                $this->redirect(U('Member/index'));
            } catch (Exception $e) {
                debug($e->getMessage());
                $this->error('支付密码修改失败');
            }

        }else{
            
            $this->assign('type', $type);
            $this->assign('enabled_sms_signin', 123);
            // 随机code
            $_SESSION['sms_code'] = $sms_code = md5(mt_rand(1000, 9999));
            $this->assign('sms_code', $sms_code);
            $this->display();
        }
    }
}
