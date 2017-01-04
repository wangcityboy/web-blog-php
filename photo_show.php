<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_show');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

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

$_result = _query("SELECT 
												tg_id,tg_username,tg_name,tg_url,tg_readcount,tg_commendcount 
									FROM 
												tg_photo 
									WHERE
												tg_sid='{$_dirhtml['id']}'
							ORDER BY 
												tg_date DESC 
									 
							");		


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
	require ROOT_PATH.'includes/background.inc.php';
?>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript" src="js/bigimg.js"></script>
<script type="text/javascript" src="js/jquery.lazyload.min.js" ></script>
<script type="text/javascript" src="js/blocksit.min.js"></script>
<script type="text/javascript" src="js/photo.js"></script>
<link rel="stylesheet" href="styles/pubu.css" type="text/css" media='screen'/>
</head>

<body>
<div id="wrapper">
	<div id="container" style="width:1000px;">
	
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
	
	<div class="grid">
		<div class="imgholder">
			<a href="photo_detail.php?id=<?php echo $_html['id']?>"> <img class="lazy thumb_photo" title="1" src="images/pixel.gif" data-original="<?php echo $_html['url']?>" width="225"/></a>
		</div>
	</div>

	<?php }
	?>
	<?php 
	} else {
		echo '<form method="post" action="photo_show.php?id='.$_dirhtml['id'].'">';
		echo '<p>请输入相册密码：<input type="password" name="password" /> <input type="submit" value="确认" /></p>';
		echo '</form>';
	}
	?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
