<?php

namespace Manage\Model;

/**
 * 清理模块
 * @author sunny5156  <137898350@qq.com>
 *
 */
class CleanModel {

    /**
     * 清理缓存
     * @return string
     * @author sunny5156  <137898350@qq.com>
     * @date 2017年1月22日 下午5:14:46
     * @version
     */
    public function cleanCache(){

        del_file_by_dir(RUNTIME_PATH . '/Temp/');
        del_file_by_dir(RUNTIME_PATH . '/Cache/');
        del_file_by_dir(RUNTIME_PATH . '/Logs/');

        return ture;

    }

}