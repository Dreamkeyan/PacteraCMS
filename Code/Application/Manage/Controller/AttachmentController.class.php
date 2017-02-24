<?php

namespace Manage\Controller;

use Think\Upload;
use Think\Image;

class AttachmentController extends CommonController {

    public function uploadFile() {
        $model = I('get.model');
        if ($model == 'import') {
            $config = array(
                'rootPath' => ROOT_DIR,
                'savePath' => '/Public/Uploads/',
                'allowExts' => array('xls', 'xlsx')
            );
        } else {
            $config = array(
                'maxSize' => 2 * 1024 * 1024,
                'rootPath' => ROOT_DIR,
                'savePath' => '/Public/Uploads/',
                'allowExts' => array('jpg', 'gif', 'png', 'jpeg')
            );
        }

        $upload = new Upload($config); //
        $info = $upload->upload();

        if (empty($info)) { // 上传错误提示错误信息
            $res = array('errcode' => 0, 'errmsg' => $upload->getError());
            $this->ajaxReturn($res);
        } else { // 上传成功 获取上传文件信息
            if (!empty($this->_CONFIG['attachs'][$model]['thumb'])) {
                list($w1, $h1) = explode('X', $this->_CONFIG['attachs'][$model]['thumb']);
                $thumbWidth = $w1;
                $thumbHeight = $h1;
            }
            $prefix = '';
            if ($thumbHeight && $thumbWidth) {
                $prefix = 'thumb_';
                foreach ($info as $v) {
                    // 生成缩略图
                    $image = new Image();
                    $image->open(ROOT_DIR . $v['savepath'] . $v['savename']);

                    // 生成一个居中裁剪为150*150的缩略图并保存为thumb.jpg
                    $image->thumb($thumbWidth, $thumbHeight, \Think\Image::IMAGE_THUMB_CENTER)->save(ROOT_DIR . $v['savepath'] . 'thumb_' . $v['savename']);
                    // 生成缩略图
                }
            }
            $path = "." . $info['Filedata']['savepath'] . $prefix . $info['Filedata']['savename'];
            $res = array('errcode' => 1, 'path' => $path);
            $this->ajaxReturn($res);
        }
    }

}
