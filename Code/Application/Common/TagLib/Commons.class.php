<?php

/**
 * 自定义标签基本方法
 * @author liym <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @todo 2016.08.18
 */

namespace Common\TagLib;

use Think\Template\TagLib;

class Commons extends TagLib {
    
    protected $default_model = '';//默认模块
    protected $module = '';//模块
    
    protected $name = '';//表name
    protected $table_name = '';//执行表名称
    
    protected $field = '';//字段
    protected $pk = '';//主键
    protected $prow = '';//父类字段(标记字段)
    protected $pid = '';//父类指定的值(标记字段的指定的值)
    protected $where = '';//查询条件
    protected $page = '';//分页开启
    protected $order = '';//排序
    protected $limit = '';//限制
    
    protected $id = '';//结果变量
    protected $key = '';//循环变量
    protected $mod = '';//取模
    
    protected $sql = '';//sql语句
    protected $debug = '';//是否调试
    
    protected $cur_tag = '';//当前的标签


    public function __construct() {
        parent::__construct();
        $this->default_module = ucwords(MODULE_NAME);
    }
    
    /**
     * 标签属性的处理
     * @param array $attr 标签获取的属性列表
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    public function attrCheck($attr) {

        $tag = $this->checkFields($attr, explode(',', $this->tags[$this->cur_tag]['attr']));
        
        $this->module = isset($tag['module']) && !empty($tag['module']) ? $tag['module'] : '';

        $this->name = isset($tag['name']) && !empty($tag['name']) ? ucwords($tag['name']) : '';

        $this->table_name = ($this->module ? ucwords($this->module) : $this->default_module) . ($this->name);

        $this->field = isset($tag['field']) && !empty($tag['field']) ? $tag['field'] : TRUE;
        $this->pk = isset($tag['pk']) && !empty($tag['pk']) ? $tag['pk'] : 0;
        $this->prow = isset($tag['prow']) && !empty($tag['prow']) ? $tag['prow'] : '';
        $this->pid = isset($tag['pid']) && !empty($tag['pid']) ? $tag['pid'] : 0;
        $this->where = isset($tag['where']) && !empty($tag['where']) ? $tag['where'] : ' 1 ';
        $this->page = isset($tag['page']) && !empty($tag['page']) ? $tag['page'] : false;
        $this->order = isset($tag['order']) && !empty($tag['order']) ? $tag['order'] : '';
        $this->limit = isset($tag['limit']) && !empty($tag['limit']) ? intval($tag['limit']) : 10;

        $this->id = isset($tag['id']) && !empty($tag['id']) ? $tag['id'] : 'r';
        $this->key = isset($tag['key']) && !empty($tag['key']) ? $tag['key'] : 'i';
        $this->mod = isset($tag['mod']) && !empty($tag['mod']) ? $tag['mod'] : '2';

        $this->sql = isset($tag['sql']) && !empty($tag['sql']) ? $tag['sql'] : '';
        $this->field = isset($tag['field']) && !empty($tag['field']) ? $tag['field'] : '';
        $this->debug = isset($tag['debug']) && !empty($tag['debug']) ? $tag['debug'] : false;

        $this->comparison['noteq'] = '<>';
        $this->comparison['sqleq'] = '=';
        $this->where .=!empty($this->prow) ? ' and ' . $this->prow . '=' . $this->pid : '';
        $this->where = $this->parseCondition($this->where);
    }
    
    /**
     * 标签定义attr和标签获取属性的检测
     * @param array $data 标签获取的属性列表
     * @param array $fields 标签定义的字段列表
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function checkFields($data = array(), $fields = array())
    {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }
    
    /**
     * 标签的调试模式
     * @param str $result 结果变量的名称字符串
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function tagDebug($result)
    {
        $str = 'dump($'.$result.');dump($m->getLastSql());';
        return $str;
    }
    
    /**
     * 二维数组的结果document结构的拼装
     * @param str $result 结果变量的名称
     * @param str $content  document结构内容
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function resultHtml($result, $content) {
        $str = 'if ($'.$result.'): $' . $this->key . '=0;';
        $str .= 'foreach($'.$result.' as $key=>$' . $this->id . '):';
        $str .= '++$' . $this->key . ';$mod = ($' . $this->key . ' % ' . $this->mod . ' );?>';
        $str .= $this->tpl->parse($content);
        $str .= '<?php endforeach;endif;?>';
        return $str;
    }
    
    /**
     * 二维数组的结果document结构的拼装
     * @param str $result 结果变量的名称
     * @param str $content  document结构内容
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function resultHtmlByKey($result, $content) {
        $parsestr = 'if ($'.$result.'): ';
        $parsestr .= 'foreach ($'.$result.' as $one):';
        $parsestr .= 'extract($one);';
        $parsestr .= '?>';
        $parsestr .= $content;
        $parsestr .= '<?php endforeach;endif; ?>';
        return $parsestr;
    }
    
    /**
     * 一位数组结果document结构的拼装
     * @param str $result 结果变量的名称
     * @param str $content  document结构内容
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function resultDetailHtml($result, $content) {
        
        $str = '$' . $this->id . ' = $'.$result.';?> ';
        $str .= $this->tpl->parse($content);
        return $str;
    }
    
    /**
     * 一位数组结果document结构的拼装
     * @param str $result 结果变量的名称
     * @param str $content  document结构内容
     * @author liym <yanming.li1@pactera.com>
     * @version 0.0.0.1
     * @todo 2016.08.25
     */
    protected function resultDetailHtmlByKey($result, $content) {
        $parsestr = 'if ($'.$result.'):';
        $parsestr .= 'extract($'.$result.');';
        $parsestr .= '?>'; //自定义文章生成路径$url
        $parsestr .= '<?php else: ?>';
        $parsestr .= $this->tpl->parse($content);
        $parsestr .= '<?php endif;?>';
        return $parsestr;
    }
    
}

?>