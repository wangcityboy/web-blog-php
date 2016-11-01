<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','note_manage');

//引入公共文件
require dirname(__FILE__).'/common/common.inc.php'; //转换成硬路径，速度更快



global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_user",10);
//读取帖子列表
	$_result = _query("SELECT
			tg_id,tg_username,tg_email,tg_qq,tg_url,tg_sex,tg_level,tg_last_time,tg_last_ip,tg_login_count
			FROM
			tg_user

			ORDER BY
			tg_id DESC
			LIMIT
			$_pagenum,$_pagesize
			");
	
	if ($_GET['action'] == 'delete' && isset($_POST['ids'])) {
		$_clean = array();
		$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
		//危险操作，为了防止cookies伪造，还要比对一下唯一标识符uniqid()
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
				_query("DELETE FROM
				tg_article
				WHERE
				tg_id
				IN
						({$_clean['ids']})"
		);
				
		if (_affected_rows()) {
					_close();
					_location('用户删除成功','note_manage.php');
		} else {
				_close();
				_alert_back('用户删除失败');
				}
		} else {
		_alert_back('非法登录');
		}
				}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/note_manage.css" />
</head>
<body>


  
<div id="member">
	<?php 
		require ROOT_PATH.'common/member.inc.php';
	?>
	
	<div id="member_main">
		<h2>用户管理中心</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>操作</th><th>用户名</th><th>性别</th><th>Email</th><th>QQ</th><th>主页</th><th>最后登录时间</th><th>登录IP</th><th>登录次数</th></tr>
			<?php 
				$_htmllist = array();
				while (!!$_rows = _fetch_array_list($_result)) {

					$_htmllist['id'] = $_rows['tg_id'];
					$_htmllist['username'] = $_rows['tg_username'];
					$_htmllist['sex'] = $_rows['tg_sex'];
					$_htmllist['email'] = $_rows['tg_email'];
					$_htmllist['qq'] = $_rows['tg_qq'];
					$_htmllist["url"] = $_rows['tg_url'];
					$_htmllist['lasttime'] = $_rows['tg_last_time'];
					$_htmllist['lastip'] = $_rows['tg_last_ip'];
					$_htmllist['logincount'] = $_rows['tg_login_count'];
					$_htmllist = _html($_htmllist);

					
					echo '<tr>';
					echo '<td><input name="ids[]" value="'.$_htmllist['id'].'" type="checkbox" /></td>';
					echo '<td>'.$_htmllist['username'].'</td>';
					echo '<td>'.$_htmllist['sex'].'</td>';
					echo '<td>'.$_htmllist['email'].'</td>';
					echo '<td>'.$_htmllist['qq'].'</td>';
					echo '<td>'.$_htmllist['url'].'</td>';
					echo '<td>'.$_htmllist['lasttime'].'</td>';
					echo '<td>'.$_htmllist['lastip'].'</td>';
					echo '<td>'.$_htmllist['logincount'].'</td>';
				    echo '</tr>';
				   
				}
				_free_result($_result);
			?>
			<?php _paged(2);?>
			<tr><td colspan="9"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="批删除" /></td></tr>
		</table>
		</form>
	
	</div>
</div>




</body>
</html>

