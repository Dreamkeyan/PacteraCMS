<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think;
/**
 * 用于ThinkPHP的自动生成
 */
class Build {

    static protected $controller   =   '<?php
namespace [MODULE]\Controller;
class [CONTROLLER]Controller extends FrontBaseController {
    public function index(){
        $this->show(\'<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>PacteraCMS</b>！</p><br/>本系统基于 ThinkPHP  V{$Think.version} 开发</div>\',\'utf-8\');
    }
}';
    static protected $ManageBaseController   =   '<?php
/**
 * pactera cms [MODULE] manage
 * @author sunny5156  <137898350@qq.com>
 * @date [DATE]
 * @version
 */
namespace [MODULE]\Controller;
use Common\Controller\ManageCommonController;
class [CONTROLLER]Controller extends ManageCommonController {
    
}';
    static protected $ApiBaseController   =   '<?php
/**
 * pactera cms [MODULE] api
 * @author sunny5156  <137898350@qq.com>
 * @date [DATE]
 * @version
 */
namespace [MODULE]\Controller;
use Common\Controller\ApiCommonController;
class [CONTROLLER]Controller extends ApiCommonController {
    
}';
    static protected $FrontBaseController   =   '<?php
/**
 * pactera cms [MODULE] front
 * @author sunny5156  <137898350@qq.com>
 * @date [DATE]
 * @version
 */
namespace [MODULE]\Controller;
use Common\Controller\FrontCommonController;
class [CONTROLLER]Controller extends FrontCommonController {
    
}';

    static protected $model         =   '<?php
/**
 * pactera cms [MODULE] model
 * @author sunny5156  <137898350@qq.com>
 * @date [DATE]
 * @version
 */
namespace [MODULE]\Model;
use Common\Model\CommonModel;
class [MODEL]Model extends CommonModel {

}';
    
    
    static protected $zhcnLang = '<?php
return array(
    "welcome"=>"欢迎使用Pactera模块化电商平台系统",
);
?>';
    static protected $zhtwLang = '<?php
return array(
    "welcome"=>"歡迎使用文思海輝模塊化電商平台系統",
);
?>';
    static protected $enusLang = '<?php
return array(
    "welcome"=>"Welcome Pactera Business Platform System",
);
?>';
    // 检测应用目录是否需要自动创建
    static public function checkDir($module){
        if(!is_dir(APP_PATH.$module)) {
            // 创建模块的目录结构
            self::buildAppDir($module);
        }elseif(!is_dir(LOG_PATH)){
            // 检查缓存目录
            self::buildRuntime();
        }
    }

