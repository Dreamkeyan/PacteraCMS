<?php
namespace Mall\Controller;

use Common\Controller\MobileCommonController;
use Think\Exception;

class MobileBaseController extends MobileCommonController
{
    protected $mid = 0;
    protected $member = array();
    protected $fansinfo = array();

    public function __construct()
    {
        header('Content-Type: text/html; charset=utf-8');
        parent::__construct();
        $a = Array(
            'subscribe' => 1,
            'openid' => 'oQXGcwLjXMW2emQB5prTy6TCjceQ',
            'nickname' => '李彦明',
            'sex' => 2,
            'language' => 'zh_CN',
            'city' => '朝阳',
            'province' => '北京',
            'country' => '中国',
            'headimgurl' => 'http://wx.qlogo.cn/mmopen/fFgUJknhibCzh7dXwnyvBEn6wVBHEblBKiciazCUtWOYlOTx1CHwLfPMWKvBRPIfGHvL2z7ktVeVPxH6BpibpMCvE3OqN4ho41ql/0',
            'subscribe_time' => 1468218221,
            'unionid' => 'ozj8HwT665SFsxUivHhQJ5ySRlrw',
            'remark' => '',
            'groupid' => 0,
            'tagid_list' => array(),
        );

        session('fansInfo', $a);
        
        if(session('fansInfo')){
            $this->fansinfo = session('fansInfo');
            
            if(!session('?member_'.$this->fansinfo['openid'])){
                //用户信息初始化
                $this->initMember();
            }
            $this->member = session('member_'.$this->fansinfo['openid']);
            if($this->mid == 0){
                $this->mid = $this->member['id'];
            }
        }else{
            header("Location: " . U('Member/Passport/login', array('type'=>'wxLogin','redirect_uri' => $_SERVER["HTTP_REFERER"])));
        }
        
        $behavior = $this->setBehavior();
        
        //限制
        //controller名称
        $controller = strtolower(CONTROLLER_NAME);
        //action名称
        $action = strtolower(ACTION_NAME);
        if ($controller == 'order' && $action='saveorder') {
            if (!$this->member['phone']) {
                header("Location: " . U('Member/memberPhone', array('referer' => $_SERVER["HTTP_REFERER"])));
                exit();
            }
        }

        $this->assign('fansinfo', $this->fansinfo);
        $this->assign('member', $this->member);
        $this->assign('mid', $this->mid);
        $this->assign('behavior', $behavior);
    }
    
    private function initMember(){
        
            try {
                
                $faninfo = D('Member/Member')->getMemberAuthInfo($this->fansinfo['openid']);
                
                if(!empty($faninfo['member_id'])){
                    $this->mid = $faninfo['member_id'];
                }
            
                //会员详情
                $member = D('Member/Member')->getMemberBaseInfo($this->mid);
                
                //会员扩展信息
                $extend = D('MemberExtend')->getInfoByMember($this->mid);
                
                if(empty($extend)){

                    $data = array(
                        'member_id' => $this->mid
                    );

                    $res_extend = D('MemberExtend')->update($data);

                    if(!$res_extend){
                        throw new Exception('操作失败');
                    }
                    
                    //会员扩展信息详情
                    $extend = D('MemberExtend')->getInfoByMember($this->mid);
                }

                $member['extend'] = $extend;

                session('member_'.$this->fansinfo['openid'], $member);
                
            } catch (Exception $e) {
                session('member_'.$this->fansinfo['openid'], Null);
            }
    }
    
    protected function setBehavior() {
        
        $data = array(
            'member_id' => $this->mid,
            'member_data' => json_encode($this->member),
            'create_time' => NOW_TIME,
            'model' => strtolower(MODEL_NAME),
            'controller' => strtolower(CONTROLLER_NAME),
            'action' => strtolower(ACTION_NAME),
            'ip' => get_client_ip(),
            'current_url' => get_current_url(),
            'origin_url'=> $_SERVER['HTTP_REFERER'],
            'client_type'=>$_SERVER['HTTP_USER_AGENT'],
            'keyword' => I('get.key'),
            'operate_data'=> json_encode(I('request.')),
            'operate_type' => REQUEST_METHOD,
            'domain' => $_SERVER['HTTP_HOST']
        );
        return base64_encode(json_encode($data));
    }
    
}