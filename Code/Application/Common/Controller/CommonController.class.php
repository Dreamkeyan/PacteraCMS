<?php
namespace Common\Controller;

use Think\Controller;
use Common\Library\Cloud\CloudFile;
use Think\Upload;

class CommonController extends Controller
{


    /**
     * 公共上传
     * @author Kevin_ren  <330202207@qq.com>
     */
    public function uploadFile()
    {

        $type     = I("post.file_type");
        $isRemote = I("post.is_remote");
        $saveDir  = I('post.saveDir');
        switch ($type)
        {
            case 'img' :
                $this->uploadImages($isRemote, $saveDir);
                break;
            case 'import' :
                $this->importExcel($isRemote, $saveDir);
                break;
        }
    }

    /**
     * 上传图片
     * @author Kevin_ren  <330202207@qq.com>
     * @param boolean $isRemote  是否远程上传
     * @param string $saveDir  上传文件夹名称
     * @return array
     */
    public function uploadImages($isRemote, $saveDir)
    {
        $dir = "./Attachment/". MODULE_NAME ."/Uploads";
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $config = array(
            'maxSize'   => 2 * 1024 * 1024,
            'rootPath'  => PACTERA_ROOT,
            'savePath'  => "./Attachment/". MODULE_NAME ."/". $saveDir. '/',
            'allowExts' => array('jpg', 'gif', 'png', 'jpeg')
        );

        if ($isRemote != true) {
            $upload = new Upload($config);
        } else {
            $upload = new CloudFile($config);
        }

        $info = $upload->upload();

        if (empty($info)) {
            $res = array(
                'errCode' => 0,
                'errMsg'  => $upload->getError()
            );
            $this->ajaxReturn($res);
        } else {
            $res = array(
                'errCode' => 1,
                'errMsg'  => '上传成功'
            );

            if ($isRemote != true) {
                $res['path'] = PACTERA_ROOT . $info['file']['savepath'] . $info['file']['savename'];
            } else {
                $res['path'] = $info[0]['savepath'];
            }

            $this->ajaxReturn($res);
        }
    }

    /**
     * 上传Excel
     * @author Kevin_ren  <330202207@qq.com>
     * @param boolean $isRemote  是否远程上传
     * @param string $saveDir  上传文件夹名称
     * @return array
     */
    public function importExcel($isRemote, $saveDir)
    {

        $dir = "./Attachment/". MODULE_NAME ."/Uploads";

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $config = array(
            'rootPath'  => PACTERA_ROOT,
            'savePath'  => "./Attachment/". MODULE_NAME ."/". $saveDir. '/',
            'allowExts' => array('xls', 'xlsx')
        );
        if ($isRemote) {
            $upload = new CloudFile($config);
        } else {
            $upload = new Upload($config);
        }

        $info = $upload->upload();

        $res = array(
            'errCode' => 1,
            'errMsg'  => '上传成功'
        );
        if($isRemote){
            if(empty($info[0])){
                $res = array(
                    'errCode' => 0,
                    'errMsg'  => $upload->getError()
                );
            }else{
                $res['path'] = $info[0]['savepath'].$info[0]['extension'];
            }
        }else{
            if(empty($info['file'])){
                $res = array(
                    'errCode' => 0,
                    'errMsg'  => $upload->getError()
                );
            }else{
                $res['path'] = $info['file']['savepath'].$info['file']['savename'];
            }
        }
        $this->ajaxReturn($res);


    }

    /**
     * base64Upload
     * @author sunny5156  <137898350@qq.com>
     */
    public function base64Upload(){
        $mime = array(
            'image/png' => '.png',
            'image/jpg' => '.jpg',
            'image/jpeg' => '.jpg',
            'image/pjpeg' => '.jpg',
            'image/gif' => '.gif',
            'image/bmp' => '.bmp',
            'image/x-png' => '.png',
        );
        $base64 = $_POST['base64'];
        $type = $_POST['type'];
        $imgtype = $mime[$type];
        $dir = '';
        if($imgtype){
            preg_match('/(.*)base64,(.*)/', $base64, $matches);
            $base64 = $matches['2'];
            $base64 = base64_decode($base64);
            $data = date("Y-m-d");
            $imgname = md5(time().rand(10000,99999));
            $imgurl = "./Attachment/" . MODULE_NAME."/Avatar/".$data."/";
            if (!is_dir($dir.$imgurl)) {
                mkdir($dir.$imgurl, 0755, true);
            }
            $imgurl .= $imgname.$imgtype;
            $imgurlname = $data.'/'.$imgname.$imgtype;
            $ress = file_put_contents($dir.$imgurl,$base64);
            if($ress){
                $res['errCode'] = 1;
                $res['path'] = $imgurl;
            }else{
                $res['errCode'] = 0;
                $res['errMsg'] = '上传图片错误，请检查文件夹权限';
            }
        }else{
            $res['errCode'] = 0;
            $res['errMsg'] = '格式错误';
        }
        $this->ajaxReturn($res);
    }

    protected function checkFields($data = array(), $fields = array())
    {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    protected function ipToArea($_ip)
    {
        return ip_to_area($_ip);
    }
}