    // 创建应用和模块的目录结构
    static public function buildAppDir($module) {
        // 没有创建的话自动创建
        if(!is_dir(APP_PATH)) mkdir(APP_PATH,0755,true);
        if(is_writeable(APP_PATH)) {
            $dirs  = array(
                COMMON_PATH,
                COMMON_PATH.'Common/',
                CONF_PATH,
                APP_PATH.$module.'/',
                APP_PATH.$module.'/Common/',
                APP_PATH.$module.'/Controller/',
                APP_PATH.$module.'/Model/',
                APP_PATH.$module.'/Conf/',
                APP_PATH.$module.'/View/',
                //APP_PATH.$module.'/View/default/',//默认模板
                //APP_PATH.$module.'/View/default/Public/',//公共文件夹
                APP_PATH.$module.'/TagLib/',
                APP_PATH.$module.'/Lang/',
                APP_PATH.$module.'/Lang/zh-cn/',
                APP_PATH.$module.'/Lang/zh-tw/',
                APP_PATH.$module.'/Lang/en-us/',
                APP_PATH.$module.'/Sql/',
                /*资源*/
                PACTERA_ROOT.'Asset/'.$module.'/',
                PACTERA_ROOT.'Asset/'.$module.'/Admin/css/',
                PACTERA_ROOT.'Asset/'.$module.'/Front/js/',
                PACTERA_ROOT.'Asset/'.$module.'/Mobile/images/',
                /*资源*/
                /*附件*/
                PACTERA_ROOT.'Attachment/'.$module.'/',
                /*附件*/
                RUNTIME_PATH,
                CACHE_PATH,
                CACHE_PATH.$module.'/',
                LOG_PATH,
                LOG_PATH.$module.'/',
                TEMP_PATH,
                DATA_PATH,
                );
            foreach ($dirs as $dir){
                if(!is_dir($dir))  mkdir($dir,0755,true);
            }
            // 写入目录安全文件
            self::buildDirSecure($dirs);
            // 写入应用配置文件
            if(!is_file(CONF_PATH.'config'.CONF_EXT))
                file_put_contents(CONF_PATH.'config'.CONF_EXT,'.php' == CONF_EXT ? "<?php\nreturn array(\n\t//'配置项'=>'配置值'\n);":'');
            // 写入模块配置文件
            if(!is_file(APP_PATH.$module.'/Conf/config'.CONF_EXT))
                file_put_contents(APP_PATH.$module.'/Conf/config'.CONF_EXT,'.php' == CONF_EXT ? "<?php\nreturn array(\n\t//'配置项'=>'配置值'\n\t'LANG_SWITCH_ON' => true,   // 开启语言包功能\n\t'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效\n\t'DEFAULT_LANG' => 'zh-cn', // 默认语言\n\t'LANG_LIST'        => 'zh-cn,en-us,zh-tw', // 允许切换的语言列表 用逗号分隔\n\t'VAR_LANGUAGE'     => 'l', // 默认语言切换变量\n);":'');
            // 写入模块配置文件
            if(!is_file(APP_PATH.$module.'/ModuleConf'.CONF_EXT))
                file_put_contents(APP_PATH.$module.'/ModuleConf'.CONF_EXT,'.php' == CONF_EXT ? "<?php\nreturn array(\n\t//'配置项'=>'配置值'\n);":'');

            // 生成模块的测试控制器
            if(defined('BUILD_CONTROLLER_LIST')){
                // 自动生成的控制器列表（注意大小写）
                //检测除过的模块
                if(self::checkExceptModule($module)){
                    $list = explode(',',BUILD_CONTROLLER_LIST);
                    foreach($list as $controller){
                    
                        /*sunny5156 重写build*/
                        switch ($controller){
                    
                            case 'ManageBase':
                                self::buildManageController($module,$controller);
                                break;
                            case 'ApiBase':
                                self::buildApiController($module,$controller);
                                break;
                            case 'FrontBase':
                                self::buildFrontController($module,$controller);
                                break;
                            default:
                                self::buildController($module,$controller);
                                break;
                        }
                    }
                }
                
            }else{
                // 生成默认的控制器
                self::buildController($module);
            }
            // 生成模块的模型
            if(self::checkExceptModule($module)){
                if(defined('BUILD_MODEL_LIST')){
                    // 自动生成的控制器列表（注意大小写）
                    $list = explode(',',BUILD_MODEL_LIST);
                    foreach($list as $model){
                        self::buildModel($module,$model);
                    }
                }
            }
            
            //生成语言包
            $list = explode(',', 'zh-cn,zh-tw,en-us');
            foreach($list as $lang){
                self::buildLang($module,$lang);
            }
        }else{
            header('Content-Type:text/html; charset=utf-8');
            exit('应用目录['.APP_PATH.']不可写，目录无法自动生成！<BR>请手动生成项目目录~');
        }
    }

    // 检查缓存目录(Runtime) 如果不存在则自动创建
    static public function buildRuntime() {
        if(!is_dir(RUNTIME_PATH)) {
            mkdir(RUNTIME_PATH);
        }elseif(!is_writeable(RUNTIME_PATH)) {
            header('Content-Type:text/html; charset=utf-8');
            exit('目录 [ '.RUNTIME_PATH.' ] 不可写！');
        }
        mkdir(CACHE_PATH);  // 模板缓存目录
        if(!is_dir(LOG_PATH))   mkdir(LOG_PATH);    // 日志目录
        if(!is_dir(TEMP_PATH))  mkdir(TEMP_PATH);   // 数据缓存目录
        if(!is_dir(DATA_PATH))  mkdir(DATA_PATH);   // 数据文件目录
        return true;
    }

