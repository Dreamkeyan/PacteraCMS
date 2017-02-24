<?php

namespace Member\Controller;

/**
 * ucenter通信控制器
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.8.22
 */
class UcenterController extends \Think\Controller
{
    
    private $get;
    private  $post;


    public function __construct()
    {
        parent::__construct();
        
        //载入ucenter配置
        require_once  UC_CLIENT_PATH.'/config.inc.php';
        //载入ucenter client
        require_once  UC_CLIENT_PATH.'/client.php';
        
        include_once UC_CLIENT_PATH . '/lib/xml.class.php';
        saveLog($_GET,'uc');
        $get = $post = array();  
        $code = strval(@$_GET['code']);
        parse_str(uc_authcode($code, 'DECODE', UC_KEY), $get);

        $timestamp = time();  
        if (empty($get))  
        {  
            die('Invalid Request');  
        } elseif ($timestamp - $get['time'] > 3600)  
        {  
            die('Authracation has expiried');  
        }  
        $action = $get['action'];  
        $post = xml_unserialize(file_get_contents('php://input'));  
        
        $this->get = $get;
        $this->post = $post;
    }
    
    /**
     * ucenter通信主入口
     * 应用的主 URL:http://localhost/PacteraCMS/Code/Public/Member/Ucenter/index
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.8.22
     */
    public function index()
    {
        $action_array = [
            'test',
            'renameuser',
            'synlogin',
            'synlogout',
            'updatepw',
        ];
        
        if(in_array($this->get['action'], $action_array)){
            $action = $this->get['action'];
            $this->$action();
        }else{
            exit(0);
        }

    }
    
    /**
     * ucenter通信测试
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.8.22
     */
    private function test() 
    {  
        exit('1');  
    } 
    
    /**
     * ucenter同步登录
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.8.22
     */
    private function synlogin()
    {
        $member_model = new \Member\Model\PassportModel();
        if ($member_model->find($this->get['uid'])) {
            session('uid', $this->get['uid']);
        }
    }
    
    /**
     * ucenter同步退出
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.8.23
     */
    private function synlogout()
    {
        session('uid', null);
    }
    
}

