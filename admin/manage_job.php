<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage_job');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//必须是管理员才能登录
_manage_login();
//添加管理员
if ($_GET['action'] == 'add') {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
	)) {
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			$_clean = array();
			$_clean['username'] = $_POST['manage'];
			$_clean = _mysql_string($_clean);
			//添加管理员
			_query("UPDATE tg_user SET tg_level=1 WHERE tg_username='{$_clean['username']}'");
			if (_affected_rows() == 1) {
				_close();
				_location('恭喜你，管理员添加成功！',SCRIPT.'.php');
			} else {
				_close();
				_alert_back('管理员添加失败！原因：不存在此用户或者为空');
			}
		}  else {
			_alert_back('非法登录！');
		}
}
//辞职
if ($_GET['action'] == 'job' && isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
	)) {
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			//辞职
			_query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' AND tg_id='{$_GET['id']}'");
			if (_affected_rows() == 1) {
				_close();
				_session_destroy();
				_location('辞职成功！','index.php');
			} else {
				_close();
				_alert_back('辞职失败！');
			}
	} else {
		_alert_back('非法登录！');
	}
}

global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user WHERE tg_level=1",15); 
$_result = _query("SELECT 
															tg_id,
															tg_username,
															tg_email,
															tg_reg_time
									FROM 
												tg_user 
								WHERE 
												tg_level=1
							ORDER BY 
												tg_reg_time DESC 
									 LIMIT 
												$_pagenum,$_pagesize
							");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/manage_job.css" />
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>

<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
	<div id="member_main">
		<h2>会员列表中心</h2>
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
						if ($_COOKIE['username'] == $_html['username']) {
							$_html['job_html'] = '<a href="manage_job.php?action=job&id='.$_html['id'].'">辞职</a>';
						} else {
							$_html['job_html'] = '无权操作！';
						}
			?>
			<tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td><td><?php echo $_html['job_html']?></td></tr>
			<?php }?>
			</table>
			<form method="post" action="?action=add">
				<input type="text" name="manage" class="text" /> <input type="submit" value="添加管理员" />
			</form>
		<?php 
			_free_result($_result);
			_paging(2);
		?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>