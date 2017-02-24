<?php

/**
 * 
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Model;

use Common\Model\CommonModel;

class  RoleMapsModel extends CommonModel{
    
    protected $tableName =  'manage_role_maps';
    protected $token =  'manage_role_maps';
    
    public function getMenuIdsByRoleId($role_id){
        $role_id = (int) $role_id;
        $datas = $this->where(" role_id = '{$role_id}' ")->select();
        $return = array();
        foreach($datas as $val){
            $return[$val['menu_id']] = $val['menu_id'];
        }
        return $return;
    }
    
}
