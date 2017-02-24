<?php

use Org\Net\IpLocation;
use Common\Library\phpqrcode\QRcode;

/**
 * 公共函数
 */

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author sunny5156 <137898350@qq.com>
 */
function is_login($loginUser){
	$user = session('user_auth');
	if (empty($user)) {
		return 0;
	} else {
// 		return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
		if(empty($loginUser))$loginUser = session('login_user');
		return 1; 
	}
}

/**
 * 查找当前节点的所有子节点
 * @param            $src_arr
 * @param            $currentId
 * @param bool|false $parentFound
 * @param array      $cats
 *
 * @author 祝海亮 <liangh.zhu@gmail.com>
 *
 * @return array
 */
function getChildrenNode($src_arr, $currentId, $parentFound = false, $cats = array())
{
	foreach($src_arr as $row)
	{
		if((!$parentFound && $row['id'] == $currentId) || $row['parent_id'] == $currentId)
		{
			$rowData = array();
			foreach($row as $k => $v) {
				$rowData[$k] = $v;
			}
			$cats[] = $rowData;
			if($row['parent_id'] == $currentId) {
				$cats = array_merge($cats, getChildrenNode($src_arr, $row['id'], true));
			}
		}
	}
	return $cats;
}

/**
 * 构造树型结构数据
 * @param       $src_arr
 * @param int   $parent_id
 * @param array $tree
 *
 * @author 祝海亮 <liangh.zhu@gmail.com>
 *
 * @return array
 */
function buildTree($src_arr, $parent_id = 0, $tree = array())
{
	foreach($src_arr as $idx => $row)
	{
		if($row['parent_id'] == $parent_id)
		{
			foreach($row as $k => $v) {
				$tree[$row['id']][$k] = $v;
			}

			unset($src_arr[$idx]);
			$tree[$row['id']]['children'] = buildTree($src_arr, $row['id']);
		}
	}
	ksort($tree);
	return $tree;
}



/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author sunny5156 <137898350@qq.com>
 */
function data_auth_sign($data) {
	//数据类型检测
	if(!is_array($data)){
		$data = (array)$data;
	}
	ksort($data); //排序
	$code = http_build_query($data); //url编码并生成query字符串
	$sign = sha1($code); //生成签名
	return $sign;
}

