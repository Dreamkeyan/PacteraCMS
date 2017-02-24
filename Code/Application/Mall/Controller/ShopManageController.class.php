<?php
namespace Mall\Controller;

use Mall\Service\ShopService;

/**
 * Class ShopManageController
 *
 * @package Mall\Controller
 */
class ShopManageController extends ManageBaseController
{

    /**
     * Shop manage list page
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function index()
    {
        $model = D('Shop');
        $list = $model->search(I());
        $this->assign(array(
            'list' => $list,
            'page' => $model->getPage(),
        ));
        $this->display();
    }

    /**
     * This is the shop detail page
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $shop_id
     */
    public function detail($shop_id)
    {
        $shop = D('Shop')->find($shop_id);
        $memberid = $shop['member_id'];
        $shops = D('Shop')->getListByMember($memberid);
        $shoptabs = ShopService::transTabs($shop_id, $shops);
        $this->assign(array(
            'memberid' => $memberid,
            'shoptabs' => $shoptabs,
        ));
        $this->display();
    }


    /**
     * Get the goods list table
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $shop_id
     */
    public function goodstable($shop_id)
    {
        $model = D('Goods');
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
     */
    public function form()
    {
        if (I('id')) {
            $data = D('Shop')->find(I('id'));
        }
        if (I('member_id')) {
            $member = D('Member')->find(I('member_id'));
        }
        $cates = D('Category')->getByPid();
        // members
        $members = D('Member')->select();
        // render
        $this->assign(array(
            'members' => $members,
            'data' => $data,
            'member' => $member,
            'cates' => $cates,
        ));
        $this->display();
    }

    /**
     * Save shop info
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function save()
    {
        $model = D('Shop');
        if ($model->create()) {
            if ($model->id) {
                $model->save();
            } else {
                $model->add();
            }
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

    /**
     * This is the open shop action
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $shop_id
     */
    public function open($shop_id)
    {
        $model = D('Shop');
        $model->find($shop_id);
        $model->status = 1;
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

    /**
     * close the shop
     *
     * @param $shop_id
     */
    public function close($shop_id)
    {
        $model = D('Shop');
        $model->find($shop_id);
        $model->status = 0;
        if ($model->save()) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

    /**
     * Delete one shop
     *
     * @author chaimao <mao.chai@pactera.com>
     *
     * @param $id
     */
    public function delete($id)
    {
        $model = D('Shop');
        $data = $model->find($id);
        $data['is_del'] = '-1';
        if ($model->save($data)) {
            $this->ajaxReturn(array('status' => 'success'));
        } else {
            $this->ajaxReturn(array('status' => 'error'));
        }
    }

    /**
     * Batch delete shops
     *
     * @author chaimao <mao.chai@pactera.com>
     */
    public function batchdel()
    {
        if (I('post.ids')) {
            $where['id'] = I('post.ids');
            $data = array_map(function () {
                return array('is_del' => -1);
            }, I('post.ids'));
            $res = D('Shop')->saveAll($where, $data);
            if (count($res['id']) > 0) {
                $this->ajaxReturn(array('status' => true));
            } else {
                $this->ajaxReturn(array('status' => false));
            }
        }
    }

    /**
     * get shops by member number
     *
     * @param $num
     */
    public function getShopsByMemberNum($num)
    {
        $member = D('Member')->getByNumber($num);
        if ($member) {
            $shops = D('Shop')->getListByMember($member['id']);
        }
        $data = $shops ? $shops : array();
        $this->ajaxReturn($data);
    }

}