    // 创建控制器类
    static public function buildController($module,$controller='Index') {
        $file   =   APP_PATH.$module.'/Controller/'.$controller.'Controller'.EXT;
        if(!is_file($file)){
            $content = str_replace(array('[MODULE]','[CONTROLLER]'),array($module,$controller),self::$controller);
            if(!C('APP_USE_NAMESPACE')){
                $content    =   preg_replace('/namespace\s(.*?);/','',$content,1);
            }
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            file_put_contents($file,$content);
        }
    }
    // 创建管理端控制器类
    static public function buildManageController($module,$controller='ManageBase') {
        $file   =   APP_PATH.$module.'/Controller/'.$controller.'Controller'.EXT;
        if(!is_file($file)){
            $content = str_replace(array('[MODULE]','[CONTROLLER]','[DATE]'),array($module,$controller),self::$ManageBaseController,date('Y-m-d'));
            if(!C('APP_USE_NAMESPACE')){
                $content    =   preg_replace('/namespace\s(.*?);/','',$content,1);
            }
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            file_put_contents($file,$content);
        }
    }
    // 创建接口控制器类
    static public function buildApiController($module,$controller='ApiBase') {
        $file   =   APP_PATH.$module.'/Controller/'.$controller.'Controller'.EXT;
        if(!is_file($file)){
            $content = str_replace(array('[MODULE]','[CONTROLLER]','[DATE]'),array($module,$controller),self::$ApiBaseController,date('Y-m-d'));
            if(!C('APP_USE_NAMESPACE')){
                $content    =   preg_replace('/namespace\s(.*?);/','',$content,1);
            }
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            file_put_contents($file,$content);
        }
    }
    // 创建前端控制器类
    static public function buildFrontController($module,$controller='ApiBase') {
        $file   =   APP_PATH.$module.'/Controller/'.$controller.'Controller'.EXT;
        if(!is_file($file)){
            $content = str_replace(array('[MODULE]','[CONTROLLER]','[DATE]'),array($module,$controller),self::$FrontBaseController,date('Y-m-d'));
            if(!C('APP_USE_NAMESPACE')){
                $content    =   preg_replace('/namespace\s(.*?);/','',$content,1);
            }
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            file_put_contents($file,$content);
        }
    }

    // 创建模型类
    static public function buildModel($module,$model) {
        $file   =   APP_PATH.$module.'/Model/'.$model.'Model'.EXT;
        if(!is_file($file)){
            $content = str_replace(array('[MODULE]','[MODEL]'),array($module,$model),self::$model);
            if(!C('APP_USE_NAMESPACE')){
                $content    =   preg_replace('/namespace\s(.*?);/','',$content,1);
            }
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            file_put_contents($file,$content);
        }
    }
    // 语言包
    static public function buildLang($module,$lang = 'zh-cn') {
        //$file   =   APP_PATH.$module.'/Lang/'.$lang.'/Common.php';
        $file   =   APP_PATH.$module.'/Lang/'.$lang.'.php';
        if(!is_file($file)){
            $dir = dirname($file);
            if(!is_dir($dir)){
                mkdir($dir, 0755, true);
            }
            switch ($lang){
                case 'zh-cn':
                    file_put_contents($file,self::$zhcnLang);
                    break;
                case 'zh-tw':
                    file_put_contents($file,self::$zhtwLang);
                    break;
                case 'en-us':
                    file_put_contents($file,self::$enusLang);
                    break;
            }
            
        }
    }

    // 生成目录安全文件
    static public function buildDirSecure($dirs=array()) {
        // 目录安全写入（默认开启）
        defined('BUILD_DIR_SECURE')  or define('BUILD_DIR_SECURE',    true);
        if(BUILD_DIR_SECURE) {
            defined('DIR_SECURE_FILENAME')  or define('DIR_SECURE_FILENAME',    'index.html');
            defined('DIR_SECURE_CONTENT')   or define('DIR_SECURE_CONTENT',     ' ');
            // 自动写入目录安全文件
            $content = DIR_SECURE_CONTENT;
            $files = explode(',', DIR_SECURE_FILENAME);
            foreach ($files as $filename){
                foreach ($dirs as $dir)
                    file_put_contents($dir.$filename,$content);
            }
        }
    }
    
    /**
     * 检测后台管理
     * @param strign $module
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年8月17日 上午10:56:50
     */
    static public function checkExceptModule($module) {
        if(defined('BUILD_MODULE_EXCEPT')){
            $moduleList = explode(',', BUILD_MODULE_EXCEPT);
            
            if(in_array($module, $moduleList)){
                return false;
            }
                
        }else{
            if($module == 'Manage'){
                return false;
            }
        }
        
        return true;
    }
}
