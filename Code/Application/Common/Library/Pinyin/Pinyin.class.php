<?php
namespace COM\Pinyin;
class Pinyin {    
 var $_dat = 'py.dat';    
 var $_fd  = false;    
   
 function __construct($pdat = '') {    
  if ('' != $pdat)    
  $this->_dat = $pdat;    
  $this->_dat = dirname(__FILE__)."/".$this->_dat;
 }    
   
 function load($pdat = '') {    
  if ('' == $pdat)    
  $pdat = $this->_dat;    
  $this->unload();    
  $this->_fd = @fopen($pdat, 'rb');    
  if (!$this->_fd) {    
   trigger_error("unable to load PinYin data file `$pdat`", E_USER_WARNING);    
   return false;    
  }    
  return true;    
 }    
   
 function unload() {    
  if ($this->_fd) {    
   @fclose($this->_fd);    
   $this->_fd = false;    
  }    
 }    
   
 function get($zh) {    
  if (strlen($zh) != 2) {    
  	if(ord($zh)<=255){
		  return $zh;
	  }
   trigger_error("`$zh` is not a valid GBK hanzi", E_USER_WARNING);    
   return false;    
  }    
  if (!$this->_fd && !$this->load()) return false;    
  $high = ord($zh[0]) - 0x81;    
  $low  = ord($zh[1]) - 0x40;    
  // 计算偏移位置    
  //$nz = ($ord0 - 0x81);    
  $off = ($high<<8) + $low - ($high * 0x40);    
  // 判断 off 值    
  if ($off < 0) {    
   trigger_error("`$zh` is not a valid GBK hanzi-2", E_USER_WARNING);    
   return false;    
  }    
  fseek($this->_fd, $off * 8, SEEK_SET);    
  $ret = fread($this->_fd, 8);    
  $ret = unpack('a8py', $ret);    
  return $ret['py'];    
 }    
 
 function transform($str, $encode="UTF-8"){
 	if($encode == "UTF-8"){
 		$str = iconv("UTF-8", "GB18030", $str);
 	}
 	$ret = array();
 	$old_mb_encoding = mb_internal_encoding();
 	mb_internal_encoding("GBK");
 	for($i=0; $i<mb_strlen($str); $i++){
 		$char = mb_substr($str, $i, 1);
 		$ret[] = $this->get($char);
 	}
 	mb_internal_encoding($old_mb_encoding);
 	return $ret;
 }
 
 function transformInitialChar($str, $encode="UTF-8"){
 	if($encode == "UTF-8"){
 		$str = iconv("UTF-8", "GB18030", $str);
 	}
 	$ret = array();
 	$old_mb_encoding = mb_internal_encoding();
 	mb_internal_encoding("GBK");
 	for($i=0; $i<mb_strlen($str); $i++){
 		$char = mb_substr($str, $i, 1);
 		$pinyin = $this->get($char);
 		$ret[] = $pinyin[0];
 	}
 	mb_internal_encoding($old_mb_encoding);
 	return $ret;
 }
   
 function __destruct() {    
  $this->unload();    
 }    
} 

// $str = "中国";
// $p = new PinYin();
// $str = $p->transform($str);
// foreach($str as $key => $val){
// 	var_dump(substr($val, 0, -1));
// 	var_dump(substr($val, 0, 1));
// }
// var_dump($str);
//