function check_verify($code, $id = 1){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

function saveLog($log, $module = null)
{
	SeasLog::setBasePath(RUNTIME_PATH.'/'.MODULE_NAME);

	$module = empty($module) ? 'Pactera': $module;
	SeasLog::setLogger($module);

	$log = is_array($log) ? json_encode($log, JSON_UNESCAPED_UNICODE) : $log;

	SeasLog::info($log);

}


/**
 * 获取java webservice 数据格式
 * @param string $protocolCode
 * @param array $data
 * @return \stdClass
 */
function get_java_soap_param($protocolCode,$data){
	$obj = new \stdClass();
	$obj->bussinessCode = '0001';
	$obj->protocolCode = $protocolCode;
	$obj->username = '';
	$obj->data = array(json_decode(json_encode($data)));
	
	return $obj;
}
/**
 * 获取附件存储地址
 * @param mixed(array|int) $param 附件id
 * @return string 附件存储地址
 */
function get_attachment_savepath($param){
	if (is_numeric($param)) {
		$res = @M('Attachment')->field('CONCAT(`savepath`,`savename`)as savepath')->where("id={$param}")->find();
	}
	
	if(is_array($param)){
		$res = @M('Attachment')->field('CONCAT(`savepath`,`savename`)as savepath')->where(array('id'=>array('IN',$param)))->col();
		
		$res['savepath'] = implode(',', $res);
	}
	
	return $res['savepath'];
}
/**
 * 获取soap api url
 * @return Ambigous <>
 */
function get_soap_api_url(){
	$cof = C('SOAP.url');
	return $cof[array_rand ( $cof )];
}
/**
 * 获取手机端webapp 页面 url
 * @return Ambigous <>
 */
function get_webapp_url(){
	$cof = C('WEBAPP.url');
	return $cof[array_rand ( $cof )];
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
	return \Think\Hook::listen($hook,$params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if(class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    }else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Addons/execute', $params);
}

//字符串解密加密
/**
 * 加密解密字符串(可控制过期时间)
 *
 * @param string $string
 * @param string $operation
 * @param string $key
 * @param bool $expiry
 * @return unknown
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4; // 随机密钥长度 取值 0-32;
	// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	// 当此值为 0 时，则不产生随机密钥


	$key = md5 ( $key ? $key : 'nc.hjoaix' );
	$keya = md5 ( substr ( $key, 0, 16 ) );
	$keyb = md5 ( substr ( $key, 16, 16 ) );
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr ( $string, 0, $ckey_length ) : substr ( md5 ( microtime () ), - $ckey_length )) : '';

	$cryptkey = $keya . md5 ( $keya . $keyc );
	$key_length = strlen ( $cryptkey );

	$string = $operation == 'DECODE' ? base64_decode ( substr ( $string, $ckey_length ) ) : sprintf ( '%010d', $expiry ? $expiry + time () : 0 ) . substr ( md5 ( $string . $keyb ), 0, 16 ) . $string;
	$string_length = strlen ( $string );

	$result = '';
	$box = range ( 0, 255 );

	$rndkey = array ();
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $cryptkey [$i % $key_length] );
	}

	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}

	if ($operation == 'DECODE') {
		if ((substr ( $result, 0, 10 ) == 0 || substr ( $result, 0, 10 ) - time () > 0) && substr ( $result, 10, 16 ) == substr ( md5 ( substr ( $result, 26 ) . $keyb ), 0, 16 )) {
			return substr ( $result, 26 );
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace ( '=', '', base64_encode ( $result ) );
	}
}

function col($field,$array){
	$tmp = array();
	foreach($array as $v){
		$tmp[] = $v[$field];
	}
	return $tmp;
}
/**
 * 截取html字符串
 * @param string $string
 * @param string $start
 * @param string $end
 * @return string
 */
function sub_html($string,$start,$end = null){
	$subHtml = '';
	if($end){
		$string = substr($string, strpos($string, $start));
		$subHtml = substr($string, strpos($string, $start),strpos($string, $end));
	}else{
		$subHtml = substr($string, strpos($string, $start));
	}
	
	return $subHtml;
}
/**
 * 远程图片入库
 * @param string $url
 * @return multitype:NULL unknown number Ambigous <> mixed
 */
function remote_img_to_attachment($url){
	$data = $attach = $extend = array();
	
	$extend = pathinfo($url);
	
	if(strtolower($extend['extension']) == 'png'){
		$attach['name'] = $extend['basename'];
		$attach['size'] = strlen(file_get_contents($url));
// 		$attach['type'] = mime_content_type($url);
		
	}else{
		$data = exif_read_data($url);
		$attach['name'] = $data['FileName'];
		$attach['size'] = $data['FileSize'];
		$attach['type'] = $data['MimeType'];
	}
	$attach['extension'] = $extend['extension'];
	$attach['savepath'] = $url;
	
	$attach['create_time'] = $attach['update_time'] = time();
	$attach['id'] = @M('Attachment')->add($attach);
	
	return $attach;
}

/**
 * 判断是否是json
 * @param string $string
 * @return boolean
 */
function is_json($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * 压缩html : 清除换行符,清除制表符,去掉注释标记
 * @param $string
 * @return 压缩后的$string
 *
 */
function compress_html($string) {
	$string = str_replace ( "\r\n", '', $string ); // 清除换行符
	$string = str_replace ( "\n", '', $string ); // 清除换行符
	$string = str_replace ( "\t", '', $string ); // 清除制表符
	$pattern = array (
			"/> *([^ ]*) *</", // 去掉注释标记
			"/[\s]+/",
			"/<!--[^!]*-->/",
			"/\" /",
			"/ \"/",
			"'/\*[^*]*\*/'" 
	);
	$replace = array (
			">\\1<",
			" ",
			"",
			"\"",
			"\"",
			"" 
	);
	return preg_replace ( $pattern, $replace, $string); 
} 

function debug($arr,$break = 1){
    echo '<pre>';
    print_r($arr);
    echo "</pre>";
    if($break){
        exit();
    }

}

function debug_sql($break = false){
    echo "<br>";
	echo M()->_sql();
    echo "<br>";
	if($break){
		exit;
	}
}

function clear_html($content) {
// 	$content = preg_replace('/<([^\s]+)[^>]*>/','<$1>',$content);

// 	$content = preg_replace("/<a[^>]*>/i", "", $content);
// 	$content = preg_replace("/<\/a>/i", "", $content);
// 	$content = preg_replace("/\&nbsp;/", "", $content);
// 	$content = preg_replace("/<div[^>]*>/i", "<p>", $content);
// 	$content = preg_replace("/<\/div>/i", "</p>", $content);

	$content = preg_replace("/<!--[^>]*-->/i", "", $content);//注释内容  
	$content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/class=.+?/i",'',$content);//去除样式
	$content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/^id=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/width=.*?/",'',$content);//去除样式
	$content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/border=0/",'border=1',$content);//去除样式
	$content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式
	$content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数
	return $content;
}
/**
 * 数字转成汉字
 * @param int $num
 * @return mixed
 */
function num2hanzi($num){
	$arr = array();
	$pattern = array('/0/','/1/','/2/','/3/','/4/','/5/','/6/','/7/','/8/','/9/');
	$replace = array('零','一','二','三','四','五','六','七','八','九');
	$length = strlen($num);
	return preg_replace($pattern, $replace, $num);
}

/**
 * 根据经纬度计算距离 其中A($lat1,$lng1)、B($lat2,$lng2)
 */
function get_distance($lat1,$lng1,$lat2,$lng2)
{
    //地球半径
    $R = 6378137;

    //将角度转为狐度
    $radLat1 = deg2rad($lat1);
    $radLat2 = deg2rad($lat2);
    $radLng1 = deg2rad($lng1);
    $radLng2 = deg2rad($lng2);

    //结果
    $s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*$R;

    //精度
    $s = round($s* 10000)/10000;

    return  round($s);
}

/**
 * 弹框提示
 * @param string $msg
 */
function alert($msg){
    echo "<script>alert('".$msg."')</script>";
    //exit;
}

function curl_post($url,$data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);
    }
    curl_close($curl); // 关键CURL会话
    if (is_json($tmpInfo)) $tmpInfo = json_decode($tmpInfo,true);
    return $tmpInfo; // 返回数据
}

function curl_get($url,$data=array()){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);
    }
    curl_close($curl); // 关键CURL会话
    if (is_json($tmpInfo)) $tmpInfo = json_decode($tmpInfo,true);
    return $tmpInfo; // 返回数据
}

function search_word_from() { //主要方便存入COOKIE（跟踪一个月）

    if(!empty($_GET['tuiyitui'])){//全局的推广连接可以 主要是投放广告等监控使用
        $keyword = htmlspecialchars($_GET['tuiyitui']);
        $from = 'tui';//推广
        cookie('tui_from',$keyword,30*86400);//存放在COOKIE 一个月
    }

    $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strstr( $referer, 'baidu.com')){ //百度
        preg_match( "|baidu.+wo?r?d=([^\&]*)|is", $referer, $tmp );
        $keyword = htmlspecialchars(urldecode( $tmp[1] ));
        $from = 'baidu';
    }elseif(strstr( $referer, 'google.com') or strstr( $referer, 'google.cn')){ //谷歌
        preg_match( "|google.+q=([^\&]*)|is", $referer, $tmp );
        $keyword = htmlspecialchars(urldecode( $tmp[1] ));
        $from = 'google';
    }elseif(strstr( $referer, 'soso.com')){ //搜搜
        preg_match( "|soso.com.+w=([^\&]*)|is", $referer, $tmp );
        $keyword = htmlspecialchars(urldecode( $tmp[1] ));
        $from = 'soso';
    }elseif(strstr( $referer, 'so.com')){ //360搜索
        preg_match( "|so.+q=([^\&]*)|is", $referer, $tmp );
        $keyword = htmlspecialchars(urldecode( $tmp[1] ));
        $from = '360';
    }elseif(strstr( $referer, 'sogou.com')){ //搜狗
        preg_match( "|sogou.com.+query=([^\&]*)|is", $referer, $tmp );
        $keyword = htmlspecialchars(urldecode( $tmp[1] ));
        $from = 'sogou';
    }else{
        return false;
    }
    cookie('search_word_from',json_encode(array('keyword'=>$keyword,'from'=>$from)),30*86400);//存放在COOKIE 一个月
    return true;
}


