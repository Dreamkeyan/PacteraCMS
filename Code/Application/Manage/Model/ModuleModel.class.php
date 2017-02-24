<?php
namespace Manage\Model;

use Common\Library\Exception\commonException;
use Common\Library\Sql\Sql;
use Common\Model\CommonModel;
use Think\Exception;
use Think\Storage;

class ModuleModel extends CommonModel
{
    protected $tableName = 'manage_module';
    protected $token = 'manage_module';

    // 自动验证
    protected $_validate = array(
        array('module_name', 'require', '{%module_name}'),
        array('module_title', 'require', '{%module_title}'),
        array('module_menu', 'require', '{%module_menu}')
    );

    // 自动完成
    protected $_auto = array(
        array('status', 1),
        array('create_time', 'time', 1, 'function'),
        array('update_time', 'time', 2, 'function')
    );

    /**
     * 获取所有模块信息
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     */
    public function getModuleList()
    {
        // 读取本地模块列表
        $moduleDir = array_map('basename', glob(APP_PATH.'*', GLOB_ONLYDIR));

        $moduleList = [];
        foreach ($moduleDir as $key => $dir) {
            $configFile = $this->getConfigFile($dir);

            if (Storage::has($configFile)) {
                $configInfo = include $configFile;
                $configInfo['module_info']['status'] = -1;

                if ($configInfo['module_info']['module_name']) {
                    $moduleList[$configInfo['module_info']['module_name']] = $configInfo['module_info'];
                }
            }
        }

        // 获取已安装模块
        $moduleResult = $this->field(true)->select();
        $installList = [];
        if (!empty($moduleResult)) {
            foreach ($moduleResult as $key => $value) {
                $installList[$value['module_name']] = $value;
            }
            $moduleList = array_merge($moduleList, $installList);
        }

        return $moduleList;
    }

