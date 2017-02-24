<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;

class CleanController extends CommonController {

    public function cache() {

        if(D('Clean')->cleanCache()){
            $this->simpleSuccess('更新缓存成功！', U('index/main'));
        }else{
            $this->simpleError('更新缓存失败！');
        }

    }

}
