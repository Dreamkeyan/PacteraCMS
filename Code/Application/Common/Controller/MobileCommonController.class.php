<?php
namespace Common\Controller;

use EasyWeChat\Foundation\Application;
use Think\Controller;
use Think\Model;

class MobileCommonController extends Controller
{
    /**
     * 微信配置文件
     * @var array
     */
    protected  $option = array();

    /**
     * 应用实例
     * @var  \EasyWeChat\Foundation\Application
     */
    protected $app;


    public function __construct()
    {
        parent::__construct();

        // 获取微信配置
        $this->option = $this->analyzeParams();

        // 实例化应用
        $this->app = new Application($this->option);

        // 判断是否微信登陆
        if (is_weixin()) {

            // 判断微信用户信息是否存在
            if (!session('?fansInfo')) {

                if (!isset($_GET['code'])) {
                    $this->app->oauth->redirect()->send();
                } else {
                    // 授权用户信息
                    $oauth = $this->app->oauth->user()->toArray();

                    // 获取用户基本信息
                    $fansInfo = $this->app->user->get($oauth['id']);
                    $fansInfo = json_decode($fansInfo, true);

                    // 添加粉丝信息
                    $model = new \Common\Model\MemberModel();
                    $model->addFans($fansInfo);

                    session('fansInfo', $fansInfo);
                }

            }

            // 获取 JsSDK 配置
            $this->assign('jsSDK', $this->getJsConfig());
        }
    }

    /**
     * 解析参数
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return mixed
     */
    public function analyzeParams()
    {
        // 是否存在授权作用域
        $scope = I('get.scope');

        // 获取配置文件
        $option = (MODULE_NAME == 'Procurement') ? C('PRO_WECHAT') : C('WECHAT');

        if (!empty($scope)) {
            $option['oauth']['scopes'] = array($scope);
        }

        return $option;
    }

    /**
     * 获取 jsSDK 签名
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return array|string
     */
    public function getJsConfig()
    {
        $api = array(
            'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo',
            'onMenuShareQZone', 'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice',
            'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'downloadVoice', 'chooseImage',
            'previewImage', 'uploadImage', 'downloadImage', 'translateVoice', 'getNetworkType',
            'openLocation', 'getLocation', 'hideOptionMenu', 'showOptionMenu', 'hideMenuItems',
            'showMenuItems', 'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem', 'closeWindow',
            'scanQRCode', 'chooseWXPay', 'openProductSpecificView', 'addCard', 'chooseCard', 'openCard'
        );

        return $this->app->js->config($api,true);
    }

}