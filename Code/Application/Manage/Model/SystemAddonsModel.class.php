<?php
/**
 *
 * @author Kevin_ren <330202207@qq.com>
 * @date 2016/10/24
 * @version 1.0
 */
 

namespace Manage\Model;

use Common\Model\CommonModel;
use Think\Model;

class SystemAddonsModel extends CommonModel
{

    protected $pk   = 'id';
    protected $tableName =  'system_addons';
    protected $token = 'system_addons';
    protected $settings = null;

    /**
     * 获取插件列表
     */
    public function getlist()
    {
        $addonDir = C('ADDONS_PATH');
        //返回Addons目录下所有文件
        $dirs = array_map('basename', glob($addonDir.'*', GLOB_ONLYDIR));

        if ($dirs === false || !file_exists($addonDir)) {
            return false;
        }

        $addons			=	array();
        $where['name']	=	array('in', $dirs);
        $list			=	$this->where($where)->select();

        foreach ($list as $value) {
            $value['uninstall']		=	0;
            $addons[$value['name']]	=	$value;
        }

        foreach ($dirs as $value) {

            if (!isset($addons[$value])) {
                $class = get_addon_class($value);

                //实例化插件失败忽略执行
                if (!class_exists($class)) {
                    \Think\Log::record('插件'.$value.'的入口文件不存在！');
                    continue;
                }

                $obj = new $class();
                $addons[$value]	= $obj->info;

                if ($addons[$value]) {
                    $addons[$value]['uninstall'] = 1;
                    unset($addons[$value]['status']);
                }
            }
        }
        $addons = conversion_data($addons, array('status' => array('0' => '禁用', '1' => '启用', 'null' => '未安装')));

        $addons = list_sort_by($addons, 'uninstall', 'desc');

        return $addons;
    }

} 