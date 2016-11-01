<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage_member');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//必须是管理员才能登录
_manage_login();
global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user",15); 
$_result = _query("SELECT 
															tg_id,
															tg_username,
															tg_email,
															tg_reg_time
									FROM 
												tg_user 
							ORDER BY 
												tg_reg_time DESC 
									 LIMIT 
												$_pagenum,$_pagesize
							");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/manage_member.css" />
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>


<div id="member">

	<div id="member_main">
		<h2>会员列表中心</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
			<?php 
					$_html = array();
					while (!!$_rows = _fetch_array_list($_result)) {
						$_html['id'] = $_rows['tg_id'];
						$_html['username'] = $_rows['tg_username'];
						$_html['email'] = $_rows['tg_email'];
						$_html['reg_time'] = $_rows['tg_reg_time'];
						$_html = _html($_html);
			?>
			<tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td><td>[<a href="?action=del&id=<?php echo $_html['id']?>">删</a>] [修]</td></tr>
			<?php }?>
			</table>
		</form>
		<?php 
			_free_result($_result);
			_paging(1,2);
		?>
	</div>
</div>


</body>
</html>