/**
 * 生成二维码
 * @author sunny5156  <137898350@qq.com>
 * @param unknown $token
 * @param unknown $url
 * @param number $size
 * @return string
 */
function make_qrcode($token,$url,$size = 8){ //生成网址的二维码 返回图片地址
    $md5 = md5($token);
    $dir = substr($md5,0,3).'/'.substr($md5,3,3).'/'.substr($md5,6,3).'/';
    $patch = '/Public/Uploads/'. 'qrcode/'.$dir;
    if(!file_exists(ROOT_DIR.$patch)){
        mkdir(ROOT_DIR.$patch,0755,true);
    }
    $file = $md5.'.png';
    $filePath  = $patch.$file;
    if(!file_exists(ROOT_DIR.$filePath)){
        $level = 'L';
        if(strstr($url,__HOST__)){
            $data = $url;
        }else{
            $data =__HOST__. $url;
        }
        QRcode::png($data, ROOT_DIR.$filePath, $level, $size,2,true);
    }
    return $filePath;
}


function is_mobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi",
        "android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio",
        "au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu",
        "cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ",
        "fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi",
        "htc","huawei","hutchison","inno","ipad","ipaq","iphone","ipod","jbrowser","kddi",
        "kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo",
        "mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-",
        "moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia",
        "nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-",
        "playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo",
        "samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank",
        "sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit",
        "tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin",
        "vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce",
        "wireless","xda","xde","zte");
    $is_mobile = false;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }
    return $is_mobile;
}

function is_weixin() {
    return strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger');
}


function isSecondDomain($domain){
    return (boolean) preg_match('/^[a-z0-9]{4,10}$/i', $domain);
}

function get_domain($url) {
    $host = strtolower($url);
    if (strpos($host, '/') !== false) {
        $parse = @parse_url($host);
        $host = $parse ['host'];
    }
    $topleveldomaindb = array('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me');
    $str = '';
    foreach ($topleveldomaindb as $v) {
        $str .= ($str ? '|' : '') . $v;
    }

    $matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
    if (preg_match("/" . $matchstr . "/ies", $host, $matchs)) {
        $domain = $matchs ['0'];
    } else {
        $domain = $host;
    }
    return $domain;
}

//时间格式化
function formatt($time) {

    $t = NOW_TIME - $time;
    $mon = (int) ($t / (86400 * 30));
    if ($mon >= 1) {
        return '一个月前';
    }
    $day = (int) ($t / 86400);
    if ($day >= 1) {
        return $day . '天前';
    }
    $h = (int) ($t / 3600);
    if ($h >= 1) {
        return $h . '小时前';
    }
    $min = (int) ($t / 60);
    if ($min >= 1) {
        return $min . '分前';
    }
    return '刚刚';
}

/*
 * 经度纬度 转换成距离
 * $lat1 $lng1 是 数据的经度纬度
 * $lat2,$lng2 是获取定位的经度纬度
 */

function rad($d) {
    return $d * 3.1415926535898 / 180.0;
}

function getDistanceNone($lat1, $lng1, $lat2, $lng2) {
    $EARTH_RADIUS = 6378.137;
    $radLat1 = rad($lat1);
    //echo $radLat1;
    $radLat2 = rad($lat2);
    $a = $radLat1 - $radLat2;
    $b = rad($lng1) - rad($lng2);
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
    $s = $s * $EARTH_RADIUS;
    $s = round($s * 10000);
    return $s;
}

function getDistance($lat1, $lng1, $lat2, $lng2) {
    $s = getDistanceNone($lat1, $lng1, $lat2, $lng2);
    $s = $s / 10000;
    if ($s < 1) {
        $s = round($s * 1000);
        $s.='m';
    } else {
        $s = round($s, 2);
        $s.='km';
    }
    return $s;
}

//空白区域插件
function block($id) {
    if (!defined('THEME_NAME'))
        return '';
    $token = 'bao_' . THEME_NAME . '_' . $id;
    $cache = cache(array('type' => 'File', 'expire' => 600)); //10分钟缓存
    if (!$content = $cache->get($token)) {
        $settings = D('Templatesetting')->getWidgetsByThemeBlock(THEME_NAME, $id);
        if (empty($settings))
            return '';
        $content = '';
        foreach ($settings as $data) {
            $cfg = $data['setting'];
            $cfg['setting_id'] = $data['setting_id'];
            $content.= W($data['widget'], $cfg, true);
        }
        $cache->set($token, $content);
    }
    return $content;
}

function tmplToStr($str, $datas) {
    preg_match_all('/{(.*?)}/', $str, $arr);
    foreach ($arr[1] as $k => $val) {
        $v = isset($datas[$val]) ? $datas[$val] : '';
        $str = str_replace($arr[0][$k], $v, $str);
    }
    return $str;
}

function arrayToObject($e) {
    if (gettype($e) != 'array')
        return;
    foreach ($e as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object')
            $e[$k] = (object) arrayToObject($v);
    }
    return (object) $e;
}

function object_to_array($e) {
    $e = (array) $e;
    foreach ($e as $k => $v) {
        if (gettype($v) == 'resource')
            return;
        if (gettype($v) == 'object' || gettype($v) == 'array')
            $e[$k] = (array) object_to_array($v);
    }
    return $e;
}

function del_file_by_dir($dir) {
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            unlink($fullpath);
        }
    }
    closedir($dh);
}

function get_dir_name($dir) {
    $dh = opendir($dir);
    $return = array();
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (is_dir($fullpath)) {
                $return[$file] = $file;
            }
        }
    }
    closedir($dh);
    return $return;
}



