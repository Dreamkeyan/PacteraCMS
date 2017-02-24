<?php

/**
 * 自定义标签获取数据
 * @author liym <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @todo 2016.08.18
 */

namespace Common\TagLib;

use Common\TagLib\Commons;

class DataBase extends Commons {

    protected $tags = array(
        // attr 属性列表close 是否闭合（0 或者1 默认为1，表示闭合）
        'list' => array('attr' => 'name,module,where,order,limit,id,page,field,key,mod,debug', 'level' => 3), //获取符合条件的列表（model的lists的方法） 
        'query' => array('attr' => 'name,module,where,sql,order,limit,id,page,field,key,mod,debug', 'level' => 3),//获取符合条件的列表（直接数据库查询信息） 
        
        'view' => array('attr' => 'name,module,pk,id,debug',  'level' => 3), //主键获取详情（model的view的方法） 
        'find' => array('attr' => 'name,module,pk,id,debug', 'level' => 3),//主键获取详情（直接数据库查询信息） 
        'row' => array('attr' => 'name,module,field,where,id,debug', 'level' => 3),//主键获取详情（直接数据库查询信息） 
        
        'content' => array('attr' => 'name,module,where,order,limit,id,page,field,key,mod,debug,prow,pid', 'level' => 3),//父类id获取子集（model的category的方法） 
        'cate' => array('attr' => 'name,module,where,order,limit,id,page,field,key,mod,debug,prow,pid', 'level' => 3),//父类id获取子集（直接数据库查询信息）
        
        'field' => array('attr' => 'name,module,pk,id,field,debug', 'close'=>0),//获取指定字段的值（主键）
        'value' => array('attr' => 'name,module,where,id,field,debug', 'close'=>0),//获取指定字段的值(条件)
    );

    /**
    * 获取列表(调用model中的lists方法)
    * @author liym <yanming.li1@pactera.com>
    * @version 0.0.0.1
    * @todo 2016.08.18
    */
    public function _list($attr, $content) {

        $this->cur_tag = 'list';
        
        //参数处理
        $this->attrCheck($attr);

        $parsestr = '<?php $m=D("' . $this->table_name . '");';
        $parsestr .= '$ret=$m->';
        if ($this->page) {
            $parsestr .= 'page(!empty($_GET["p"])?$_GET["p"]:1,' . $this->limit . ')->';
        }
        $parsestr .= 'lists("' . $this->where . '","' . $this->order . '","' . $this->field . '");';
        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        $parsestr .= $this->resultHtml('ret', $content);

        return $parsestr;
    }

    /**
    * 获取列表(直接查询)
    * @author liym <yanming.li1@pactera.com>
    * @version 0.0.0.1
    * @todo 2016.08.18
    */
    public function _query($attr, $content) {
        
        $this->cur_tag = 'query';
        
        //参数处理
        $this->attrCheck($attr);

        if ($this->sql) {
            $parsestr = '<?php $m=M();';
            if ($this->page) {
                $this->limit = $this->limit ? $this->limit : 10; //如果有page，没有输入limit则默认为10

                $parsestr .= '$count=count($m->query("' . $this->sql . '"));';
                $parsestr .= '$p = new Think\Page( $count, ' . $this->limit . ' );';
                $parsestr .= '$sql.="' . $this->sql . '";';
                $parsestr .= '$sql.=" limit ".$p->firstRow.",".$p->listRows."";';
                $parsestr .= '$ret=$m->query($sql);';
                $parsestr .= '$pages=$p->show();';
            } else {
                $this->sql .= $this->limit ? (' limit ' . $this->limit) : '';
                $parsestr .= '$ret=$m->query("' . $this->sql . '");';
            }
        } else {

            $parsestr = '<?php $m=M("' . $this->table_name . '");';
            if ($this->page) {
                $this->limit = $this->limit ? $this->limit : 10; //如果有page，没有输入limit则默认为10

                $parsestr .= '$count=$m->where("' . $this->where . '")->count();';
                $parsestr .= '$p = new Think\Page( $count, ' . $this->limit . ' );';
                $parsestr .= '$ret=$m->field("' . $this->field . '")->where("' . $this->where . '")->limit($p->firstRow.",".$p->listRows)->order("' . $this->order . '")->select();';
                $parsestr .= '$pages=$p->show();';
            } else {
                $parsestr .= '$ret=$m->field("' . $this->field . '")->where("' . $this->where . '")->order("' . $this->order . '")->limit("' . $this->limit . '")->select();';
            }
        }
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        $parsestr .= $this->resultHtml('ret', $content);
        return $parsestr;
    }
    
