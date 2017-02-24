<?php

namespace Common\Controller;

use Think\Controller;
use Manage\Model\SettingModel;
/**
 * 前台继承类
 * @author sunny5156 <137898350@qq.com>
 * @version
 */
class FrontCommonController extends CommonController{
    
    protected $_CONFIG = array();
    
    public function __construct(){
        
        parent::__construct();

        $settingModel = new SettingModel();
        $this->_CONFIG = $settingModel->fetchAll();
        define('__HOST__', $this->_CONFIG['site']['host']);
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('today', TODAY); //兼容模版的其他写法
        $this->assign('nowtime', NOW_TIME);
    }

    protected function simpleSuccess($message, $jumpUrl = '', $time = 500) {
        $str = '<script>';
        $str .='var str = ';
        $str .='parent.layer.msg("'.$message.'", {icon: 1,time: ' . $time . '}, function(){
                  //jumpUrl("' . $jumpUrl . '");
                  window.location.href = "'.$jumpUrl.'";
                });';
        $str.='</script>';
        exit($str);
    }

    protected function simpleSuccessAlert($message, $jumpUrl = '', $time = 3000) {
        $str = '<script>';
        $str .='parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str.='</script>';
        echo $str;
    }

    protected function simpleError($message, $time = 1000, $yzm = false, $load = '') {
        $str = '<script>';
//         if ($yzm) {
//             $str .='parent.error("' . $message . '",' . $time . ',"yzmCode()");';
//         } else if (!empty($load)) {
//             //$str .='parent.error("' . $message . '",' . $time . ',"load(this,\''.$load.'\'));';
//             $str .='parent.error("' . $message . '",' . $time . ',"load(this,\'' . $load . '\')");';
//         } else {
//             $str .='parent.error("' . $message . '",' . $time . ');';
//         }
        $str .='var str = parent.layer.msg("'.$message.'", {icon: 2,time: ' . $time . '}, function(){history.go(-1);}); ';
        $str.='</script>';
        exit($str);
    }
}