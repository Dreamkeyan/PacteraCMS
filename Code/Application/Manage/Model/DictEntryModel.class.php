<?php
namespace Manage\Model;

use Common\Model\CommonModel;
use Think\Exception;

class DictEntryModel extends CommonModel
{
    protected $tableName = 'system_dict_entry';

    /**
     * 数据验证规则
     * @var array
     */
    protected $_validate = array(
        array('dict_id', 'require', '{%dict_id}'),
        array('dict_entry_sn', 'require', '{%dict_entry_sn}'),
        array('dict_entry_name', 'require', '{%dict_entry_name}'),
        array('dice_entry_code', 'require', '{%dice_entry_code}')
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
     * 添加/编辑字典项
     * @param array $data
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool|mixed
     * @throws Exception
     */
    public function addDictEntry(array $data)
    {

        // 数据验证
        if (!$this->create($data)) {
            throw new Exception($this->getError());
        }

        if (empty($data['id'])) {
            $result = $this->add();

            if (!$result) {
                throw new Exception(L('add_error', array('name' => '字典项')));
            }

            return $result;
        } else {

            $result = $this->save();

            if ($result === false) {
                throw new Exception('save_error', array('name' => '字典项'));
            }

            return true;
        }
    }

    /**
     * 获取字典项信息
     * @param int $id
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool|mixed
     */
    public function getDictEntryInfo($id = 0)
    {
        $result = $this->field(true)->where(array('id' => array('eq', $id)))->find();

        return !empty($result) ? $result : false;
    }






















}