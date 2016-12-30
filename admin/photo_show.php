<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_show');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//删除相片

if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
	
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
		
		//取得这张图片的发布者
		if (!!$_rows = _fetch_array("SELECT 
																		tg_username,
																		tg_url,
																		tg_id,
																		tg_sid
															FROM 
																		tg_photo 
														 WHERE 
																		tg_id='{$_GET['id']}' 
															 LIMIT 
																		1"
		)) {
			$_html = array();
			$_html['id'] = $_rows['tg_id'];
			$_html['sid'] = $_rows['tg_sid'];
			$_html['username'] = $_rows['tg_username'];
			$_html['url'] = $_rows['tg_url'];
			
			$_html = _html($_html);
			//判断删除图片的身份是否合法
			if ($_html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
				
				//首先删除图片的数据库信息
				_query("DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'");
				if (_affected_rows() == 1) {
					//删除图片物理地址
// 					if (file_exists($_html['url'])) {
// 						unlink($_html['url']);
// 					} else {
// 						_alert_back('磁盘里已不存在此图！');
// 					}
					_close();
					_location('图片删除成功！','photo_show.php?id='.$_html['sid']);
				} else {
					_close();
					_alert_back('删除失败！');
				}
			} else {
				_alert_back('非法操作！');
			}
		} else {
			_alert_back('不存在此图片！');
		}
	} else {
		_alert_back('非法登录！');
	}
}


//取值
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,tg_name,tg_type
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
		$_dirhtml = array();
		$_dirhtml['id'] = $_rows['tg_id'];
		$_dirhtml['name'] = $_rows['tg_name'];
		$_dirhtml['type'] = $_rows['tg_type'];
		$_dirhtml = _html($_dirhtml);
		//对比加密相册的验证信息
		if ($_POST['password']) {
			if (!!$_rows = _fetch_array("SELECT 
																tg_id
													FROM
																tg_dir
													WHERE
																tg_password='".sha1($_POST['password'])."'
													LIMIT
																1
			")) {
				//生成cookie
				setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
				//重定向
				_location(null,'photo_show.php?id='.$_dirhtml['id']);
			} else {
				_alert_back('相册密码不正确!');
			}
		}
	} else {
		_alert_back('不存在此相册！');
	}
} else {
	_alert_back('非法操作！');
}
$_percent = 0.2;
global $_pagesize,$_pagenum,$_system,$_id;
$_id = 'id='.$_dirhtml['id'].'&';
_page("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}'",6); 
$_result = _query("SELECT 
												tg_id,tg_username,tg_name,tg_url,tg_readcount,tg_commendcount 
									FROM 
												tg_photo 
									WHERE
												tg_sid='{$_dirhtml['id']}'
							ORDER BY 
												tg_date DESC 
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
<link rel="stylesheet" type="text/css" href="css/photo_show.css" />
</head>

<body>
<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
<div id="member_main">
	<h2><?php echo $_dirhtml['name'];?></h2>	
	<?php 
	
	if (empty($_dirhtml['type']) || $_COOKIE['photo'.$_dirhtml['id']] == $_dirhtml['name'] || isset($_SESSION['admin'])) {
		$_html = array();
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['id'] = $_rows['tg_id'];
			$_html['username'] = $_rows['tg_username'];
			$_html['name'] = $_rows['tg_name'];
			$_html['url'] = $_rows['tg_url'];
			$_html['readcount'] = $_rows['tg_readcount'];
			$_html['commendcount'] = $_rows['tg_commendcount'];
			$_html = _html($_html);
	?>
	<dl>
		<dt><a href="photo_detail.php?id=<?php echo $_html['id']?>"><img src="<?php echo $_html['url']?>" width="230" height="270"/></a></dt>
		<?php 
			if ($_html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
		?>
		
		<dd><p><a href="photo_show.php?action=delete&id=<?php echo $_html['id']?>">删除</a></p></dd>
		<?php }?>
	</dl>
	<?php }
		_free_result($_result);
		_paged(1);
	?>
	<p><a href="photo_add_img.php?id=<?php echo $_dirhtml['id']?>">上传图片</a></p>

	<?php 
	} else {
		echo '<form method="post" action="photo_show.php?id='.$_dirhtml['id'].'">';
		echo '<p>请输入密码：<input type="password" name="password" /> <input type="submit" value="确认" /></p>';
		echo '</form>';
	}
	?>

</div>


</div>


</body>
</html>
