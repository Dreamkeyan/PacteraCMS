<?php

/**
 * 文件上传类
 * @category   COM.Cloud
 * @package  COM.Cloud
 * @subpackage  Cloud
 * @author    Wang13 <imanbian@gmail.com>
 */
namespace Common\Library\Cloud;
ini_set("max_execution_time", 0);
class FastDFS { // 类定义开始	private $config = array ('maxSize' => - 1, 'supportMulti' => true, 'allowExts' => array (), 'allowTypes' => array (), 'zipImages' => false, 'autoCheck' => true, 'uploadFileInfoOfKey' => false );
	
	public function uploadFileInfoOfKey($_f = true) {
		$this->uploadFileInfoOfKey = $_f;
	}
	
	public function setImagesConfig() {
		$this->maxSize = 1024 * 1024;
		$this->allowExts = array ('jpg', 'gif', 'png', 'jpeg','mp3','mp4','m4a');
	}
	
	// 错误信息	private $error = '';
	
	//远程服务器端	private $Imagehost = array ();
	
	// 上传成功的文件信息	private $uploadFileInfo;
	public function __get($name) {
		if (isset ( $this->config [$name] )) {
			return $this->config [$name];
		}
		return null;
	}
	public function __set($name, $value) {
		if (isset ( $this->config [$name] )) {
			$this->config [$name] = $value;
		}
	}
	public function __isset($name) {
		return isset ( $this->config [$name] );
	}
	
	/**	 * 转换上传文件数组变量为正确的方式	 *	 * @access private	 * @param array $files	 * 上传的文件变量	 * @return array	 */
	private function dealFiles($files) {
		$fileArray = array ();
		$n = 0;
		foreach ( $files as $key => $file ) {
			if (is_array ( $file ['name'] )) {
				$keys = array_keys ( $file );
				$count = count ( $file ['name'] );
				for($i = 0; $i < $count; $i ++) {
					$fileArray [$n] ['key'] = $key;
					foreach ( $keys as $_key ) {
						$fileArray [$n] [$_key] = $file [$_key] [$i];
					}
					$n ++;
				}
			} else {
				$fileArray [$key] = $file;
			}
		}
		return $fileArray;
	}
	
	/**	 * 架构函数	 *	 * @access public	 * @param array $config	 * 上传参数	 */
	public function __construct($config = array()) {
		if (is_array ( $config )) {
			$this->config = array_merge ( $this->config, $config );
		}
		
		$this->Imagehost = include C ( "CONF.IMGHOST" );
	}
	
	private function getImgHost() {
		return $this->Imagehost [array_rand ( $this->Imagehost )];
	}
	
	static public function getStaticFile($localpath) {
		return array ('tmp_name' => $localpath );
	}
	
	static public function unLocalFile($localfile) {
		if (is_file ( $localfile ))
			return unlink ( $localfile );
		return false;
	}
	
	public function save($file) {
		//获取ext
		$pathinfo = pathinfo ( $file['name'] );
		//获取ext
// 		$imgHost = "http://" . $this->getImgHost () . "/upload.php?ext=".$pathinfo['extension'];
// 		$imgHost = "http://192.168.2.191/upload.php?ext=".$pathinfo['extension'];
		$imgHost = "http://192.168.2.191/fastdfs_php_demo/upload.php";
		$datas = fopen ( $file ['tmp_name'], 'r' );

		
		//////////////////////////////////////////
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
		curl_close($ch);
		//////////////////////////////////////////
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $imgHost);
// 		$headers = array ('Expect:' );
		
