<?php
namespace Common\Model;


use Think\Exception;
use Think\Model;

class MemberModel extends Model
{
    protected $tableName = 'member';

    public function __construct()
    {
        parent::__construct();

        if(C('MEMBER.MEMBER_UCENTER')){
            //载入ucenter配置
            include  UC_CLIENT_PATH.'/config.php';
            //载入ucenter client
            include  UC_CLIENT_PATH.'/client.php';
        }

    }


    /**
     * 添加粉丝信息
     * @param array  $fansInfo
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return string
     */
    public function addFans(array $fansInfo)
    {
        try {
            if (empty($fansInfo)) {
                throw new Exception(L('fans_info_not_empty'));
            }

            // 如果存在更新 不存在添加
            if ($this->isExistsOpenid($fansInfo['openid'])) {

                $update = array('update_time' => time());

                if ($fansInfo['subscribe'] == 1) {
                    $update['avatar']      = $fansInfo['headimgurl'];
                    $update['nickname']    = $fansInfo['nickname'];
                    $update['follow']      = 1;
                    $update['follow_time'] = $fansInfo['subscribe_time'];
                    $update['tag']         = base64_encode(serialize($fansInfo));
                    $update['update_time'] = time();
                } else {
                    $update['follow']      = 0;
                    $update['follow_time'] = 0;
                }

                $result = M('MemberOauth')->where(array('open_id' => $fansInfo['openid']))->save($update);

                if ($result === false) {
                    throw new Exception(L('save_error',array('name' => '粉丝')));
                }
            } else {

                $addData = array(
                    'open_id'     => $fansInfo['openid'],
                    'oauth_type'  => 'wechat',
                    'create_time' => time()
                );

                if ($fansInfo['subscribe'] == 1) {
                    $addData['avatar']      = $fansInfo['headimgurl'];
                    $addData['nickname']    = $fansInfo['nickname'];
                    $addData['follow']      = 1;
                    $addData['follow_time'] = $fansInfo['subscribe_time'];
                    $addData['tag']         = base64_encode(serialize($fansInfo));
                }

                $result = M('MemberOauth')->add($addData);

                if (!$result) {
                    throw new Exception(L('add_error',array('name' => '粉丝')));
                }
            }

            $fansInfo = M('MemberOauth')->field(true)->where(array('open_id' => $fansInfo['openid']))->find();

            return  json_encode(array('status' => 1, 'msg' => L('add_success',array('name' => '粉丝')), 'data' => $fansInfo), JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            return json_encode(array('status' => 0, 'msg' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 判断用户 Openid 是否已经注册
     *
     * @param $openid
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool
     */
    public function isExistsOpenid($openid)
    {

        $fansOpenid = M('MemberOauth')->field('open_id')->where(array('open_id' => $openid))->find();

        return !empty($fansOpenid) ? true : false;
    }


}