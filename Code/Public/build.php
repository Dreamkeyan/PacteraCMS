<?php
$module = $_REQUEST['module'];
if(empty($module)){
    echo "请在URL里面拼接?module=***参数";
    exit();
}else{
    $module = ucfirst(strtolower($module));
    define('BIND_MODULE', $module);
    require './index.php';
}

