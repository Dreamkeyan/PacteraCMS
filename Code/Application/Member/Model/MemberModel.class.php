<?php
namespace Member\Model;

use Org\Util\String;
use Think\Exception;

/**
 * Class MemberModel
 * @package Member\Model
 */
class MemberModel extends MemberBaseModel
{
    protected $tableName = 'member';

    protected $_auto = array(
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function')
    );

    public function __construct()
    {
        parent::__construct();

        // TODO U_center 写入
    }

    /**
     * 添加/更新会员授权信息
     * 主要功能为微信授权时写入用户信息
     *
     * @param array $info 授权用户信息
     *
     * @return string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function addMemberAuth($info)
    {
        try {
            if (empty($info)) {
                throw new Exception(L('member_info_error'));
            }

            $authInfo = $this->isExistsOpenid($info['openid']);

            if (!empty($authInfo)) {
                // 更新会员信息
                $update = array(
                    'avatar'      => $info['headimgurl'],
                    'nickname'    => $info['nickname'],
                    'follow'      => $info['subscribe'],
                    'follow_time' => $info['subscribe_time'],
                    'tag'         => base64_encode(serialize($info)),
                    'oauth_type'  => 'wechat',
                    'update_time' => time(),
                );

                if ($authInfo['member_id'] == 0) {
                    $update['member_id'] = $this->addMember('wechat', $info);
                }

                $result = M('MemberOauth')->where(array('open_id' => $info['openid']))->save($update);

                if ($result === false) {
                    throw new Exception(L('save_error', array('name' => '会员')));
                }
            } else {
                $member_id = $this->addMember('wechat', $info);
                if (empty($member_id)) {
                    throw new Exception(L('add_error', array('name' => '会员')));
                }

                // 添加会员信息
                $addData = array(
                    'open_id'     => $info['openid'],
                    'member_id'   => $member_id,
                    'oauth_type'  => 'wechat',
                    'create_time' => time(),
                    'avatar'      => $info['headimgurl'],
                    'nickname'    => $info['nickname'],
                    'follow'      => $info['subscribe'],
                    'follow_time' => $info['subscribe_time'],
                    'tag'         => base64_encode(serialize($info))
                );

                $result = M('MemberOauth')->add($addData);

                if (!$result) {
                    throw new Exception(L('add_error', array('name' => '会员')));
                }
            }

            $fansInfo = M('MemberOauth')->field(true)->where(array('open_id' => $info['openid']))->find();

            return json_encode(array('status' => 1, 'msg' => L('add_success', array('name' => '粉丝')), 'data' => $fansInfo), JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            return json_encode(array('status' => 0, 'msg' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 帐号登陆
     * @param string $username 用户名
     * @param string $password 密码
     *
     * @return string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function accountLogin($username, $password)
    {
        try {
            if (empty($username) || empty($password)) {
                throw new Exception('用户名或密码不能为空');
            }

            $memberInfo = $this->where(array('username' => $username))->field('id,username,password,salt')->find();
            if (empty($memberInfo)) {
                throw new Exception('用户不存在');
            }

            if ($this->hasPassword($password,$memberInfo['salt']) != $memberInfo['password']) {
                throw new Exception('用户名或密码错误');
            }

            return json_encode(array('status' => 0, 'msg' => '登陆成功','data' => $this->getMemberBaseInfo($memberInfo['id'])),JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            return json_encode(array('status' => 0, 'msg' => $e->getMessage(),'data' => ''),JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 添加会员信息
     * 可供其它模块调用
     *
     * @param string $type 会员类型
     * @param array  $data 会员数据
     *
     * @return int
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function addMember($type = 'wechat', array $data = array())
    {

        $method = 'build' . ucfirst(strtolower($type));

        if (!method_exists($this, $method)) return false;

        $data = $this->$method($data);


        return $this->add($data) ?: false;
    }

    /**
     * 删除会员
     * @param int $id 会员ID
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function deleteMember($id)
    {
        if (empty($id)) return false;

        $result = $this->delete($id);

        return ($result !== false) ? true : false;

    }

    /**
     * 删除授权用户信息
     * @param int $id 会员ID
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function deleteMemberAuth($id)
    {
        if (empty($id)) return false;

        $result = M('MemberOauth')->delete($id);

        return ($result !== false) ? true : false;
    }

    /**
     * 微信数据
     *
     * @param array $data
     *
     * @return array
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function buildWechat($data)
    {
        return $this->buildData($data, 'wechat');
    }

    /**
     * 构造注册数据
     *
     * @param $data
     *
     * @return array
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function buildRegister($data)
    {
        return $this->buildData($data, 'register');
    }

    /**
     * 格式化数据
     *
     * @param $data
     * @param $type
     *
     * @return array
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function buildData($data, $type)
    {
        $data = array_filter($data);

        $number = $this->buildNumber();
        $salt = $this->salt();

        $formatData = array(
            'member_number' => $number,
            'salt'          => $salt,
            'password'      => $this->hasPassword($data['password'] ?: 123456, $salt),
            'sex'           => $data['sex'] ?: 0
        );

        switch ($type) {
            case 'wechat':
                $formatData['email'] = 'wechat_' . $number . '@wechat.com';
                $formatData['username'] = 'wechat' . $number;
                $formatData['name'] = $data['nickname'];
                $formatData['avatar'] = $data['headimgurl'];
                break;
            case 'register':
                $formatData['email'] = $data['email'] ?: '';
                $formatData['username'] = $data['username'] ?: '';
                $formatData['name'] = $data['name'] ?: '';
                $formatData['avatar'] = $data['avatar'] ?: '';
        }

        return $formatData;
    }

    /**
     * 获取会员基础信息
     *
     * @param string $param
     *
     * @return bool|mixed
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function getMemberBaseInfo($param = '')
    {
        if (empty($param)) return false;

        // 查询会员信息
        $map = array();
        if (is_numeric($param)) {
            $map['id'] = array('eq', $param);
        } elseif (is_string($param)) {
            $map['member_number|email|username|phone'] = array('eq', $param);
        }

        $memberInfo = $this->where($map)->field(true)->find();

        if (empty($memberInfo)) return false;

        // 查询授权信息
        $memberInfoByAuth = $this->getMemberAuthInfo($memberInfo['id']);
        if (!empty($memberInfoByAuth)) {
            $memberInfo['authInfo'] = $memberInfoByAuth;
        }

        return $memberInfo;
    }

    public function getMemberList()
    {
        // 获取所有会员信息
        $memberList = $this->field(true)->select();

        // 获取授权用户信息
        $map['member_id'] = array('in', array_column($memberList, 'id'));
        $authMember = M('MemberOauth')->field(true)->where($map)->select();

        // 对授权会员数据分组
        $formatAuthMember = array();
        array_walk($authMember, function (&$value) use (&$formatAuthMember) {
            $value['tag'] = !empty($value['tag']) ? unserialize(base64_decode($value['tag'])) : '';
            $formatAuthMember[$value['member_id']][] = $value;
        });

        // 拼装会员信息
        array_walk($memberList, function (&$value) use ($formatAuthMember) {
            $value['auth'] = !empty($formatAuthMember[$value['id']]) ? $formatAuthMember[$value['id']] : '';
        });

        dd($memberList);

    }

    /**
     * 获取授权用户信息
     *
     * @param string $param
     *
     * @return bool|mixed
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function getMemberAuthInfo($param = '')
    {
        if (empty($param)) return false;

        // 获取用户授权信息
        $map = array();
        $authInfo = array();
        if (is_numeric($param)) {
            $map['member_id'] = array('in', $param);
            $authInfo = M('MemberOauth')->where($map)->field(true)->select();
        } elseif (is_string($param)) {
            $map['open_id'] = array('eq', $param);
            $authInfo = M('MemberOauth')->where($map)->field(true)->find();
        }

        if (empty($authInfo)) return false;

        if (count($authInfo) == count($authInfo, 1)) {
            return $authInfo;
        }

        array_walk($authInfo, function (&$value) {
            $value['tag'] = unserialize(base64_decode($value['tag']));
        });

        return $authInfo;
    }

    /**
     * 更新会员信息
     *
     * @param int   $param
     * @param array $data
     *
     * @return bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function changeMemberInfo($param = 0, array $data)
    {
        if (empty($param)) return false;

        $data = $this->filterMemberFields($data);

        if (empty($data)) return false;

        $map = array();
        if (is_numeric($param)) {
            $map['id'] = array('eq', $param);
        } elseif (is_string($param)) {
            $map['member_number|username|email'] = array('eq', $param);
        }

        $result = $this->where($map)->save($data);

        return ($result !== false) ? true : false;
    }

    /**
     * 过滤字段数据
     *
     * @param array $data
     *
     * @return array|bool
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function filterMemberFields(array $data)
    {
        // 获取会员表所有字段
        $fields = $this->getDbFields();
        if (empty($fields)) return false;

        // 过滤空数据
        $data = array_filter($data);

        // 对 id, member_number 及 username 不允许更新
        $filterSensitiveFields = array_intersect_key($data, array_flip(array('id', 'member_number', 'username')));
        if (!empty($filterSensitiveFields)) return false;

        return array_intersect_key($data, array_flip($fields));
    }

    /**
     *  盐
     * @return string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function salt()
    {
        return String::randString(6, 0);
    }

    /**
     * 生成用户密码
     *
     * @param string $password
     * @param string $salt
     *
     * @return string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function hasPassword($password = '', $salt)
    {
        $password = $password ?: 123456;

        return md5(md5($password) . $salt);
    }

    /**
     * 生成会员编号
     * @return string
     * @author 祝海亮 <liangh.zhu@gmail.com>
     */
    public function buildNumber()
    {
        do {
            $member_number = String::randString(8, 1);
            $isExistsNumber = $this->where(array('member_number' => array('eq', $member_number)))->count('member_number');
        } while ((substr($member_number, 0, 1) == 0) || $isExistsNumber > 0);

        return $member_number;
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

        $fansOpenid = M('MemberOauth')->field(true)->where(array('open_id' => $openid))->find();

        return $fansOpenid;
    }
}