function link_to($ctl, $vars = array(),$var2=array()) {
    $vars = array_merge($vars,$var2);
    foreach ($vars as $k => $v) {
        if (empty($v))
            unset($vars[$k]);
    }
    return U($ctl, $vars);
}

function ip_to_area($_ip) {

    static $Ip = null;
    if ($Ip == null) {
    $Ip = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
    }
    $arr = $Ip->getlocation($_ip);
    $country = mb_convert_encoding($arr['country'], "UTF-8", "gbk");
        $area = mb_convert_encoding($arr['area'], "UTF-8", "gbk");
        return $country . $area;
}

/**
* 后台模版带权限的URL校验
* @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
* @param string $title  标题
* @param string $mini  是否异步加载
* @param string $class A标签样式
* @param string|array  $vars 传入的参数，支持数组和字符串
* @return string
*/
function BAK($url = '', $vars = '', $title = '', $mini = "", $class = "", $width = '', $height = '', $info='') {
    static $admin;
    if(empty($admin)){
        $admin = session('admin');
        $model = new \Manage\Model\RoleMapsModel();
        $admin['menu_list'] = $model->getMenuIdsByRoleId($admin['role_id']);
    }
    if ($admin['role_id'] != 1) {
        $menu = D('Manage/Menu')->fetchAll();
        $urlArr = $tmp =  explode('/', $url);
        
        $count = count($urlArr);
        switch ($count){
            case 1:
                $urlArr[0] = MODULE_NAME;
                $urlArr[1] = CONTROLLER_NAME;
                $urlArr[2] = $url;
                break;
            case 2:
                $urlArr[0] = MODULE_NAME;
                $urlArr[1] = $tmp[0];
                $urlArr[2] = $tmp[1];
                break;
        }
        $url = implode('/', $urlArr);
        $menu_id = 0;
        foreach ($menu as $k => $v) {
            if (strtolower($v['menu_action']) == strtolower($url)) {
                $menu_id = (int) $k;
            }
        }
        if (empty($menu_id) || !isset($admin['menu_list'][$menu_id])) {
            $url = 'javascript:void(0);';
            $title = '未授权';
            $mini = '';
        } else {
            $url = U($url, $vars);
        }
    } else {
        $url = U($url, $vars);
    }
    //权限判断 暂时忽略，后面补充
    $m = $c = $h = $w = '';
    if (!empty($mini)) {
         $m = ' mini="' . $mini . '"  ';
        }
    $i = ' data-info="您确定要'.$title.'"';
    if(!empty($info)){
        $i = ' data-info="'.$info.'"';
    }
    if (!empty($class)) {
        $c = ' class="' . $class . '" ';
    }
    if (!empty($width)) {
        $w = ' w="' . $width . '" ';
    }
    if (!empty($width)) {
        $h = ' h="' . $height . '" ';
    }

    return '<a href="' . $url . '" ' . $m . $c . $w . $h . $i. ' >' . $title . '</a>';
}
/**
 *
 *
 * @param string $url $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string $vars $vars 传入的参数，支持数组和字符串
 * @param string $title $title  标题
 * @param string $mini 是否异步加载
 * @param string $class A标签或者button样式
 * @param string $width
 * @param string $height
 * @param string $info
 * @param string $type 默认返回a标签，传button返回button
 * @return string
 * @date
 */
function BA($url = '', $vars = '', $title = '', $mini = "", $class = "", $width = '', $height = '', $info='' ,$type = '') {
    static $admin;
    if(empty($admin)){
        $admin = session('admin');
        $model = new \Manage\Model\RoleMapsModel();
        $admin['menu_list'] = $model->getMenuIdsByRoleId($admin['role_id']);
    }
    if ($admin['role_id'] != 1) {
        $menu = D('Manage/Menu')->fetchAll();
        $urlArr = $tmp =  explode('/', $url);

        $count = count($urlArr);
        switch ($count){
            case 1:
                $urlArr[0] = MODULE_NAME;
                $urlArr[1] = CONTROLLER_NAME;
                $urlArr[2] = $url;
                break;
            case 2:
                $urlArr[0] = MODULE_NAME;
                $urlArr[1] = $tmp[0];
                $urlArr[2] = $tmp[1];
                break;
        }
        $url = implode('/', $urlArr);
        $menu_id = 0;
        foreach ($menu as $k => $v) {
            if (strtolower($v['menu_action']) == strtolower($url)) {
                $menu_id = (int) $k;
            }
        }
        if (empty($menu_id) || !isset($admin['menu_list'][$menu_id])) {
            $url = 'javascript:void(0);';
            $title = '未授权';
            $mini = '';
        } else {
            $url = U($url, $vars);
        }
    } else {
        $url = U($url, $vars);
    }
    //权限判断 暂时忽略，后面补充
    $m = $c = $h = $w = '';
    if (!empty($mini)) {
        $m = ' mini="' . $mini . '"  ';
    }
    $i = ' data-info="您确定要'.$title.'"';
    if(!empty($info)){
        $i = ' data-info="'.$info.'"';
    }
    if (!empty($class)) {
        $c = ' class="' . $class . '" ';
    }
    if (!empty($width)) {
        $w = ' w="' . $width . '" ';
    }
    if (!empty($width)) {
        $h = ' h="' . $height . '" ';
    }
    if($type == 'button'){
        return '<button href="' . $url . '" ' . $m . $c . $w . $h . $i. ' >' . $title . '</button>';
    }else{
        return '<a href="' . $url . '" ' . $m . $c . $w . $h . $i. ' >' . $title . '</a>';
    }
}


/**
 * 过滤不安全的HTML代码
 */
function SecurityEditorHtml($str) {
    $farr = array(
        "/\s+/", //过滤多余的空白
        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",
        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU"
    );
    $tarr = array(
        " ",
        "＜\\1\\2\\3＞",
        "\\1\\2",
    );
    $str = preg_replace($farr, $tarr, $str);
    return $str;
}

/**
 * 判断一个字符串是否是一个Email地址
 *
 * @param string $string
 * @return boolean
 */
function is_email($string) {
    return (boolean) preg_match('/^[a-z0-9.\-_]{2,64}@[a-z0-9]{2,32}(\.[a-z0-9]{2,5})+$/i', $string);
}

