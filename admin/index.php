<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);

//定义个常量，用来指定本页的内容
define('SCRIPT','index');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//登录状态
_login_state();
//开始处理登录状态
if ($_GET['action'] == 'login') {
	
	//引入验证文件
	include ROOT_PATH.'/common/login.func.php';
	
	//接受数据
	$_clean = array();
	$_clean['username'] = _check_username($_POST['username'],2,20);
	$_clean['password'] = _check_password($_POST['password'],6);
	$_clean['time'] = _check_time($_POST['time']);
	
	//到数据库去验证
	if (!!$_rows = _fetch_array("SELECT tg_username,tg_level FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}'  LIMIT 1")) {
		//登录成功后，记录登录信息
		_query("UPDATE tg_user SET 
															tg_last_time=NOW(),
															tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
															tg_login_count=tg_login_count+1
												WHERE 
															tg_username='{$_rows['tg_username']}'				
													");

		_setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time']);
		
		if ($_rows['tg_level'] == 1) {
			$_SESSION['admin'] = $_rows['tg_username'];
		}
		_close();
		
		_location(1,'manage.php');
	} else {
		_close();
		_location('用户名密码不正确或者该账户未被激活！','login.php');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
<script type="text/javascript" src="./js/login.js"></script>
</head>
<body>



<div id="login">
	<h2>＝＝＝＝＝管理员登录＝＝＝＝＝</h2>
	<form method="post" name="login" action="index.php?action=login">
		<dl>
			<dt></dt>
			<dd>帐号：<input type="text" name="username" class="text" /></dd>
			<dd>密码：<input type="password" name="password" class="text" /></dd>
			<dd>保留：<input type="radio" name="time" value="0" checked="checked" />不保留
			<input type="radio" name="time" value="1" />一天 
			<input type="radio" name="time" value="2" />一周 
			<input type="radio" name="time" value="3" />一月
			</dd>
			<dd><button type="submit" >登录后台</button></dd>
		</dl>
	</form>
</div>


</body>
</html>




