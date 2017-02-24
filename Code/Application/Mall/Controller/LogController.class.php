<?php
/**
 * 记录日志
 * @author liym <yanming.li1@pactera.com>
 * @date 2016.1.18
 * @version  
 **/
namespace Mall\Controller;
use Think\Controller;

class LogController extends Controller {

    public function record() {
        $param = I('post.');

        $info = base64_decode($param['info']);

        $data = json_decode($info, true);
        $data['stay_time'] = $param['stay_ms'];

        M('MallBehavior')->add($data);
    }
    
}