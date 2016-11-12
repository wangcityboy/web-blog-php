<?php
//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//设置字符集编码
header('Content-Type: text/html; charset=utf-8');

//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//创建一个自动转义状态的常量
define('GPC',get_magic_quotes_gpc());

//拒绝PHP低版本
if (PHP_VERSION < '4.1.0') {
	exit('Version is to Low!');
}

//引入函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//执行耗时
define('START_TIME',_runtime());
//$GLOBALS['start_time'] = _runtime();

//数据库连接
define('DB_HOST','127.0.0.1:3306');
define('DB_USER','root');
define('DB_PWD','KeYpZrZx');
define('DB_NAME','guest');


//初始化数据库
_connect();   //连接MYSQL数据库
_select_db();   //选择指定的数据库
_set_names();   //设置字符集

//短信提醒COUNT(tg_id)是取得字段的总和
$_message = _fetch_array("SELECT 
																COUNT(tg_id) 
														AS 
																count 
													FROM 
																tg_message 
												 WHERE 
												 				tg_state=0
												 	   AND
												 	   			tg_touser='{$_COOKIE['username']}'
");

if (empty($_message['count'])) {
	$GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
} else {
	$GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
}


//网站系统设置初始化
if (!!$_rows = _fetch_array("SELECT 
															tg_webname,
															tg_article,
															tg_blog,
															tg_photo,
															tg_skin,
															tg_string,
															tg_post,
															tg_re,
															tg_code,
															tg_register 
												FROM 
															tg_system 
											 WHERE 
															tg_id=1 
												 LIMIT 
															1"
)) {
	$_system = array();
	$_system['webname'] = $_rows['tg_webname'];
	$_system['article'] = $_rows['tg_article'];
	$_system['blog'] = $_rows['tg_blog'];
	$_system['photo'] = $_rows['tg_photo'];
	$_system['skin'] = $_rows['tg_skin'];
	$_system['post'] = $_rows['tg_post'];
	$_system['re'] = $_rows['tg_re'];
	$_system['code'] = $_rows['tg_code'];
	$_system['register'] = $_rows['tg_register'];
	$_system['string'] = $_rows['tg_string'];
	$_system = _html($_system);
	
	
} else {
	exit('系统表异常，请管理员检查！');
}

?>