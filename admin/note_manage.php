<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','note_manage');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php'; //转换成硬路径，速度更快
//判断是否登录了
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}
global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_article WHERE tg_reid=0",15);
//读取帖子列表
	$_result = _query("SELECT
			tg_id,tg_title,tg_type,tg_readcount,tg_commendcount,tg_content,tg_date,tg_classify,tg_image
			FROM
			tg_article
			WHERE
			tg_reid=0
			ORDER BY
			tg_date DESC
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
					_location('日志删除成功','note_manage.php');
		} else {
				_close();
				_alert_back('日志删除失败');
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
		<h2>日志管理中心</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>勾选操作</th><th>日志标题</th><th>所属分类</th><th>浏览量</th><th>是否修改</th></tr>
			<?php 
				$_htmllist = array();
				while (!!$_rows = _fetch_array_list($_result)) {

					$_htmllist['id'] = $_rows['tg_id'];
					$_htmllist['type'] = $_rows['tg_type'];
					$_htmllist['readcount'] = $_rows['tg_readcount'];
					$_htmllist['commendcount'] = $_rows['tg_commendcount'];
					$_htmllist['title'] = $_rows['tg_title'];
					$_htmllist['image'] = $_rows['tg_image'];
					$_htmllist["content"] = $_rows['tg_content'];
					$_htmllist['date'] = $_rows['tg_date'];
					$_htmllist['classify'] = $_rows['tg_classify'];
					$_htmllist = _html($_htmllist);
					$_str = _getClassify($_htmllist['classify']);
					
					echo '<tr>';
					echo '<td><input name="ids[]" value="'.$_htmllist['id'].'" type="checkbox" /></td>';
					echo '<td><a href="../article_detail.php?id='.$_htmllist['id'].'" target="_blank">'.$_htmllist['title'].'</a></td>';
					echo '<td>'.$_str.'</td>';
					echo '<td>'.$_htmllist['readcount'].'</td>';
					echo '<td><a href="./article_modify.php?id='.$_htmllist['id'].'" target="_blank">修改</a></td>';
				    echo '</tr>';
				   
// 				    if ($_html['username_subject'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
// 				    	$_html['subject_modify'] = '[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
// 				    }
				    
				}
				_free_result($_result);
			?>
		
			
			<tr><td colspan="5"><label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label><input type="submit" value="批删除" /></td></tr>
		</table>
		</form>
		<?php _paging(1,2);?>
	</div>
</div>




</body>
</html>
