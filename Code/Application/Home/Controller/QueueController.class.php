<?php

namespace Home\Controller;

/**
 * 消息队列处理类
 *
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016-10-20  11:44:25
 */
class QueueController extends \Think\Controller
{
    
    /**
     * 处理消息队列
     * 用法：php cli.php Home/Queue
     * @author Wang Rong 王荣 <rong.wang4@pactera.com>
     * @version 0.0.0.1
     * @datetime 2016.10.20
     */
    public function index()
    {
        while(true){
            $queue = M('Queue')->where(['status' => 0])->select();
            if($queue){
                foreach($queue as $v){
                    echo date('H:i:s')." task {$v['id']}ing...".chr(10);
                    if(call_user_func_array(unserialize($v['handler']), unserialize($v['param']))){
                        //处理成功更新任务状态
                        M('Queue')->where(['id' => $v['id']])->setField('status', 1);
                    };
                    echo date('H:i:s')." task{$v['id']} has been finished".chr(10);
                }
            }else{
                echo date('H:i:s').' waiting...'.chr(10);
            }
            
            sleep(1);
        }
    }
    
}
