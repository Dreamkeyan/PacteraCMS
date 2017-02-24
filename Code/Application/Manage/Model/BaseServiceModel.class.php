<?php
namespace Manage\Model;

use Common\Model\CommonModel;

class BaseServiceModel extends CommonModel{
    
    
    private $_serviceUrl = '';
    private $_soapClient = '';
    
    public function __construct(){
        
        $this->_serviceUrl = C('WEB_SERVICE.URL');
        
        $this->_soapClient = new \SoapClient($this->_serviceUrl);
        
        
    }
    /**
     * 检测服务是否启动
     * 
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午9:59:18
     */
    public function checkServiceIsRun(){
        
        if(isset($_SESSION['service'])){
            $status = session('service');
        }else{
            $res = $this->_soapClient->CntConTest(array('code'=>'1111','password'=>'young_king' ,'commType'=>'3', 'ComPort'=>'3', 'TelNum'=>''));
            
            $status = intval($res->CntConTestResult);
            session('service',$status);
        }
        
        return $status;
    }
    /**
     * 检测集中器是否运行
     * 
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:16:01
     */
    public function checkMonitorIsRun($param = array('monitor_id'=>10)){
        
        if(isset($_SESSION['monitorStatus'.$param['monitor_id']]) && intval($_SESSION['monitorStatus'.$param['monitor_id']]) == 1){
            $status = session('monitorStatus'.$param['monitor_id']);
        }else{
            $status = $this->startMonitor($param);
        }
        
        return $status;
        
    }
    /**
     * 连接集中器
     * 
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:02:51
     */
    public function startMonitor($param = array('monitor_id'=>10)){
        $res = $this->_soapClient->StartMonitor(array('concentratorID'=>$param['monitor_id'],'keepAlive'=>true));
        
        //存储
        session('monitorStatus'.$param['monitor_id'],$res->StartMonitorResult);
        
        return $res->StartMonitorResult == 1?true:false;
    }
    /**
     * 断开集中器
     * @param array $param
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:04:37
     */
    public function stopMonitor($param = array('monitor_id'=>10)){
        $res = $this->_soapClient->StopMonitor(array('concentratorID'=>$param['monitor_id'],'keepAlive'=>true));
        
        session('monitorStatus'.$param['monitor_id'],$res->StopMonitorResult == 1?1:0);
        
        return $res->StopMonitorResult == 1?true:false;
    }
    
    public function checkDevice(){
        
    }
    
    /**
     * 启动设备
     * @param unknown $param
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:12:38
     */
    public function startDevice($param){
        $i = 0;
        //do {
            $res = $this->_soapClient->PowerUpSingleDevice(array('deviceID'=>$param['device_id']));
        //    $i++;
            $res = $res->PowerUpSingleDeviceResult;
        //}while ( $res == true);
        
        return $res == 1?true:false;
    }
    /**
     * 停止设备
     * 
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:12:46
     */
    public function stopDevice($param){
        $i = 0;
        //do {
            $res = $this->_soapClient->PowerOffSingleDevice(array('deviceID'=>$param['device_id']));
        //  $i++;
            $res = $res->PowerOffSingleDeviceResult;
        //}while ( $res == true);
        
        return $res == 1?true:false;
    }
    /**
     * 读取设备基础数据
     * @param unknown $param
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 上午11:15:32
     */
    public function readDeviceData($param){
        $res = $this->_soapClient->ReadDevicesData(array('deviceID'=>$param['device_id']));
        
        return ($res->ReadDevicesDataResult/100);
    }
    /**
     * 开关
     * @param unknown $param
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 下午4:27:14
     */
    public function openDevice($param){
        
        //全关0
        //     $ValveFullClose = $c->ValveFullClose(array('deviceID'=>22));
        //全开3
        //     $ValveFullOpen = $c->ValveFullOpen(array('deviceID'=>22));
        
        //开三分之一 1
        //     $ValveOpenWith1Per3 = $c->ValveOpenWith1Per3(array('deviceID'=>22));
        
        //开三分之二 2
        //$ValveOpenWith2Per3 = $c->ValveOpenWith2Per3(array('deviceID'=>22));
        
        $type = $param['type'];
        
        $result = '';
        
        switch ($type){
            case 'full':
                $res = $this->_soapClient->ValveFullOpen(array('deviceID'=>$param['device_id']));
                $result = $res->ValveFullOpenResult;
                break;
            case '1/3':
                $res = $this->_soapClient->ValveOpenWith1Per3(array('deviceID'=>$param['device_id']));
                $result = $res->ValveOpenWith1Per3Result;
                break;
            case '2/3':
                $res = $this->_soapClient->ValveOpenWith2Per3(array('deviceID'=>$param['device_id']));
                $result = $res->ValveOpenWith2Per3Result;
                break;
        }
        
        return $result?1:0;
        
    }
    /**
     * 关闭设备
     * @param unknown $param
     * @author sunny5156<137898350@qq.com>
     * @version 
     * @todo  2016年3月3日 下午4:29:58
     */
    public function closeDevice($param){
        $type = $param['type'];
        $res = $this->_soapClient->ValveFullClose(array('deviceID'=>$param['device_id']));
        
        return $res->ValveFullCloseResult?1:0;
    }
}