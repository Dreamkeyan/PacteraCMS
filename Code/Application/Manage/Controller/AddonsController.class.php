<?php
/**
 * 插件管理
 * @author Kevin_ren <330202207@qq.com>
 * @date 2016/10/24
 * @version 1.0
 */
namespace Manage\Controller;

use Think\Page;

class AddonsController extends CommonController
{
    /**
     * 插件列表
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function index()
    {
        $list = D("SystemAddons")->getlist();

        if ($list === false) {
            $this->simpleError("插件目录不可读或者不存在");
        }

        //分页参数
        $request = (array)I('request.');

        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new Page(count($list), 15, $request);

        $show = $Page->show();

        $this->assign('list', $list);
        $this->assign('page', $show);

        $this->display();
    }

    /**
     * 检查创建插件属性
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function checkForm()
    {
        $data = $_POST;
        $data['data']['name'] = trim($data['data']['name']);
        if (!$data['data']['name']) {
            $this->simpleError('插件标识必须填写');
        }

        //检测插件名是否合法
        $addons_dir = C('ADDONS_PATH');
        if (file_exists("{$addons_dir}{$data['data']['name']}")) {
            $this->simpleError('插件已经存在了');
        }
        return $data;
    }

    /**
     * 添加插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function add()
    {
        if (!(is_writable(C('ADDONS_PATH')))) {
            $this->simpleError('您没有创建目录写入权限，无法使用此功能');
        }
        $hooks = M('SystemHooks')->field('name,description')->select();
        $this->assign('hooks', $hooks);
        $this->display();
    }

    /**
     * 插件文件
     */
    public function createFile()
    {
        $data = $_POST;
        $data['data']['status'] = (int)$data['data']['status'];
        $hook = '';
        foreach ($data['hook'] as $value) {
            $hook .= <<<EOT

    /**
     * {$value}钩子方法
     */
    public function {$value}(\$param)
    {

    }
EOT;

        }
        $tpl = <<<EOT
<?php

/**
 * {$data['data']['title']}插件
 */

namespace Addons\\{$data['data']['name']};

use Common\Controller\Addon;

class {$data['data']['name']}Addon extends Addon
{

    public \$info = array(
        'name'        => '{$data['data']['name']}',
        'status'      => {$data['data']['status']},
        'author'      => '{$data['data']['author']}',
        'version'     => '{$data['data']['version']}',
        'description' => '{$data['data']['description']}'
    );

    /**
    * 安装插件
    */
    public function install()
    {
        return true;
    }

    /**
    * 卸载插件
    */
    public function uninstall()
    {
        return true;
    }

    {$hook}
}
EOT;
        return $tpl;
    }

