<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member');
//设置字符集编码
header('Content-Type: text/html; charset=utf-8');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//是否正常登录
if (isset($_COOKIE['username'])) {	
	//获取数据
	$_rows = _fetch_array("SELECT
			tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq,tg_level,tg_reg_time
			FROM
			tg_user
			WHERE
			tg_username='{$_COOKIE['username']}'
			LIMIT
			1
			");
			if ($_rows) {
			$_html= array();
			$_html['username'] = $_rows['tg_username'];
			if ($_rows['tg_sex'] == 1){
				$_html['sex'] = "男";
			}else{
				$_html['sex'] = "女";
			}
			$_html['face'] = $_rows['tg_face'];
			$_html['email'] = $_rows['tg_email'];
			$_html['url'] = $_rows['tg_url'];
			$_html['qq'] = $_rows['tg_qq'];
		$_html['reg_time'] = $_rows['tg_reg_time'];
			switch ($_rows['tg_level']) {
			case 0:
				$_html['level'] = '普通会员';
					break;
			case 1:
			$_html['level'] = '管理员';
					break;
					default:
					$_html['level'] = '出错';
			}
			$_html = _html($_html);
	} else {
		_alert_back('此用户不存在');
		}
	
}else{
	_alert_back('非法登录');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/member.css" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
</head>
<body>


<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
	<div id="member_main">
		<h2>网站后台中心</h2>
		<dl>
			<dd>用 户 名：<?php echo $_html['username']?></dd>
			<dd>性　　别：<?php echo $_html['sex']?></dd>
			<dd>头　　像：<?php echo $_html['face']?></dd>
			<dd>电子邮件：<?php echo $_html['email']?></dd>
			<dd>主　　页：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
			<dd>Q 　 　Q：<?php echo $_html['qq']?></dd>
			<dd>注册时间：<?php echo $_html['reg_time']?></dd>
			<dd>身　　份：<?php echo $_html['level']?></dd>
		</dl>
	</div>
</div>


</body>
</html>
