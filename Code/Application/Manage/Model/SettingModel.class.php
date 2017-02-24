<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;
use Think\Model;

class SettingModel extends CommonModel{
    
    protected $pk   = 'k';
    protected $tableName =  'system_setting';   
    protected $token = 'system_setting';
    protected $settings = null;
    
    // 自动完成
    protected $_auto = [
        ['create_time', 'time', 1, 'function'],
        ['update_time', 'time', 2, 'function']
    ];

    public function fetchAll(){
        $cache = S(array('type'=>'File','expire'=>  $this->cacheTime));
        if(!$data= $cache->get($this->token)){
            $result = $this->select();
            foreach($result  as $row){
                $row['v'] = unserialize($row['v']);
                $data[$row[$this->pk]] = $row['v'];
            }
            $cache->set($this->token,$data);
        }  

        $this->settings = $data;
        return $this->settings;
     }
     /**
      * 重写save
      * {@inheritDoc}
      * @see \Think\Model::save()
      */
     public function save($data){
         $res = $this->where(array('k'=>$data['k']))->find();
         $data = $this->create($data);
         if($res){
             $res  = parent::save($data);
         }else{
             $res  = parent::add($data);
         }
         
         return $res;
     }
     
}