/**
 * 检查是否为一个合法的时间格式
 *
 * @access  public
 * @param   string  $time
 * @return  void
 */
function is_time($time) {
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}

/**
 * 判断一个字符串是否是一个合法时间
 *
 * @param string $string
 * @return boolean
 */
function is_date($string) {
    if (preg_match('/^\d{4}-[0-9][0-9]-[0-9][0-9]$/', $string)) {
        $date_info = explode('-', $string);
        return checkdate(ltrim($date_info[1], '0'), ltrim($date_info[2], '0'), $date_info[0]);
    }
    if (preg_match('/^\d{8}$/', $string)) {
        return checkdate(ltrim(substr($string, 4, 2), '0'), ltrim(substr($string, 6, 2), '0'), substr($string, 0, 4));
    }
    return false;
}

/**
 * 判断输入的字符串是否是一个合法的电话号码（仅限中国大陆）
 *
 * @param string $string
 * @return boolean
 */
function is_phone($string) {
    if (preg_match('/^0\d{2,3}-\d{7,8}$/', $string))
        return true;
    return false;
}

/**
 * 判断输入的密码字符串是否是一个有数字和字母
 *
 * @param string $string
 * @return boolean
 */
function is_legal_to_pwd($string) {
    if (preg_match('/^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z]{6,100}$/', $string)){
        return true;
    }
    return false;
}

/**
 * 判断输入的字符串是否是一个合法的QQ
 *
 * @param string $string
 * @return boolean
 */
function is_qq($string) {
    if (ctype_digit($string)) {
        $len = strlen($string);
        if ($len < 5 || $len > 13)
            return false;
        return true;
    }
    return is_email($string);
}

/**
 *
 * @param string $fileName
 * @return boolean
 */
function is_image($fileName) {
    $ext = explode('.', $fileName);
    $ext_seg_num = count($ext);
    if ($ext_seg_num <= 1)
        return false;

    $ext = strtolower($ext[$ext_seg_num - 1]);
    return in_array($ext, array('jpeg', 'jpg', 'png', 'gif'))?true:false;
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice . '...' : $slice;
}

/**
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function rand_string($len = 6, $type = '', $addChars = '') {
    $str = '';
    switch ($type) {
        case 0:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 1:
            $chars = str_repeat('0123456789', 3);
            break;
        case 2:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
            break;
        case 3:
            $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
            break;
        case 4:
            $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
            break;
    }
    if ($len > 10) {//位数过长重复字符串一定次数
        $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
    }
    if ($type != 4) {
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
    } else {
        // 中文随机字
        for ($i = 0; $i < $len; $i++) {
            $str.= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
        }
    }
    return $str;
}

/**
 * 获取登录验证码 默认为4位数字
 * @param string $fmode 文件名
 * @return string
 */
function build_verify($length = 4, $mode = 1) {
    return rand_string($length, $mode);
}

/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 * @return string
 */
function byte_format($size, $dec = 2) {
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, $dec) . " " . $a[$pos];
}

/**
 * 检查字符串是否是UTF8编码
 * @param string $string 字符串
 * @return Boolean
 */
function is_utf8($string) {
    return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]            # ASCII
       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
}

/**
 * 代码加亮
 * @param String  $str 要高亮显示的字符串 或者 文件名
 * @param Boolean $show 是否输出
 * @return String
 */
function highlight_code($str, $show = false) {
    if (file_exists($str)) {
        $str = file_get_contents($str);
    }
    $str = stripslashes(trim($str));
    // The highlight string function encodes and highlights
    // brackets so we need them to start raw
    $str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

    // Replace any existing PHP tags to temporary markers so they don't accidentally
    // break the string out of PHP, and thus, thwart the highlighting.

    $str = str_replace(array('&lt;?php', '?&gt;', '\\'), array('phptagopen', 'phptagclose', 'backslashtmp'), $str);

    // The highlight_string function requires that the text be surrounded
    // by PHP tags.  Since we don't know if A) the submitted text has PHP tags,
    // or B) whether the PHP tags enclose the entire string, we will add our
    // own PHP tags around the string along with some markers to make replacement easier later

    $str = '<?php //tempstart' . "\n" . $str . '//tempend ?>'; // <?
    // All the magic happens here, baby!
    $str = highlight_string($str, TRUE);

    // Prior to PHP 5, the highlight function used icky font tags
    // so we'll replace them with span tags.
    if (abs(phpversion()) < 5) {
        $str = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $str);
        $str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
    }

    // Remove our artificially added PHP
    $str = preg_replace("#\<code\>.+?//tempstart\<br />\</span\>#is", "<code>\n", $str);
    $str = preg_replace("#\<code\>.+?//tempstart\<br />#is", "<code>\n", $str);
    $str = preg_replace("#//tempend.+#is", "</span>\n</code>", $str);

    // Replace our markers back to PHP tags.
    $str = str_replace(array('phptagopen', 'phptagclose', 'backslashtmp'), array('&lt;?php', '?&gt;', '\\'), $str); //<?
    $line = explode("<br />", rtrim(ltrim($str, '<code>'), '</code>'));
    $result = '<div class="code"><ol>';
    foreach ($line as $key => $val) {
        $result .= '<li>' . $val . '</li>';
    }
    $result .= '</ol></div>';
    $result = str_replace("\n", "", $result);
    if ($show !== false) {
        echo($result);
    } else {
        return $result;
    }
}

