<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/manage.css" />
</head>
<body>


<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
	<div id="member_main">
		<h2>后台管理中心</h2>
		<dl>
			<dd>服务器主机名称：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
			<dd>服务器版本：<?php echo $_ENV['OS'] ?></dd>
			<dd>通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
			<dd>服务器IP：<?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
			<dd>客户端IP：<?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
			<dd>服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
			<dd>客户端端口：<?php echo $_SERVER["REMOTE_PORT"]; ?></dd>
			<dd>管理员邮箱：<?php echo $_SERVER['SERVER_ADMIN'] ?></dd>
			<dd>Host头部的内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
			<dd>服务器主目录：<?php echo $_SERVER["DOCUMENT_ROOT"]; ?></dd>
			<dd>服务器系统盘：<?php echo $_ENV["SystemRoot"]; ?></dd>
			<dd>脚本执行的绝对路径：<?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
			<dd>Apache及PHP版本：<?php echo $_SERVER["SERVER_SOFTWARE"]; ?></dd>
		</dl>
	</div>
</div>



</body>
</html>
