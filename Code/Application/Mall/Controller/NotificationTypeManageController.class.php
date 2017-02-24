<?php
namespace Mall\Controller;

/**
 * Class NotificationTypeManageController
 *
 * @package Mall\Controller
 */
class NotificationTypeManageController extends ManageBaseController
{

    /**
     * This is the message setting page
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $model = D('NotificationType');
        $list = $model->search(I());
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage()
        ));
        $this->display();
    }

    /**
     * This is the message form page
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param null $id
     */
    public function form($id = null)
    {
        $data = array();
        if ($id) {
            $data = D('NotificationType')->find($id);
        }
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * This is the save data action
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function save()
    {
        if (IS_POST) {
            $model = D('NotificationType');
            if ($model->create()) {
                if ($model->id && $model->save()) {
                    $this->simpleSuccess('更新成功！', U('index'));
                }
                if (!$model->id && $model->add()) {
                    $this->simpleSuccess('添加成功！', U('index'));
                }
            }
            $this->error($model->getError());
        }
    }

    /**
     * This is the change data status action
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $id
     */
    public function change($id)
    {
        $model = D('NotificationType');
        $data = $model->find($id);
        $data['status'] = $data['status'] ? 0 : 1;
        if ($model->save($data)) {
            $this->ajaxReturn(array('status' => true));
        } else {
            $this->ajaxReturn(array('status' => false));
        }
    }

    /**
     * This is the delete data action
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $id
     */
    public function delete($id)
    {
        $model = D('NotificationType');
        $data = $model->find($id);
        $data['is_del'] = true;
        if ($model->save($data)) {
            $this->ajaxReturn(array('status' => true));
        } else {
            $this->ajaxReturn(array('status' => false));
        }
    }

    /**
     * This is the batch delete action
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function batchdel()
    {
        if (I('post.ids')) {
            $where['id'] = I('post.ids');
            $data = array_map(function () {
                return array('is_del' => 1);
            }, I('post.ids'));
            $res = D('NotificationType')->saveAll($where, $data);
            if (count($res['id']) > 0) {
                $this->ajaxReturn(array('status' => true));
            } else {
                $this->ajaxReturn(array('status' => false));
            }
        }
    }

}
