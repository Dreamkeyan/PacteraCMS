<?php
namespace Common\Library\Cloud;
class CurlForm
{
	private $remoteUrl;
	private $postvars = array();
	private $allowExts = array ('jpg', 'gif', 'png', 'jpeg','bmp','doc','docx','xls','xlsx','ppt','pptx','pdf','txt','rtf','rar','zip','gz','7z' );
	private $maxSize = 10485760;//10M
	public function __construct($remoteUrl)
	{
		$this->remoteUrl = $remoteUrl;
	}

	public function upload(){
		$isUpload = false;

		if(isset($_POST))
		{
			foreach ($_POST as $var => $val)
			{
				$this->postvars[$var] = $val;
			}
		}

		if(isset($_FILES))
		{
			foreach ($_FILES as $var => $val)
			{
				if (is_array($val['tmp_name']))
				{
					foreach ($val['tmp_name'] as $k=>$fname)
					{
						$this->postvars[$var."[$k]"]= "@".$fname;
						$this->postvars['filename']=  $val['name'][$k];
						$this->postvars['fileext']=  $this->getExt ($val['name'][$k]);
						$this->postvars['filesize']=  $val['size'][$k];
						$this->postvars['filetype']=  $val['type'][$k];
					}
				}
				else
				{
					$this->postvars[$var] = "@".$val['tmp_name'];
					$this->postvars['filename'] = $val['name'];
					$this->postvars['fileext']=  $this->getExt ($val['name']);
					$this->postvars['filesize']=  $val['size'];
				}
			}
			$isUpload = true;
		}
		$returnjoin = $this->resultReturn(0);
		if($isUpload){
			if(!$this->checkExt($this->postvars['fileext'])){
				$returnjoin = $this->resultReturn(0,'不支持上传该类型文件');
				return $returnjoin;
			}
			if(!$this->checkSize($this->postvars['filesize'])){
				$returnjoin = $this->resultReturn(0,'上传文件大小超过10M');
				return $returnjoin;
			}
			
			$uploadinfo = json_decode($this->post());
			$uploadinfo = $this->object_to_array($uploadinfo);
			$uploadinfo['name'] = $this->postvars['filename'];
			$uploadinfo['filesize'] = $this->postvars['filesize'];
			$uploadinfo['filetype'] = $this->postvars['filetype'];
			$returnjoin = $this->resultReturn(1,'上传成功',$uploadinfo);
			return $returnjoin;
		}
		else{
			$returnjoin = $this->resultReturn(0,'上传失败',$uploadinfo);
			return $returnjoin;
		}
	}

	public function post()
	{
		set_time_limit(0);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->remoteUrl );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postvars);
		$info = curl_exec($ch);
		//curl_errno($ch) && die(curl_error($ch));
		curl_close($ch);
		return $info;
		exit();
	}
	
	/**
	 * 检查上传的文件后缀是否合法
	 *
	 * @access private
	 * @param string $ext
	 * 后缀名
	 * @return boolean
	 */
	private function checkExt($ext) {
		if (! empty ( $this->allowExts ))
			return in_array ( strtolower ( $ext ), $this->allowExts, true );
		
		return true;
	}
	
	/**
	 * 检查文件大小是否合法
	 *
	 * @access private
	 * @param integer $size
	 * 数据
	 * @return boolean
	 */
	private function checkSize($size) {
		return ! ($size > $this->maxSize) || (- 1 == $this->maxSize);
	}

	/**
	 * 取得上传文件的后缀
	 *
	 * @access private
	 * @param string $filename
	 * 文件名
	 * @return boolean
	 */
	private function getExt($filename) {
		$pathinfo = pathinfo ( $filename );
		return $pathinfo ['extension'];
	}

	public function resultReturn($status=1,$info="",$data="")
	{
	  $result=array();
	  $result['status']  =  $status;
	  $result['info']    =  $info;
	  $result['data']    =  $data;
	  return $result;
	}

	function object_to_array($obj){
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val){
			$val=(is_array($val)) || is_object($val) ? object_to_array($val) :$val;
			$arr[$key] = $val;
		}
		return $arr; 
	}
}
?>