    /**
     * 模块安装
     * @param array $moduleData 模块数据
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool
     * @throws Exception
     */
    public function install(array $moduleData)
    {
        // 创建模块数据
        $moduleData = $this->create($moduleData);
        if ($moduleData == false) {
            throw new Exception($this->getError());
        }

        try {
            $this->startTrans();

            // 安装模块信息
            $id = $this->add();
            if (!$id) {
                throw new commonException(L('install_error'));
            }

            // 写入权限菜单
            $menu = list_to_tree(json_decode($moduleData['module_menu'],true));

            if (empty($menu)) {
                throw new commonException(L('param_error'));
            }

            foreach ($menu as $key => $value) {
                // 添加主导航
                $data = array(
                    'module_id'   => $id,
                    'module_name' => $moduleData['module_name'],
                    'menu_name'   => $moduleData['module_title'],
                    'menu_key'    => strtolower($value['menu_key']),
                    'parent_id'   => 0,
                    'orderby'     => 1,
                    'is_show'     => 1
                );

                $navId = $this->table('__MANAGE_MENU__')->add($data);

                if (empty($navId)) {
                    throw new commonException(L('add_menu_error'));
                }

                // 添加二级导航
                if (!empty($value['_child'])) {
                    foreach ($value['_child'] as $secondKey => $secondValue) {
                        $data['menu_name'] = $secondValue['title'];
                        $data['menu_key']  = strtolower($secondValue['menu_key']);
                        $data['parent_id'] = $navId;
                        $data['is_show']   = 1;

                        $secondId = $this->table('__MANAGE_MENU__')->add($data);

                        if (empty($secondId)) {
                            throw new commonException(L('add_menu_error'));
                        }

                        // 添加三级导航
                        if (!empty($secondValue['_child'])) {
                            foreach ($secondValue['_child'] as $thirdKey => $thirdValue) {
                                $data['menu_name']   = $thirdValue['title'];
                                $data['menu_key']    = strtolower($thirdValue['menu_key']);
                                $data['parent_id']   = $secondId;
                                $data['menu_action'] = $thirdValue['url'];

                                $data['is_show'] = isset($thirdValue['is_show']) ? $thirdValue['is_show']  : 0;

                                $thirdId = $this->table('__MANAGE_MENU__')->add($data);
                                if (empty($thirdId)) {
                                    throw new commonException(L('add_menu_error'));
                                }

                                // 添加功能菜单
                                if (!empty($thirdValue['_child'])) {
                                    foreach ($thirdValue['_child'] as $fourthKey => $fourthValue) {
                                        $data['menu_name']   = $fourthValue['title'];
                                        $data['menu_key']    = strtolower($fourthValue['menu_key']);
                                        $data['parent_id']   = $thirdId;
                                        $data['menu_action'] = $fourthValue['url'];
                                        $data['is_show']     = isset($fourthValue['is_show']) ? $fourthValue['is_show'] : 0;

                                        $fourthId = $this->table('__MANAGE_MENU__')->add($data);
                                        if (empty($fourthId)) {
                                            throw new commonException(L('add_menu_error'));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->commit();

            // 写入数据库信息
            $this->executeSql($moduleData['module_name']);

            return true;
        } catch (commonException $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * 模块卸载
     * @param $moduleInfo
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool
     * @throws \Exception
     * @throws commonException
     */
    public function uninstall($moduleInfo)
    {
        try {
            $this->startTrans();

            // 删除模块数据
            $result = $this->delete($moduleInfo['id']);
            if ($result === false) {
                throw new commonException(L('uninstall_error'));
            }

            // 删除菜单数据
            $menuResult = $this->table('__MANAGE_MENU__')->where(array('module_id'=>$moduleInfo['id']))->delete();

            if ($menuResult === false) {
                throw new commonException(L('uninstall_error'));
            }

            $this->commit();

            // 删除数据库相关文件
            $this->executeSql($moduleInfo['module_name'], 0);

            return true;
        } catch (commonException $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function updateModule($moduleData)
    {
        // 本地菜单
        $localMenu = json_decode($moduleData['module_menu'], true);
        $tempLocalMenu = array_column($localMenu, null, 'menu_key');

        // 获取权限菜单
        $menuList = $this->table('__MANAGE_MENU__')->where(array('module_id'=> array('eq', $moduleData['module_id'])))->field('menu_id,menu_key,parent_id')->select();
        $menuList = array_column($menuList, null, 'menu_key');
        $tempMenuList = $menuList;

        $update = array();
        $diff = array();
        foreach ($localMenu as $key => $value) {
            $index = strtolower($value['menu_key']);

            if (isset($menuList[$index])) {
                $update[$key] = $value;
                $update[$key]['menu_id'] = $menuList[$index]['menu_id'];
                unset($localMenu[$key]);
                unset($menuList[$index]);
            }
        }

        $menuFormat = array_column($tempMenuList,null, 'parent_id');
        $localMenuFormat = array_column($tempLocalMenu,null,'id');

        try {
            $this->startTrans();

            // 删除权限菜单数据
            if (!empty($menuList)) {
                // 首先判断需要删除的菜单下是否存有子节点。如果有则更新失败
                foreach ($menuList as $key => $value) {
                    if (array_key_exists($value['menu_id'], $menuFormat)) {
                        throw new commonException(L('exist_node'));
                    }
                }
                $deleteResult = $this->table('__MANAGE_MENU__')->where(array('menu_id' => array('in',array_column($menuList,'menu_id') )))->delete();
                if (empty($deleteResult)) {
                    throw new commonException(L('save_error',array('name'=>'模块')));
                }
            }

            // 添加权限菜单数据
            if (!empty($localMenu)) {

                foreach ($localMenu as $key => $value) {
                    $parent_id = 0;
                    if ($parent_id != 0) {
                        $menu_key = isset($localMenuFormat[$value['pid']]) ? strtolower($localMenuFormat[$value['pid']]['menu_key']) : 0;

                        // 存在未找到 menu_key 时直接抛出异常
                        if (empty($menu_key)) {
                            throw new commonException(L('menu_key_undefined'));
                        }

                        $parent_id = $this->table('__MANAGE_MENU__')->where(array('menu_key'=>array('eq', $menu_key)))->getField('menu_id');
                    }

                    $data = array(
                        'module_id'   => $moduleData['module_id'],
                        'module_name' => $moduleData['module_name'],
                        'menu_key'    => strtolower($value['menu_key']),
                        'menu_name'   => $value['title'],
                        'menu_action' => !empty($value['url']) ? $value['url'] : '',
                        'parent_id'   => $parent_id,
                        'is_show'     => isset($moduleData['is_show']) ? $moduleData['is_show'] : 0
                    );

                    $result = $this->table('__MANAGE_MENU__')->add($data);

                    if (empty($result)) {
                        throw new commonException('param_error');
                    }
                }
            }

            // 更新权限菜单
            if (!empty($update)) {
                foreach ($update as $key => $value) {
                    $parent_id = 0;
                    if ($value['pid'] != 0) {
                        $menu_key = isset($localMenuFormat[$value['pid']]) ? strtolower($localMenuFormat[$value['pid']]['menu_key']) : 0;

                        // 存在未找到 menu_key 时直接抛出异常
                        if (empty($menu_key)) {
                            throw new commonException(L('menu_key_undefined'));
                        }

                        $parent_id = $this->table('__MANAGE_MENU__')->where(array('menu_key'=>array('eq', $menu_key)))->getField('menu_id');

                    }

                    $data = array(
                        'menu_key'    => strtolower($value['menu_key']),
                        'menu_name'   => $value['title'],
                        'menu_action' => $value['url'],
                        'parent_id'   => $parent_id
                    );

                    if ($this->table('__MANAGE_MENU__')->where(array('menu_id'=> array('eq', $value['menu_id'])))->save($data) === false) {
                        throw new commonException(L('common_error'));
                    }
                }
            }

            // 更新模块信息
            $id = $moduleData['module_id'];
            if ($this->where(array('id' => array('eq', $id)))->save($this->create($moduleData)) === false) {
                throw new commonException(L('save_error',array('name'=>'模块')));
            }

            $this->commit();
            return true;

        } catch (commonException $e) {
            $this->rollback();
            throw $e;
        }

    }

    /**
     * 判断模块是否安装
     * @param string $moduleName
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool
     */
    public function checkModule($moduleName = '')
    {
        $count = $this->where(array('module_name' => ucfirst($moduleName)))->count();
        return ($count > 0) ? true : false;
    }

    /**
     * 获取数据表配置文件
     * @param     $dir
     * @param int $type
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return string
     */
    public function getSqlFile($dir, $type = 1)
    {
        $file = ($type == 1) ? 'install.sql' : 'uninstall.sql';

        $sqlFile = realpath(APP_PATH.ucfirst($dir)).DS.'Sql'.DS.$file;
        return $sqlFile;
    }

    /**
     * 运行安装所需SQL文件
     * @param     $moduleName
     * @param int $type
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return bool
     * @throws Exception
     */

    public function executeSql($moduleName, $type = 1)
    {
        // 解析SQL文件
        $sql = Sql::getSqlFromFile($this->getSqlFile($moduleName, $type));

        if (!empty($sql)) {
            foreach ($sql as $key => $value) {
                if (strpos($value, 'SET') !== false ) {
                    continue;
                }
                if ((strpos($value, '[PACTERA_PREFIX]') === false) || (strpos($value, '[PACTERA_MODULE]') === false)) {
                    throw new Exception(L('sql_notice'));
                }
            }

            $sql = str_replace(array('[PACTERA_PREFIX]','[PACTERA_MODULE]'), array(strtolower(C('MODULE_CONFIG.DB_PREFIX')),strtolower($moduleName) ), $sql);

            if (!empty($sql)) {
                foreach ($sql as $key => $value) {
                    $this->execute($value);
                }
                return true;
            }
        }

        return false;
    }

    /**
     * 获取及过滤模块数据
     * @param $moduleName
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return array
     * @throws \Exception
     * @throws commonException
     */
    public function filterData($moduleName)
    {

        try {
            // 判断描述文件
            $moduleConfigFile = $this->getConfigFile($moduleName);
            if (!Storage::has($moduleConfigFile)) {
                throw new commonException(L('not_exist_desc_file'));
            }

            // 初始化安装数据
            $moduleData = [];

            // 获取配置信息
            $moduleConfig = include $moduleConfigFile;
            if (empty($moduleConfig) || empty($moduleConfig['module_info']['module_name'])) {
                throw new commonException(L('desc_file_empty'));
            }

            $moduleData = $moduleConfig['module_info'];

            // 当前模块用户导航
            if (is_array($moduleConfig['user_nav']) && !empty($moduleConfig['user_nav'])) {
                $moduleData['user_nav'] = json_encode($moduleConfig['user_nav']);
            }

            // 当前模块配置项
            if (is_array($moduleConfig['module_config']) && !empty($moduleConfig['module_config'])) {
                $moduleData['module_config'] = json_encode($moduleConfig['module_config']);
            }

            // 当前模块权限菜单
            if (empty($moduleConfig['module_menu'])) {
                throw new commonException(L('module_menu_empty'));
            }

            $menuKey = array();
            array_walk_recursive($moduleConfig['module_menu'], function($value, $key) use(&$menuKey){
                if ($key == 'menu_key') {
                    $menuKey[] = strtolower($value);
                }
            });

            if (count($moduleConfig['module_menu']) != count(array_unique($menuKey))) {
                throw new commonException(L('menu_key_exist'));
            }

            $moduleData['module_menu'] = json_encode($moduleConfig['module_menu']);

            // 是否为系统模块
            if (in_array($moduleName, array('Manage', 'System'))) {
                $moduleData['is_system'] = 1;
            }



            return $moduleData;
        } catch (commonException $e) {
            throw $e;
        }

    }

    /**
     * 获取模块配置信息
     * @param $dir
     *
     * @author 祝海亮 <liangh.zhu@gmail.com>
     *
     * @return string
     */
    public function getConfigFile($dir)
    {
        $configFile = realpath(APP_PATH.$dir).DS.'ModuleConf.php';
        return $configFile;
    }
}