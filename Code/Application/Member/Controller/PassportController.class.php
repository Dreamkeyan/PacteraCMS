<?php
namespace Member\Controller;

use EasyWeChat\Foundation\Application;
use Member\Model\MemberModel;
use Think\Controller;
use Think\Exception;
use UCenter\Client\UcApi;

/**
 * Class PassportController
 * @package Member\Controller
 */
class PassportController extends Controller
{

    /**
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function login()
    {
        // 获取请求授权类型及源地址
        $type     = $_REQUEST['type'];
        $sync     = (!isset($_REQUEST['is_sync'])) ? 1 : $_REQUEST['is_sync'];
        $redirect = $_REQUEST['redirect_uri'];

        try {
            if (empty($type) || empty($redirect)) {
                throw new Exception(L('param_error'));
            }

            switch ($type) {
                case 'wxLogin':
                    $this->wxAuthLogin($redirect, $sync);
                    break;
                case 'QQ':
                    exit('success');
                    break;

                default:
                    throw new Exception(L('param_error'));
            }

        } catch (Exception $e) {
            $this->assign('error', $e->getMessage());
            $this->display('Public/error');
        }
    }


    /**
     * 微信公众平台登陆
     *
     * @param     $redirect_uri
     * @param int $sync
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function wxAuthLogin($redirect_uri, $sync = 0)
    {
        try {
            // 获取来源URL
            $redirect_uri = urldecode($redirect_uri);

            if (empty($redirect_uri)) {
                throw new Exception(L('param_error'));
            }

            if (session('?authUserInfo')) {
                redirect($redirect_uri);
            }

            $param = unserialize($this->getParams());

            if (empty($param)) {
                throw new Exception(L('not_found_param'));
            }

            // 初始化微信用户
            $option = $this->analyzeParams($param, $redirect_uri, $sync);
            $app    = new Application($option);

            // 跳转到授权页面
            $app->oauth->redirect()->send();

        } catch (Exception $e) {
            $this->assign('error', $e->getMessage());
            $this->display('Public/error');
        }
    }

    /**
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function wxAuthCallback()
    {
        try {
            // 获取来源URL
            $sync         = $_GET['is_sync'];
            $redirect_uri = urldecode($_GET['redirect_uri']);

            // 用户信息存在直接跳回源
            if (session('?authUserInfo')) {
                redirect($redirect_uri);
            }

            $param = unserialize($this->getParams());

            // 初始化微信用户
            $option = $this->analyzeParams($param, $redirect_uri);
            $app    = new Application($option);

            // 授权信息
            $authInfo = $app->oauth->user()->toArray();
            if (empty($authInfo)) {
                throw new Exception(L('auth_error'));
            }

            // 获取用户基本信息
            $authUserInfo        = $app->user->get($authInfo['id']);
            $authUserInfoToArray = json_decode($authUserInfo, true);
            if (empty($authUserInfoToArray)) {
                throw new Exception(L('auth_user_error'));
            }

            $userInfo                   = $authInfo['original'];
            $userInfo['subscribe']      = $authUserInfoToArray['subscribe'];
            $userInfo['subscribe_time'] = $authUserInfoToArray['subscribe_time'] ?: 0;

            if ($sync == 0) {
                session('authUserInfo', $userInfo);
                redirect($redirect_uri);
            }

            // 记录用户信息
            $memberModel = new MemberModel();
            $result      = json_decode($memberModel->addMemberAuth($userInfo), true);

            if ($result['status'] == 0) {
                throw new Exception($result['msg']);
            }

            session('authUserInfo', $result['data']);
            redirect($redirect_uri);

        } catch (Exception $e) {
            $this->assign('error', $e->getMessage());
            $this->display('Public/error');
        }
    }

    /**
     * 拼装参数
     *
     * @param        $params
     * @param string $redirect_uri
     * @param        $sync
     *
     * @return array
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    private function analyzeParams($params = array(), $redirect_uri = '1', $sync = '')
    {
        $http   = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        $host = $http . $_SERVER['HTTP_HOST'];
        $option = array(
            // 基本配置
            'app_id'  => $params['mp']['app_id'],
            'secret'  => $params['mp']['secret'],
            'token'   => $params['mp']['token'],
            'aes_key' => $params['mp']['aes_key'],

            // 调试模式
            'debug'   => false,

            // 日志
            'log'     => array(
                'level' => 'debug',
                'file'  => RUNTIME_PATH . '/Wechat/' . date('Ymd') . '.log'
            ),

            // Oauth 配置
            'oauth' => array(
                'scopes'   => array('snsapi_userinfo'),
                'callback' => $host . U('wxAuthCallback', array('redirect_uri' => $redirect_uri, 'is_sync' => $sync))
            )


        );

        return $option;
    }

    /**
     * 获取微信配置
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    protected function getParams()
    {
        $wxConfig = M('SystemSetting')->where(array('k' => 'wechat'))->getField('v');

        return $wxConfig ?: false;
    }

    /**
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function test()
    {
        $uc = new UcApi();

        dd($uc->uc_user_register('liangh', '123456'));
    }


}