//输出安全的html
function h($text, $tags = null) {
    $text = trim($text);
    //完全过滤注释
    $text = preg_replace('/<!--?.*-->/', '', $text);
    //完全过滤动态代码
    $text = preg_replace('/<\?|\?' . '>/', '', $text);
    //完全过滤js
    $text = preg_replace('/<script?.*\/script>/', '', $text);

    $text = str_replace('[', '&#091;', $text);
    $text = str_replace(']', '&#093;', $text);
    $text = str_replace('|', '&#124;', $text);
    //过滤换行符
    $text = preg_replace('/\r?\n/', '', $text);
    //br
    $text = preg_replace('/<br(\s\/)?' . '>/i', '[br]', $text);
    $text = preg_replace('/<p(\s\/)?' . '>/i', '[br]', $text);
    $text = preg_replace('/(\[br\]\s*){10,}/i', '[br]', $text);
    //过滤危险的属性，如：过滤on事件lang js
    while (preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i', $text, $mat)) {
        $text = str_replace($mat[0], $mat[1], $text);
    }
    while (preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat)) {
        $text = str_replace($mat[0], $mat[1] . $mat[3], $text);
    }
    if (empty($tags)) {
        $tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
    }
    //允许的HTML标签
    $text = preg_replace('/<(' . $tags . ')( [^><\[\]]*)>/i', '[\1\2]', $text);
    $text = preg_replace('/<\/(' . $tags . ')>/Ui', '[/\1]', $text);
    //过滤多余html
    $text = preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i', '', $text);
    //过滤合法的html标签
    while (preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i', $text, $mat)) {
        $text = str_replace($mat[0], str_replace('>', ']', str_replace('<', '[', $mat[0])), $text);
    }
    //转换引号
    while (preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i', $text, $mat)) {
        $text = str_replace($mat[0], $mat[1] . '|' . $mat[3] . '|' . $mat[4], $text);
    }
    //过滤错误的单个引号
    while (preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i', $text, $mat)) {
        $text = str_replace($mat[0], str_replace($mat[1], '', $mat[0]), $text);
    }
    //转换其它所有不合法的 < >
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $text = str_replace('"', '&quot;', $text);
    //反转换
    $text = str_replace('[', '<', $text);
    $text = str_replace(']', '>', $text);
    $text = str_replace('|', '"', $text);
    //过滤多余空格
    $text = str_replace('  ', ' ', $text);
    return $text;
}

function ubb($Text) {
    $Text = trim($Text);
    //$Text=htmlspecialchars($Text);
    $Text = preg_replace("/\\t/is", "  ", $Text);
    $Text = preg_replace("/\[h1\](.+?)\[\/h1\]/is", "<h1>\\1</h1>", $Text);
    $Text = preg_replace("/\[h2\](.+?)\[\/h2\]/is", "<h2>\\1</h2>", $Text);
    $Text = preg_replace("/\[h3\](.+?)\[\/h3\]/is", "<h3>\\1</h3>", $Text);
    $Text = preg_replace("/\[h4\](.+?)\[\/h4\]/is", "<h4>\\1</h4>", $Text);
    $Text = preg_replace("/\[h5\](.+?)\[\/h5\]/is", "<h5>\\1</h5>", $Text);
    $Text = preg_replace("/\[h6\](.+?)\[\/h6\]/is", "<h6>\\1</h6>", $Text);
    $Text = preg_replace("/\[separator\]/is", "", $Text);
    $Text = preg_replace("/\[center\](.+?)\[\/center\]/is", "<center>\\1</center>", $Text);
    $Text = preg_replace("/\[url=http:\/\/([^\[]*)\](.+?)\[\/url\]/is", "<a href=\"http://\\1\" target=_blank>\\2</a>", $Text);
    $Text = preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is", "<a href=\"http://\\1\" target=_blank>\\2</a>", $Text);
    $Text = preg_replace("/\[url\]http:\/\/([^\[]*)\[\/url\]/is", "<a href=\"http://\\1\" target=_blank>\\1</a>", $Text);
    $Text = preg_replace("/\[url\]([^\[]*)\[\/url\]/is", "<a href=\"\\1\" target=_blank>\\1</a>", $Text);
    $Text = preg_replace("/\[img\](.+?)\[\/img\]/is", "<img src=\\1>", $Text);
    $Text = preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is", "<font color=\\1>\\2</font>", $Text);
    $Text = preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is", "<font size=\\1>\\2</font>", $Text);
    $Text = preg_replace("/\[sup\](.+?)\[\/sup\]/is", "<sup>\\1</sup>", $Text);
    $Text = preg_replace("/\[sub\](.+?)\[\/sub\]/is", "<sub>\\1</sub>", $Text);
    $Text = preg_replace("/\[pre\](.+?)\[\/pre\]/is", "<pre>\\1</pre>", $Text);
    $Text = preg_replace("/\[email\](.+?)\[\/email\]/is", "<a href='mailto:\\1'>\\1</a>", $Text);
    $Text = preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis", "color_txt('\\1')", $Text);
    $Text = preg_replace("/\[emot\](.+?)\[\/emot\]/eis", "emot('\\1')", $Text);
    $Text = preg_replace("/\[i\](.+?)\[\/i\]/is", "<i>\\1</i>", $Text);
    $Text = preg_replace("/\[u\](.+?)\[\/u\]/is", "<u>\\1</u>", $Text);
    $Text = preg_replace("/\[b\](.+?)\[\/b\]/is", "<b>\\1</b>", $Text);
    $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is", " <div class='quote'><h5>引用:</h5><blockquote>\\1</blockquote></div>", $Text);
    $Text = preg_replace("/\[code\](.+?)\[\/code\]/eis", "highlight_code('\\1')", $Text);
    $Text = preg_replace("/\[php\](.+?)\[\/php\]/eis", "highlight_code('\\1')", $Text);
    $Text = preg_replace("/\[sig\](.+?)\[\/sig\]/is", "<div class='sign'>\\1</div>", $Text);
    $Text = preg_replace("/\\n/is", "<br/>", $Text);
    return $Text;
}

function cleanhtml($str, $length = 0, $suffix = true) {
    $str = preg_replace("@<(.*?)>@is", "", $str);
    if ($length > 0) {
        $str = msubstr($str, 0, $length, 'utf-8', $suffix);
    }
    return $str;
}

// 随机生成一组字符串
function build_count_rand($number, $length = 4, $mode = 1) {
    if ($mode == 1 && $length < strlen($number)) {
        //不足以生成一定数量的不重复数字
        return false;
    }
    $rand = array();
    for ($i = 0; $i < $number; $i++) {
        $rand[] = rand_string($length, $mode);
    }
    $unqiue = array_unique($rand);
    if (count($unqiue) == count($rand)) {
        return $rand;
    }
    $count = count($rand) - count($unqiue);
    for ($i = 0; $i < $count * 3; $i++) {
        $rand[] = rand_string($length, $mode);
    }
    $rand = array_slice(array_unique($rand), 0, $number);
    return $rand;
}

