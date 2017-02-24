<?php
/**
 * 钩子
 * @author Kevin_ren <330202207@qq.com>
 * @date 2016/8/19
 * @version 1.0
 */
 

namespace Manage\Controller;


class HooksController extends CommonController
{

    /**
     * 钩子列表
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function index()
    {
        $map     = '';
        $keyword = I("keyword");

        if ($keyword != '') {
            $map['name'] = array('like', '%'.$keyword.'%');
        }

        $list = $this->lists(D('SystemHooks'), $map);
        $list = conversion_data($list, array('type' => array('1' => '视图', '2' => '控制器')));
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 分页
     * @author Kevin_ren  <330202207@qq.com>
     */
    protected function lists($model, $where = array(), $order = '', $base = array('is_del' => array('eq', 0)))
    {
        $options = array();
        if (is_string($model)) {
            $model = M($model);
        }
        $pk = $model->getPk();
        if (empty($order)) {
            $order = $pk . ' desc';
        }
        $options['where'] = array_filter(array_merge($base, $where), function ($val) {
            if ($val === '' || $val === null) {
                return false;
            } else {
                return true;
            }
        });
        if (empty($where)) {
            $options['where'] =  $base;
        }
        $total = $model->where($options['where'])->count();
        $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        $page = new \Think\Page($total, $listRows, $options);

        if ($total > $listRows) {
            $page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }

        $show = $page->show();
        $this->assign('page', $show);
        $this->assign('_total', $total);
        $limit = $page->firstRow . ',' . $page->listRows;
        return $model->where($options['where'])->order($order)->limit($limit)->select();
    }

    /**
     * 新增钩子
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function add()
    {
        $this->assign('data', null);
        $this->display('save');
    }

    /**
     * 编辑钩子
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function edit($id)
    {
        $data  = M('SystemHooks')->where(array('id' => $id))->find();
        $this->assign('data', $data);
        $this->display('save');
    }

    /**
     * 保存钩子
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function save()
    {
        $Model = D('SystemHooks');
        $data  = $Model->saveData();
        if ($data !== false) {
            $this->simpleSuccess('保存成功', U('index'));
        } else {
            $this->simpleError($Model->getError());
        }
    }

    /**
     * 删除钩子
     */
    public function delete($id)
    {
        if (M('SystemHooks')->delete($id) !== false) {
            $this->simpleSuccess("删除成功", U('index'));
        } else {
            $this->simpleError("删除失败");
        }
    }
} 