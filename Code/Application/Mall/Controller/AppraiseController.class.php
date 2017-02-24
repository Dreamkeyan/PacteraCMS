<?php
/**
 * 评论控制器
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.11.3
 * @version  
 **/

namespace Mall\Controller;

class AppraiseController extends MobileBaseController {
    
    public function index(){
        $param = I('get.');
        $res = D('Appraise')->getAppraiseList($param);

        $this->assign('data', $res);
        $this->display();
    }
    
}