<?php

    /**
     *
     * @author sunny5156  <137898350@qq.com>
     * @date   2015-8-26
     * @version
     */

    namespace Manage\Model;

    use Common\Model\CommonModel;

    class UserModel extends CommonModel
    {
        protected $pk = 'id';
        protected $tableName = 'manage_user';
        protected $token = 'manage_user';

        public function getAdminByUsername($username)
        {
            $data = $this->find(array('where' => array('account' => $username, 'closed' => 0)));

            return $this->_format($data);
        }

        public function getUserInfo($where,$field = true)
        {
            return $this->where($where)->field($field)->find();

        }

        public function _format($data)
        {
            static $roles;
            if (empty($roles)) $roles = D('Role')->fetchAll();
            if (!empty($data)) $data['role_name'] = $roles[$data['role_id']]['role_name'];

            return $data;
        }

        /**
         * 分页的基本条件和排序方式
         *
         * @author: xiongfei.ma@pactera.com
         *
         * @date  : 2016年12月2日14:47:41
         *
         * @param $map
         * @param $orderBy
         */
        protected function _initSearch($map, $orderBy)
        {
            $this->where = $map;
            $this->order = $orderBy;
        }

        /**
         * 前台数据拼装的查询条件
         *
         * @author: xiongfei.ma@pactera.com
         *
         * @date  : 2016年12月2日14:47:59
         *
         * @param array $params
         */
        protected function _searchPrams(array $params = array())
        {
            if (isset($params['keywords']) && !empty($params['keywords'])) {
                if (is_numeric($params['keywords'])) {
                    $this->where['account'] = array('eq', $params['keywords']);
                } else {
                    $this->where['username'] = array('like', '%' . $params['keywords'] . '%');
                }
            }
        }
    }