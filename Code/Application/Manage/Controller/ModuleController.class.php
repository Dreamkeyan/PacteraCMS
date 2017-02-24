<?php
namespace Manage\Controller;

use Think\Exception;

class ModuleController extends CommonController
{
    /**
     * 模块管理
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function index()
    {
        $moduleInfo = D('Module')->getModuleList();

        $this->assign('module', $moduleInfo);
        $this->display();
    }

    /**
     * 模块更新
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function update()
    {
        $data = I('get.');

        $model = D('Module');
        try {

            // 获取本地模块数据
            $moduleData = $model->filterData($data['name']);
            $moduleData['module_id'] = $data['id'];

            $model->updateModule($moduleData);

            $this->simpleSuccess(L('save_success',array('name' => '模块')),U('index'));

        } catch (Exception $e) {
            $this->simpleError($e->getMessage());
        }




    }

    /**
     * 模块安装
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function install()
    {
        $model = D('Module');

        $moduleName = I('get.name');

        try {

            // 是否重复安装
            if ($model->checkModule($moduleName)) {
                throw new Exception(L('exist_module'));
            }

            $moduleData = $model->filterData($moduleName);

            $model->install($moduleData);

            $this->simpleSuccess(L('install_success'),U('index'));

        } catch(Exception $e) {
            $this->simpleError($e->getMessage());
        }

    }

    /**
     * 模块卸载
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function uninstall()
    {
        $model = D('Module');
        $id = I('get.id');

        try {
            $moduleInfo = $model->field(true)->find($id);
            if (empty($moduleInfo)) {
                throw new Exception('未找到模块信息');
            }

            if ($moduleInfo['is_system'] == 1) {
                throw new Exception('系统模块不可卸载');
            }

            $model->uninstall($moduleInfo);

            $this->simpleSuccess(L('uninstall_success'),U('index'));
        } catch (Exception $e) {
            $this->simpleError($e->getMessage());
        }
    }

    /**
     * 启用模块
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function enable()
    {
        $id = I('get.id', 0);

        if (D('Module')->save(array('id'=>$id, 'status'=>1)) !== false) {
            $this->simpleSuccess(L('enable_success'),U('index'));
        } else {
            $this->simpleError(L('enable_error'));
        }
    }

    /**
     * 禁用模块
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function disable()
    {
        $id = I('get.id', 0);

        if (D('Module')->save(array('id'=>$id, 'status'=>0)) !== false) {
            $this->simpleSuccess(L('disable_success'),U('index'));
        } else {
            $this->simpleError(L('disable_error'));
        }
    }
}