<?php
/**
 * 钩子
 * @author Kevin_ren <330202207@qq.com>
 * @date 2016/8/22
 * @version 1.0
 */
 

namespace Manage\Model;

use Common\Model\CommonModel;

class SystemHooksModel extends CommonModel
{

    protected $pk        =  'id';
    protected $tableName =  'system_hooks';
    protected $token     =  'system_hooks';
    protected $orderby   =  array('create_time' => 'DESC');

    protected $_validate = array(
        array('name', 'require', '请填写钩子名称！'),
    );

    /**
     * 更新插件里的所有钩子对应的插件
     */
    public function updateHooks($addonsName)
    {
        //获取插件名
        $addonsClass = get_addon_class($addonsName);

        if (!class_exists($addonsClass)) {
            return false;
        }

        //返回类中所有方法名
        $methods = get_class_methods($addonsClass);
        $hooks = $this->getField('name', true);

        //返回当前插件关联钩子与所有钩子的交集
        $common = array_intersect($hooks, $methods);

        if (!empty($common)) {
            foreach ($common as $hook) {
                $flag = $this->updateAddons($hook, array($addonsName));
                if (false === $flag) {
                    $this->removeHooks($addonsName);
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * 更新单个钩子处的插件
     */
    public function updateAddons($hook_name, $addonsName)
    {
        $o_addons = $this->where("name='{$hook_name}'")->getField('addons');
        if($o_addons) {
            $o_addons = str2arr($o_addons);
        }
        if ($o_addons) {
            $addons = array_merge($o_addons, $addonsName);
            $addons = array_unique($addons);
        } else {
            $addons = $addonsName;
        }

        $flag = D('SystemHooks')->where("name='{$hook_name}'")
            ->setField('addons', arr2str($addons));
        if (false === $flag) {
            D('SystemHooks')->where("name='{$hook_name}'")->setField('addons', arr2str($o_addons));
        }
        return $flag;
    }

    /**
     * 去除插件所有钩子里对应的插件数据
     */
    public function removeHooks($addonsName)
    {
        $addons_class = get_addon_class($addonsName);
        if (!class_exists($addons_class)) {
            return false;
        }
        $methods = get_class_methods($addons_class);
        $hooks   = $this->getField('name', true);
        $common  = array_intersect($hooks, $methods);

        if ($common) {
            foreach ($common as $hook) {
                $flag = $this->removeAddons($hook, array($addonsName));
                if (false === $flag) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 去除单个钩子里对应的插件数据
     */
    public function removeAddons($hookName, $addonsName)
    {
        $o_addons = $this->where("name='{$hookName}'")->getField('addons');
        $o_addons = str2arr($o_addons);

        if ($o_addons) {
            $addons = array_diff($o_addons, $addonsName);
        } else {
            return true;
        }

        $flag = D('SystemHooks')->where("name='{$hookName}'")
            ->setField('addons', arr2str($addons));

        if (false === $flag) {
            D('SystemHooks')->where("name='{$hookName}'")
                ->setField('addons', arr2str($o_addons));
        }
        return $flag;
    }

    /**
     * 获取钩子
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function getHooks($map, $fields, $order)
    {
        $pk     = $this->pk;
        $order  = empty($order) ? $this->$orderby : $order;
        $fields = empty($fields) ? true :$fields;
        $data   = $this->where($map)->field($fields)->order($order)->select();
        return $this->deliveryData($data);
    }

    /**
     * 过滤数据
     * @author Kevin_ren  <330202207@qq.com>
     */
    protected function deliveryData($data)
    {
        return empty($data) ? false : $data;
    }

     /**
      * 添加/编辑
      * @author Kevin_ren  <330202207@qq.com>
      */
    public function saveData()
    {
        $data = I('post.', false);
        if ($this->create()) {
            if ($data['id']) {
                $data['update_time']  = NOW_TIME;
                $result = $this->save($data);
            } else {
                $data['create_time']  = NOW_TIME;
                $result = $this->add($data);
            }
            if ($result || $result !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
} 