<?php
namespace Manage\Model;

use Common\Model\CommonModel;
use Think\Exception;

class DictModel extends CommonModel
{
    protected $tableName = 'system_dict';

    /**
     * 数据验证规则
     * @var array
     */
    protected $_validate = array(
        array('standard_id', 'require', '{%standard_id}'),
        array('dict_sn', 'require', '{%dict_sn}'),
        array('dict_title', 'require', '{%dict_title}'),
        array('dict_name', 'require', '{%dict_name}'),
        array('dict_code', 'require', '{%dict_code%}'),
        array('status', 'require', '{%status}')
    );

    /**
     * 自动完成
     * @var array
     */
    protected $_auto = array(
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function')
    );

    /**
     * 添加/编辑字典
     * @param $data
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool|mixed
     * @throws Exception
     */
    public function saveDict($data)
    {
        // 数据验证
        if (!$this->create($data)) {
            throw new Exception($this->getError());
        }

        // 添加/编辑
        if (empty($data['id'])) {
            $result = $this->add();
            if (empty($result)) {
                throw new Exception(L('add_error', array('name' => '字典')));
            }

            return $result;

        } else {
            $result = $this->save();
            if ($result === false) {
                throw new Exception(L('save_error', array('name' => '字典')));
            }

            return $result;
        }
    }

    /**
     * 获取字典详情
     * @param $id
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return mixed
     */
    public function getDictInfo($id)
    {
        $result = $this->field(true)->where(array('id' => array('eq', $id)))->find();

        return $result;
    }

































}