<?php

/**
 * PacteraCMS
 * @author sunny5156  <137898350@qq.com>
 * @date 2015-8-26
 * @version
 */

namespace Manage\Controller;

use Think\Image;
use Think\Upload;

class PublicController extends CommonController {

    //根据后面实际需要 调整缩略图大小
    public function uploadify() {
        $model = I('get.model');
        $upload = new Upload(); // 
        $upload->rootPath = './Public/Uploads';
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir = '/attachs/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录
        if (isset($this->_CONFIG['attachs'][$model]['thumb'])) {
            $upload->thumb = true;
            if (is_array($this->_CONFIG['attachs'][$model]['thumb'])) {
                $prefix = $w = $h = array();
                foreach ($this->_CONFIG['attachs'][$model]['thumb'] as $k => $v) {
                    $prefix[] = $k . '_';
                    list($w1, $h1) = explode('X', $v);
                    $w[] = $w1;
                    $h[] = $h1;
                }
                $upload->thumbPrefix = join(',', $prefix);
                $upload->thumbMaxWidth = join(',', $w);
                $upload->thumbMaxHeight = join(',', $h);
            } else {
                $upload->thumbPrefix = 'thumb_';
                list($w, $h) = explode('X', $this->_CONFIG['attachs'][$model]['thumb']);
                $upload->thumbMaxWidth = $w;
                $upload->thumbMaxHeight = $h;
            }
        }
        if (!$info = $upload->upload()) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功 获取上传文件信息
            if (!empty($this->_CONFIG['attachs'][$model]['water'])) {
                //$Image = new Image();
                //$Image->water('/attachs/'. $name . '/thumb_' . $info[0]['savename'], '/attachs/'.$this->_CONFIG['attachs']['water']);
            }
            if ($upload->thumb) {
                echo $name . '/thumb_' . $info[0]['savename'];
            } else {
                echo $upload->rootPath . $info['savepath'] . $info['savename'];
            }
        }
    }

    public function editor() {
        $upload = new Upload(); // 
        $upload->rootPath = './Public/Uploads';
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir = '/attachs/editor/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录

        if (isset($this->_CONFIG['attachs']['editor']['thumb'])) {
            $upload->thumb = true;
            $upload->thumbType = 0; //不自动裁剪
            $upload->thumbPrefix = 'thumb_';
            list($w, $h) = explode('X', $this->_CONFIG['attachs']['editor']['thumb']);
            $upload->thumbMaxWidth = $w;
            $upload->thumbMaxHeight = $h;
        }
        if (!$info = $upload->upload()) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功 获取上传文件信息
            //$info = $upload->getUploadFileInfo();
            if (!empty($this->_CONFIG['attachs']['editor']['water'])) {
                import('ORG.Util.Image');
                //$Image = new Image();
                //$Image->water( '/attachs/editor/'. $name . '/thumb_' . $info[0]['savename'],'/attachs/'.$this->_CONFIG['attachs']['water']);
            }
            sort($info);
            $return = array(
                'url' => $upload->rootPath . $info[0]['savepath'] . $info[0]['savename'],
                'originalName' => $info[0]['name'],
                'name' => $info[0]['savename'],
                'state' => 'SUCCESS',
                'size' => $info[0]['size'],
                'type' => $info[0]['ext'],
            );
            echo json_encode($return);
        }
    }

    public function maps() {
        $lat = I('get.lat', '', 'htmlspecialchars');
        $lng = I('get.lng', '', 'htmlspecialchars');

        $this->assign('lat', $lat ? $lat : $this->_CONFIG['site']['lat']);
        $this->assign('lng', $lng ? $lng : $this->_CONFIG['site']['lng']);
        $this->display();
    }

}