function remove_xss($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
        // @ @ search for the hex values
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        // @ @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}

// 自动转换字符集 支持数组转换
function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key)
                unset($fContents[$key]);
        }
        return $fContents;
    }
    else {
        return $fContents;
    }
}

// S方法的别名 已经废除 不再建议使用
function cache($name,$value='',$options=null){
    return S($name,$value,$options);
}

function get_column_type($type) {
    $website_cate_type = array('column_group'=>'栏目组','column'=>'栏目','page'=>'单页');
    return $website_cate_type[$type];
}


function is_date_score($string){
    if (preg_match('/^\d{4}-[0-9][0-9]-[0-9][0-9]$/', $string)) {
        $date_info = explode('-', $string);
        return checkdate(ltrim($date_info[1], '0'), ltrim($date_info[2], '0'), $date_info[0]);
    }
    return false;
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = & $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = & $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = & $refer[$parentId];
                    $parent[$child][] = & $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc') {
    if (is_array($list)) {
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer[$i] = &$data[$field];
        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc':// 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val)
            $resultSet[] = &$list[$key];
        return $resultSet;
    }
    return false;
}

/**
 * 在数据列表中搜索
 * @access public
 * @param array $list 数据列表
 * @param mixed $condition 查询条件
 * 支持 array('name'=>$value) 或者 name=$value
 * @return array
 */
function list_search($list, $condition) {
    if (is_string($condition))
        parse_str($condition, $condition);
    // 返回的结果集合
    $resultSet = array();
    foreach ($list as $key => $data) {
        $find = false;
        foreach ($condition as $field => $value) {
            if (isset($data[$field])) {
                if (0 === strpos($value, '/')) {
                    $find = preg_match($value, $data[$field]);
                } elseif ($data[$field] == $value) {
                    $find = true;
                }
            }
        }
        if ($find)
            $resultSet[] = &$list[$key];
    }
    return $resultSet;
}

/**
 * 导出excel(PHPExcel)
 * @author sunny5156  <137898350@qq.com>
 * @param unknown $data
 * @param unknown $excelFileName
 * @param unknown $sheetTitle
 * @param unknown $headlist
 * @param number $row
 */
function export($data, $excelFileName, $sheetTitle, $headlist, $row = 1) {
    /* 实例化类 */
    vendor("PHPExcel.PHPExcel");
    $objPHPExcel = new \PHPExcel();

    /* 设置输出的excel文件为2007兼容格式 */
    $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

    /* 设置当前的sheet */
    $objPHPExcel->setActiveSheetIndex(0);

    $objActSheet = $objPHPExcel->getActiveSheet();

    /* sheet标题 */
    $objActSheet->setTitle($sheetTitle);

    $title_row = $row; //标题列
    $no = 1; //序号
    $i = 1; //excel行号
    foreach ($data as $value) {
        if ($i == $title_row) {
            $j = 'A';
            foreach ($headlist as $one) {
                $objActSheet->setCellValue($j . $title_row, $one);
                //标题字体颜色设置
                $objPHPExcel->getActiveSheet()->getStyle($j . $title_row)->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_BLACK); //设置颜色
                //标题颜色设置
                $objActSheet->getStyle($j . $title_row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
                $objActSheet->getStyle($j . $title_row)->getFill()->getStartColor()->setARGB(\PHPExcel_Style_Color::COLOR_YELLOW);
                $objPHPExcel->getActiveSheet()->getStyle($j . $title_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                $j++;
            }
            $i++;
        }
        /* excel文件内容 */
        if ($row < $i) {
            //A列的单独插入
            $objActSheet->setCellValue("A" . $i, $no);
            $objPHPExcel->getActiveSheet()->getStyle("A" . $i)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $j = 'B';
        } else {
            $j = 'A'; //标题列之前的数据从A开始插入
        }

        foreach ($value as $value2) {
            $objActSheet->setCellValue($j . $i, $value2);
            $objPHPExcel->getActiveSheet()->getStyle($j . $i)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $objActSheet->setCellValueExplicit($j . $i, $value2, \PHPExcel_Cell_DataType::TYPE_STRING);
            $j++;
        }
        $no++;
        $i++;
    }

    /* 生成到浏览器，提供下载 */
    ob_end_clean();  //清空缓存
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename="' . $excelFileName . '.xlsx"');
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');
}

/**
 * 导出excel(csvs)
 * @author Kevin_ren  <330202207@qq.com>
 * @data 导出数据
 * @headlist 第一列,列名
 * @fileName 文件名
 */
function csv_export($data = array(), $headlist = array(), $fileName) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
    header('Cache-Control: max-age=0');

    // 打开PHP文件句柄，php://output 表示直接输出到浏览器
    $fp = fopen('php://output', 'a');

    // 输出Excel列名信息
    foreach ($headlist as $i => $v) {
        // CSV的Excel支持GBK编码，一定要转换，否则乱码
        $headlist[$i] = iconv('utf-8', 'gbk', $v);
    }

    // 将数据通过fputcsv写到文件句柄
    fputcsv($fp, $headlist);

    // 计数器
    $cnt = 0;
    // 每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 100000;

    // 逐行取出数据，不浪费内存
    $count = count($data);
    for ($t = 0; $t < $count; $t++) {
        $cnt ++;
        if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题
            ob_flush();
            flush();
            $cnt = 0;
        }
        $row = $data[$t];
        foreach ($row as $i => $v) {
            $row[$i] = iconv('utf-8', 'gbk', $v);
        }
        fputcsv($fp, $row);
    }
}

/**
 * 省市区三级联动数据
 *
 * @author 祝海亮 <liangh.zhu@gmail.com>
 *
 * @return array|mixed
 */