		if (is_resource ( $datas )) {
			fseek ( $datas, 0, SEEK_END );
			$length = ftell ( $datas );
			fseek ( $datas, 0 );
// 			$headers [] = 'Content-Length: ' . $length;
			curl_setopt ( $ch, CURLOPT_INFILE, $datas );
			curl_setopt ( $ch, CURLOPT_INFILESIZE, $length );
		}
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
// 		curl_setopt($ch, CURLOPT_INFILE, $datas );
// 		$date = gmdate ( 'D, d M Y H:i:s \G\M\T' );
		
// 		$headers [] = "Date: {$date}";
// 		$headers [] = 'Authorization: ';
// 		$headers [] = 'Content-Type: ';
// 		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
// 		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
// 		curl_setopt ( $ch, CURLOPT_TIMEOUT, 300 );
// 		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		
		
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		exit;
		
// 		$exec = curl_exec ( $process );
// 		$getinfo = curl_getinfo ( $process );
// 		curl_close ( $process );
// 		fclose ( $datas );
		if ($getinfo ['http_code'] == 200) {
			$josn = json_decode ( strval ( $exec ), 1 );
		
			return str_ireplace ( "\\", "/", $josn ['http'] );
		} else {
			
			$this->error = $getinfo ['http_code'];
			return false;
		}
	
	}
	public function upload($savePath = '') {
		$fileInfo = array ();
		$isUpload = false;
		
		// // 获取上传的文件信息		// // 对$_FILES数组信息处理		$files = $this->dealFiles ( $_FILES );
		
		$isUpload = true;
		foreach ( $files as $key => $file ) {
			// 过滤无效的上传			if ($isUpload) {
				if (! empty ( $file ['name'] )) {
					if (! empty ( $file ['name'] )) {
						// 登记上传文件的扩展信息						if (! isset ( $file ['key'] ))
							$file ['key'] = $key;
							$file ['extension'] = $this->getExt ( $file ['name'] );
						
						// 自动检查附件						if ($this->autoCheck) {
							if (! $this->check ( $file )) {
								$isUpload = false;
							}
						}
						
						if ($isUpload) {
							$http_file = $this->save ( $file );
							if ($http_file != false) {
								$file ['savepath'] = $http_file;
								unset ( $file ['tmp_name'], $file ['error'] );
								if ($this->uploadFileInfoOfKey) {
									$fileInfo [$file ['key']] = $file;
								} else {
									$fileInfo [] = $file;
								}
							
							} else {
								$isUpload = false;
							}
						}
					
					}
				}
			}
		}
		
		if ($isUpload) {
			$this->uploadFileInfo = $fileInfo;
			return true;
		} else {
			// 			$this->error = '没有选择上传文件';			return false;
		}
	}
	/**	 * 获取错误代码信息	 * 	 * @access public	 * @param string $errorNo	 * 错误号码	 * @return void	 */
	protected function error($errorNo) {
		switch ($errorNo) {
			case 1 :
				$this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
			case 2 :
				$this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;
			case 3 :
				$this->error = '文件只有部分被上传';
				break;
			case 4 :
				$this->error = '没有文件被上传';
				break;
			case 6 :
				$this->error = '找不到临时文件夹';
				break;
			case 7 :
				$this->error = '文件写入失败';
				break;
			default :
				$this->error = '未知上传错误！';
		}
		return;
	}
	
	/**	 * 检查上传的文件	 *	 * @access private	 * @param array $file	 * 文件信息	 * @return boolean	 */
	private function check($file) {
		if ($file ['error'] !== 0) {
			// 文件上传失败			// 捕获错误代码			$this->error ( $file ['error'] );
			return false;
		}
		// 文件上传成功，进行自定义规则检查		// 检查文件大小		if (! $this->checkSize ( $file ['size'] )) {
			$this->error = '上传文件大小不符！';
			return false;
		}
		
		// 检查文件Mime类型		if (! $this->checkType ( $file ['type'] )) {
			$this->error = '上传文件MIME类型不允许！';
			return false;
		}
		// 检查文件类型		if (! $this->checkExt ( $file ['extension'] )) {
			$this->error = '上传文件类型不允许';
			return false;
		}
		
		return true;
	}
	
	/**	 * 检查上传的文件类型是否合法	 *	 * @access private	 * @param string $type	 * 数据	 * @return boolean	 */
	private function checkType($type) {
		if (! empty ( $this->allowTypes ))
			return in_array ( strtolower ( $type ), $this->allowTypes );
		return true;
	}
	
	/**	 * 检查上传的文件后缀是否合法	 *	 * @access private	 * @param string $ext	 * 后缀名	 * @return boolean	 */
	private function checkExt($ext) {
		if (! empty ( $this->allowExts ))
			return in_array ( strtolower ( $ext ), $this->allowExts, true );
		
		return true;
	}
	
	/**	 * 检查文件大小是否合法	 *	 * @access private	 * @param integer $size	 * 数据	 * @return boolean	 */
	private function checkSize($size) {
		return ! ($size > $this->maxSize) || (- 1 == $this->maxSize);
	}
	/**	 * 取得上传文件的后缀	 *	 * @access private	 * @param string $filename	 * 文件名	 * @return boolean	 */
	private function getExt($filename) {
		$pathinfo = pathinfo ( $filename );
		return $pathinfo ['extension'];
	}
	/**	 * 取得上传文件的信息	 *	 * @access public	 * @return array	 */
	public function getUploadFileInfo() {
		return $this->uploadFileInfo;
	}
	
	/**	 * 取得最后一次错误信息	 *	 * @access public	 * @return string	 */
	public function getErrorMsg() {
		return $this->error;
	}
}