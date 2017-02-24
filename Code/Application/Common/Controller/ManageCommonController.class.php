<?php

namespace Common\Controller;

use Think\Page;
use Manage\Model\SettingModel;
use Manage\Model\RoleMapsModel;
use Manage\Model\MenuModel;
/**
 * Manage权限父类
 * @author sunny5156 <137898350@qq.com>
 * @version
 */
class ManageCommonController extends CommonController{
    
    protected $_admin = array();
    protected $_CONFIG = array();
    protected $order = 'id desc';


    public function __construct(){
        
        parent::__construct();
        
        $this->_admin = session('admin');
        $not_permission = array('login', 'public', 'common', 'clean', 'attachment');
        
        if (!in_array(strtolower(CONTROLLER_NAME), $not_permission) && strtolower(ACTION_NAME) != 'updatepassword') { //public 不受权限控制
            if (empty($this->_admin)) {
                header("Location: " . U('login/index'));
                exit();
            }
            //所有菜单
            $menuModel = new MenuModel();
            $menu = $menuModel->fetchAll();

            if ($this->_admin['role_id'] != 1) {
                $roleMapsModel = new RoleMapsModel();
                $this->_admin['menu_list'] = $roleMapsModel->getMenuIdsByRoleId($this->_admin['role_id']);
        
                if (strtolower(CONTROLLER_NAME) != 'index') { //其他页面需要判断权限
                    $menu_action = strtolower(MODULE_NAME . '/' .CONTROLLER_NAME . '/' . ACTION_NAME);
        
                    $menu_id = 0;
                    foreach ($menu as $k => $v) {
                        if (strtolower($v['menu_action']) == strtolower($menu_action)) {
                            $menu_id = (int) $k;
                            break;
                        }
                    }
                    if (empty($menu_id) || !isset($this->_admin['menu_list'][$menu_id])) {
                        $this->simpleError('很抱歉您没有权限操作模块:' . $menu[$menu_id]['menu_name']);
                    }
                }
            }
        }
        $settingModel = new SettingModel();
        $this->_CONFIG = $settingModel->fetchAll();
        define('__HOST__', $this->_CONFIG['site']['host']);
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('admin', $this->_admin);
        $this->assign('today', TODAY); //兼容模版的其他写法
        $this->assign('nowtime', NOW_TIME);
    }

    /**
     * MP Success
     * @param unknown $message
     * @param string $jumpUrl
     * @param number $time
     * @author sunny5156 <137898350@qq.com>
     * @version 0.0.0.1
     */
    protected function simpleSuccess($message, $jumpUrl = '', $time = 500) {
        $str  ="<div></div>";
        $str = '<script src="'.C('TMPL_PARSE_STRING.__ASSET__').'/Common/Admin/js/jquery.min.js"></script>';
        $str .='<script src="'.C('TMPL_PARSE_STRING.__ASSET__').'/Common/Admin/plugins/layer/layer.min.js"></script>';
        $str .='<script>';
        $str .='var objLayer = "";';
        $str .='if(window.parent == window){objLayer = layer}else{objLayer = parent.layer}';
        $str .='objLayer.msg("'.$message.'", {icon: 1,time: ' . $time . '}, function(){
                  window.location.href = "'.$jumpUrl.'";
                })';
        $str .='</script>';
        exit($str);
    }

    protected function simpleSuccessAlert($message, $jumpUrl = '', $time = 3000) {
        $str = '<script>';
        $str .='parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str.='</script>';
        echo $str;
    }
    /**
     * MP Error
     * @param unknown $message
     * @param number $time
     * @param string $yzm
     * @param string $load
     * @author sunny5156 <137898350@qq.com>
     * @version 0.0.0.1
     */
    protected function simpleError($message, $time = 1000, $yzm = false, $load = '') {
        $str  ="<div></div>";
        $str = '<script src="'.C('TMPL_PARSE_STRING.__ASSET__').'/Common/Admin/js/jquery.min.js"></script>';
        $str .='<script src="'.C('TMPL_PARSE_STRING.__ASSET__').'/Common/Admin/plugins/layer/layer.min.js"></script>';
        $str .='<script>';
        $str .='var objLayer = "";';
        $str .='if(window.parent == window){objLayer = layer}else{objLayer = parent.layer}';
        $str .='objLayer.msg("'.$message.'", {icon: 2,time: ' . $time . '}, function(){history.go(-1);}) ';
        $str.='</script>';
        exit($str);
    }
    
    /**
     * 公共index
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 2016.3.11
     */
    public function index($where = null, $model = CONTROLLER_NAME, $lists = null)
    {
        !$lists && $lists = $this->lists($model, $where, $this->order, $this->field);
//        sql();
        int_to_string($lists, $this->map_to_string);
        //display前置操作
        method_exists($this, '_before_index_display') && $this->_before_index_display($lists);
        //记录当前列表页的Cookie
        Cookie('__forward__', $_SERVER['REQUEST_URI']);
        $this->lists = $lists;
        $this->meta_title = $this->meta[CONTROLLER_NAME].'列表';
//        dump($this->lists);
        $this->display();
    }
    
    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model = CONTROLLER_NAME,$where=array(),$order='',$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');

        if(is_string($model)){
            $model  =   D($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        //排除视图模型和关联模型

        /*if(!$where['status']  && (D(CONTROLLER_NAME) == $model)){
            $where['status']  =   array('gt',0);
        }*/

        if( !empty($where)){
            $options['where']   =   $where;
        }

        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
//        $page = new \Think\Page($total, $listRows, I('get.'));
        $page = new Page($total, $listRows, I('get.'));
        if ($total > $listRows) {
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        //修正分页样式
//        $page_old_style = array('<a', '<span class="current">', '</span>', '<span class="rows">');
//        $page_new_style = array('<li><a', '<li class="active"><a href="#">', '</a>','<a class="rows">');
//        $p = str_replace($page_old_style, $page_new_style, $page->show());
        $p = $page->show();
        $this->assign('_page', $p ? $p : '');
        $this->assign('_total', $total);
        $options['limit'] = $page->firstRow . ',' . $page->listRows;

        $model->setProperty('options', $options);

        return $model->field($field)->select();
    }
    
}