function get_province_list()
{
	$cache = S('province_list');
	if (!$cache) {
		// 获取省份
		$province = M('PositionProvince')->cache('province')->select();
		$city     = M('PositionCity')->cache('city')->select();
		$county   = M('PositionCounty')->cache('county')->select();

		$prefecture = array();
		array_walk($city, function($value,$key) use(&$prefecture){
			if ($value['city_name'] == '市辖区' ) {
				$prefecture[$value['province_id']] = $value['city_id'];
			}
		});
		$list = array();

		foreach ($province as $key => $value) {
			$list[$key]['p'] = $value['province_name'];
			$list[$key]['p_id'] = $value['province_id'];
			$i = 0;
			$j = 0;
			if (array_key_exists($value['province_id'],$prefecture)) {

				foreach ($county as $ke => $val) {
					if ($val['city_id'] == $prefecture[$value['province_id']]) {
						$list[$key]['c'][$i]['n'] = $val['county_name'];
						$list[$key]['c'][$i]['n_id'] = $val['county_id'];
						$i++;
					} else {
						$i = 0;
					}
				}

			} else {
				foreach ($city as $ke => $val) {
					if ($value['province_id'] == $val['province_id']) {
						$list[$key]['c'][$i]['n'] = $val['city_name'];
						$list[$key]['c'][$i]['n_id'] = $val['city_id'];
						foreach ($county as $k => $v) {
							if ($v['city_id'] == $val['city_id']) {
								if ($v['county_name'] != '市辖区') {
									$list[$key]['c'][$i]['a'][$j]['s'] = $v['county_name'];
									$list[$key]['c'][$i]['a'][$j]['s_id'] = $v['county_id'];
									$j++;
								}
							} else {
								$j = 0;
							}
						}
						$i++;
					} else {
						$i = 0;
					}
				}
			}
		}
		$data['citylist'] = $list;
		S('province_list',$data);
		return $list;
	} else {
		return $cache;
	}
}

/**
 * Debug 调试方法
 * @param     $data     数据
 * @param int $type     类型：默认 print_r
 * @param int $break    是否退出：默认退出
 *
 * @author 祝海亮 <liangh.zhu@gmail.com>
 *
 */
function dd($data , $type = 0, $break = 1)
{
	echo '<pre>';
	!empty($type) ? var_dump($data) : print_r($data);
	!empty($break) && exit();
}

/**
 * 数组进行整数映射转换
 * @param array $data 映射的数组
 * @param array $map  映射关系二维数组
 * @return array
 *
 * @author Kevin_ren <330202207@qq.com>
 */
function conversion_data($data, $map)
{
    if ($data === false || $data === null) {
        return $data;
    }
    foreach ($data as $key => $val) {
        foreach ($map as $i => $j) {
            if(isset($val[$i]) && isset($j[$val[$i]])) {
                $data[$key][$i.'_info'] = $j[$val[$i]];
            }
        }
    }
    return $data;
}

/**
 * 多维数组去重
 * @param array
 * @return array
 */
function super_unique($array)
{
	$result = array_map("unserialize", array_unique(array_map("serialize", $array)));

	foreach ($result as $key => $value)
	{
		if ( is_array($value) ) {
			$result[$key] = super_unique($value);
		}
	}

	return $result;
}

function sql(){
    echo M()->_sql();
}

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @author 朱亚杰 <zhuyajie@topthink.net>
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data, $map = array('status' => array(1 => '正常', -1 => '删除', 0 => '禁用', 2 => '未审核', 3 => '草稿'))){
  if($data === false || $data === null){
    return $data;
  }
  $data = (array) $data;
  foreach($data as $key => $row){
    foreach($map as $col => $pair){
      if(isset($row[$col]) && isset($pair[$row[$col]])){
        $data[$key][$col.'_text'] = $pair[$row[$col]];
      }
    }
  }
  return $data;
}


/**
 * 基于数组创建目录和文件
 * @param array $files 插件名
 */
function create_dir_or_files($files)
{
    foreach ($files as $key => $value) {
        if (substr($value, -1) == '/') {
            mkdir($value);
        } else {
            @file_put_contents($value, '');
        }
    }
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 */
function str2arr($str, $glue = ',')
{
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 */
function arr2str($arr, $glue = ',')
{
    return implode($glue, $arr);
}



/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 获取用户other
 * @param type $uid
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.10.18
 */
function get_member_oauth_type($uid){
    return M('MemberOauth')->getFieldByMemberId($uid, 'oauth_type');
}

/**
 * 获取用户信息
 * @param type $uid
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.8.23
 */
function get_member($uid = UID){
    $member_model = new \Member\Model\PassportModel;
    $member = $member_model->cache(false)->select();
    $member = array_column($member, null, 'id');
//    dd($member);
    return $uid ? $member[$uid] : null ;
}


/**
 * 获取省份信息
 * @param int|string $p 省份的名称或者id
 * @param string $field 指定省份的field
 * @author liym  <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.11.11
 */
function get_province($p, $field = ''){
    $province = M('Province')->cache(false)->select();
    $p = trim($p);
    if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $p)>0){
        $province = array_column($province, null, 'province_name');
    }else if(is_numeric($p)){
        $province = array_column($province, null, 'province_id');
    }
    return $p ? ($field ? $province[$p][$field] : $province[$p]) : "" ;
}


/**
 * 获取城市信息
 * @param int|string $c 城市名称或者id
 * @param string $field 指定市区的field的值
 * @author liym  <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.11.11
 */
function get_city($c, $field = ''){
    $city = M('city')->cache(false)->select();
    $c = trim($c);
    if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $c)>0){
        $city = array_column($city, null, 'city_name');
    }else if(is_numeric($c)){
        $city = array_column($city, null, 'city_id');
    }
    
    return $c ? ($field ? $city[$c][$field] : $city[$c]) : "";
}

/**
 * 获取市区信息
 * @param int|string $c 市区名称或者id
 * @param string $field 指定市区的field值
 * @author liym  <yanming.li1@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016.11.11
 */
function get_county($c, $field = ''){
    
    $county = M('County')->cache(false)->select();
    $c = trim($c);
    if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $c)>0){
        $county = array_column($county, null, 'county_name');
    }else if(is_numeric($c)){
        $county = array_column($county, null, 'county_id');
    }

    return $c ? ($field ? $county[$c][$field] : $county[$c]) : "" ;
}