    /**
     * 创建插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function build()
    {
        $data      = $this->checkForm();
        $addonFile = $this->createFile();
        $addonsDir = C('ADDONS_PATH');

        $files      = array();
        $addonsDir  = "$addonsDir{$data['data']['name']}/";
        $files[]    = $addonsDir;
        $addonsName = "{$data['data']['name']}Addon.class.php";
        $files[]    = "{$addonsDir}{$addonsName}";

        //配置文件
        if ($data['has_config'] == 1) {
            $files[] = $addonsDir.'config.php';
        }

        //
        if ($data['has_outurl'] == 1) {
            $files[] = $addonsDir."Controller/";
            $files[] = $addonsDir."Controller/{$data['data']['name']}Controller.class.php";
            $files[] = $addonsDir."Model/";
            $files[] = $addonsDir."Model/{$data['data']['name']}Model.class.php";
        }

        //创建目录文件
        create_dir_or_files($files);

        //将内容写入对应文件
        file_put_contents("{$addonsDir}{$addonsName}", $addonFile);

        if ($data['has_outurl'] == 1) {
            $addonController = <<<NOT
<?php
/**
 * {$data['data']['name']}控制器
 */

namespace Addons\\{$data['data']['name']}\Controller;

use Home\Controller\AddonsController;

class {$data['data']['name']}Controller extends AddonsController
{

}

NOT;
            file_put_contents("{$addonsDir}Controller/{$data['data']['name']}Controller.class.php", $addonController);
            $addonModel = <<<NOT
<?php
/**
 * {$data['data']['name']}模型
 */

namespace Addons\\{$data['data']['name']}\Model;

use Think\Model;

class {$data['data']['name']}Model extends Model
{

}
NOT;
            file_put_contents("{$addonsDir}Model/{$data['data']['name']}Model.class.php", $addonModel);
        }

        if ($data['has_config'] == 1) {
            file_put_contents("{$addonsDir}config.php", $data['config']);
        }
        $this->simpleSuccess("创建成功", U("index"));
    }

    /**
     * 安装插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function install()
    {
        $addonName =   trim(I('name'));
        $class     =   get_addon_class($addonName);

        //检测类是否存在
        if (!class_exists($class)) {
            $this->simpleError('插件不存在');
        }

        $addons = new $class;
        $info   = $addons->info;

        //检测信息的正确性
        if (!$info || !$addons->checkInfo()) {
            $this->simpleError('插件信息缺失');
        }

        $installFlag = $addons->install();
        if (!$installFlag) {
            $this->simpleError('执行插件预安装操作失败');
        }

        $addonsModel = D('SystemAddons');

        $data        = $addonsModel->create($info);

        if (!$data) {
            $this->simpleError($addonsModel->getError());
        }

        //添加addons表
        if ($addonsModel->add($data)) {
            $config = array('config' => json_encode($addons->getConfig()));

            $addonsModel->where(array('name' => $addonName))->save($config);

            //更新hooks表
            $hooks_update = D('SystemHooks')->updateHooks($addonName);
            if ($hooks_update) {
                $this->simpleSuccess('安装成功', U('index'));
            } else {
                $addonsModel->where(array('name' => $addonName))->delete();
                $this->simpleError('更新钩子处插件失败,请卸载后尝试重新安装');
            }

        } else {
            $this->simpleError("安装失败");
        }
        $this->display();
    }

    /**
     * 设置插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function config()
    {
        $id = (int)I('id');
        $addon = M('SystemAddons')->find($id);

        if (!$addon) {
            $this->simpleError('插件未安装');
        }

        $addonClass = get_addon_class($addon['name']);
        if (!class_exists($addonClass)) {
            $this->simpleError("插件{$addon['name']}无法实例化");
        }

        $data                   = new $addonClass;
        $addon['addon_path']    = $data->addon_path;
        $addon['custom_config'] = $data->custom_config;
        $db_config              = $addon['config'];
        $addon['config']        = include $data->config_file;

        if ($db_config) {
            $db_config = json_decode($db_config, true);

            foreach ($addon['config'] as $key => $value) {

                if ($value['type'] != 'group') {
                    $addon['config'][$key]['value'] = $db_config[$key];
                } else {

                    foreach ($value['options'] as $gourp => $options) {
                        foreach ($options['options'] as $gkey => $value) {
                            $addon['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
                        }
                    }
                }
            }
        }
        if ($addon['custom_config']) {
            $this->assign('custom_config', $this->fetch($addon['addon_path'].$addon['custom_config']));
        }

        $this->assign('data', $addon);
        $this->display();
    }

    /**
     * 保存设置插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function Saveconfig()
    {
        $id     = (int)I('id');
        $config = I('config');
        $flag   = M('SystemAddons')->where("id={$id}")->setField('config', json_encode($config));

        if ($flag !== false) {
            $this->simpleSuccess('保存成功', U("index"));
        } else {
            $this->simpleError('保存失败');
        }
    }

    /**
     * 启用插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function enable()
    {
        $id    = I('id');
        $data  = array('status' => 1);
        $msg   = array('success' => '启用成功', 'error' => '启用失败');
        $this->editRow('SystemAddons', $id, $data, $msg);
    }

    /**
     * 禁用插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function disable()
    {
        $id    = I('id');
        $data  = array('status' => 0);
        $msg   = array('success' => '禁用成功', 'error' => '禁用失败');
        $this->editRow('SystemAddons', $id, $data, $msg);
    }

    /**
     * 卸载插件
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function uninstall()
    {
        $addonsModel = M('SystemAddons');
        $id          = trim(I('id'));
        $db_addons   = $addonsModel->find($id);
        $class       = get_addon_class($db_addons['name']);

        if (!$db_addons || !class_exists($class)) {
            $this->simpleError('插件不存在');
        }

        $addons = new $class;
        $uninstall_flag = $addons->uninstall();

        if (!$uninstall_flag) {
            $this->simpleError('执行插件预卸载操作失败');
        }

        $hooks_update = D('SystemHooks')->removeHooks($db_addons['name']);
        if ($hooks_update === false) {
            $this->simpleError('卸载插件所挂载的钩子数据失败');
        }
        $delete = $addonsModel->where("name='{$db_addons['name']}'")->delete();
        if ($delete === false) {
            $this->simpleError('卸载插件失败');
        } else {
            $this->simpleSuccess('卸载成功', U('index'));
        }
    }
}