    /**
     * 父类id获取子集列表(调用model中category的方法)
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.22
     */
    public function _content($attr, $content) {
        
        $this->cur_tag = 'content';
        
        //参数处理
        $this->attrCheck($attr);
        
        $parsestr = '<?php $m=D("' . $this->table_name . '");';
        $parsestr .= '$ret=$m->';
        if ($this->page) {
            $parsestr .= 'page(!empty($_GET["p"])?$_GET["p"]:1,' . $this->limit . ')->';
        }

        $parsestr .= 'category("' . $this->where . '","' . $this->order . '","' . $this->field . '");';
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        $parsestr .= $this->resultHtml('ret', $content);

        return $parsestr;
    }

    /**
     * 父类id获取子集列表(直接查询)
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.22
     */
    public function _cate($attr, $content) {
        
        $this->cur_tag = 'cate';
        
        //参数处理
        $this->attrCheck($attr);
        
        
        $parsestr = '<?php $m=M("' . $this->table_name . '");';
        if ($this->page) {
            $this->limit = $this->limit ? $this->limit : 10; //如果有page，没有输入limit则默认为10

            $parsestr .= '$count=$m->where("' . $this->where . '")->count();';
            $parsestr .= '$p = new Think\Page( $count, ' . $this->limit . ' );';
            $parsestr .= '$ret=$m->field("' . $this->field . '")->where("' . $this->where . '")->limit($p->firstRow.",".$p->listRows)->order("' . $this->order . '")->select();';
            $parsestr .= '$pages=$p->show();';
        } else {
            $parsestr.='$ret=$m->field("' . $this->field . '")->where("' . $this->where . '")->order("' . $this->order . '")->limit("' . $this->limit . '")->select();';
        }
        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        $parsestr .= $this->resultHtml('ret', $content);
        return $parsestr;
    }
    
    /**
     * 主键获取详情(调用model中的detail方法)
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.18
     */
    public function _view($attr, $content) {
        $this->cur_tag = 'view';
        //参数处理
        $this->attrCheck($attr);
        
        $parsestr .= '<?php $m = D("' . $this->table_name . '");';
        $parsestr .= '$ret=$m->detail("' . $this->pk . '");';

        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        $parsestr .= $this->resultDetailHtml('ret', $content);
        return $parsestr;
    }

    /**
     * 主键获取详情(直接查询)
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.18
     */
    public function _find($attr, $content) {
        
        $this->cur_tag = 'find';
        
        //参数处理
        $this->attrCheck($attr);

        $parsestr = '<?php $m=M("' . $this->table_name . '");';
        $parsestr .= '$ret=$m->field("' . $this->field . '")->find(' . $this->pk . ');';
        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        
        $parsestr .= $this->resultDetailHtml('ret', $content);
        return $parsestr;
    }
    
    /**
     * 条件获取详情(直接查询)
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.18
     */
    public function _row($attr, $content) {
        
        $this->cur_tag = 'row';
        
        //参数处理
        $this->attrCheck($attr);

        $parsestr = '<?php $m=M("' . $this->table_name . '");';
        $parsestr .= '$ret=$m->field("' . $this->field . '")->where("'.$this->where.'")->find();';
        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('ret');
        }
        
        $parsestr .= $this->resultDetailHtml('ret', $content);
        return $parsestr;
    }
    
    /**
     * 主键获取指定字段的值
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.09.02
     */
    public function _field($attr) {
        
        $this->cur_tag = 'field';

        //参数处理
        $this->attrCheck($attr);

        $parsestr = '<?php $m=M("' . $this->table_name . '");';
        $parsestr .= '$detail=$m->find(' . $this->pk . ');';

        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('detail');
        }
        
        $parsestr .= 'if ($detail && isset($detail['.$this->field.'])): ';
        $parsestr .= ' echo  $detail['.$this->field.']; ?>';
        $parsestr .= '<?php endif;?>';
        return $parsestr;
    }
    
    /**
     * where获取制定字段的值
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.11.1
     */
    public function _value($attr) {
        
        $this->cur_tag = 'value';

        //参数处理
        $this->attrCheck($attr);

        $parsestr = '<?php $m=M("' . $this->table_name . '");';
        if($this->where){
            $parsestr .= '$detail=$m->field("'.$this->field.'")->where("'.$this->where.'")->find();';
}
        
        if ($this->debug != false) {
            $parsestr .= $this->tagDebug('detail');
        }
        
        $parsestr .= 'if ($detail && isset($detail["'.$this->field.'"])): ';
        $parsestr .= ' echo  $detail["'.$this->field.'"]; ?>';
        $parsestr .= '<?php endif;?>';
        return $parsestr;
    }
    
}
