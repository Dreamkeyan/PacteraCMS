<?php
namespace Manage\Model;

use Common\Model\CommonModel;
use Think\Exception;

/**
 * 标准管理模型
 *
 * @package Manage\Model
 */
class StandardModel extends CommonModel
{
    protected $tableName = 'manage_standard';

    protected $_validate = [
        ['standard_sn', 'require', '{%stand_sn}'],
        ['standard_title', 'require', '{%standard_title}'],
        ['standard_name', '', '{%standard_name}', 0, 'unique', 3]
    ];

    protected $_auto = [
        ['status', 1],
        ['create_time','time',1,'function'],
        ['update_time', 'time', 2, 'function']
    ];

    /**
     * 添加/更新标准
     * @param $data
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return mixed
     * @throws Exception
     */
    public function saveStandard($data)
    {
        // 验证数据
        if (!$this->create($data)) {
            throw new Exception($this->getError());
        }

        // 添加
        if (empty($data['id'])) {

            $result = $this->add();

            if (empty($result)) {
                throw new Exception(L('add_error', array('name' => '标准')));
            }

            return $result;
        } else {
            // 更新
            $result = $this->save();

            if ($result === false) {
                throw new Exception(L('save_error', array('name' => '标准')));
            }

            return true;
        }
    }

    /**
     * 获取标准信息
     * @param int $id
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return mixed
     */
    public function getStandardInfo($id = 0)
    {
        return $this->field(true)->where(array('id' => array('eq', $id)))->find();
    }
}





