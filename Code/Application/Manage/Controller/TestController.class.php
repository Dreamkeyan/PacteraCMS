<?php
namespace Manage\Controller;

use Common\Controller\MobileCommonController;
use Member\Model\MemberAddressModel;
use Member\Model\MemberModel;
use Think\Controller;

class TestController extends Controller
{

    public function wxAuth()
    {
        if (session('?authUserInfo')) {
            dd(session('authUserInfo'));
        } else {
            $http = ($_SERVER['HTTPS'] == 'on') ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST'];
            $currentUrl = $http.U('wxAuth');

            $this->redirect($http.U('Member/Passport/login',array('type'=>'wxLogin','redirect_uri' => urlencode($currentUrl))));
        }
    }

    public function demo()
    {
        $result = new MemberAddressModel();
        $model = new MemberModel();
        $model->getMemberBaseInfo(77012494);

        $data = array(
            'member_id' => 71,
            'province_id' => 610000,
            'city_id' => 610100,
            'county_id' => 610113,
            'name' => '祝海亮',
            'phone' => '18161969466',
            'zipcode' => 711711,
            'address' => '测试地址',
        );
//        dd($model->addMember('register',array('username'=>'liangh', 'password'=>123456,'name'=>'祝海亮')));
//        $model->changeMemberInfo(1, array('id'=>1,'username'=>'aaa','phone'=>'18161969466','name'=>false));
//        dd($model->getMemberAuthInfo('oQXGcwLjXMW2emQB5prTy6TCjceQ'));
//        dd($model->accountLogin('Snow.Wang',123456));
    }
}



















