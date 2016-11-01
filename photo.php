<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//读取数据
global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_dir",8);
$_result = _query("SELECT 
												tg_id,tg_name,tg_type,tg_face
									FROM 
												tg_dir 
							ORDER BY 
												tg_date DESC 
									 
							");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/notification.js"></script>
<script type="text/javascript" src="js/jquery.lazyload.min.js" ></script>
<script type="text/javascript" src="js/blocksit.min.js"></script>
<script type="text/javascript" src="js/photo.js"></script>
</head>


<body>

<div id="wrapper">
	<div id="container" style="width:1000px;">
	<?php 
		$_html = array();
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['id'] = $_rows['tg_id'];
			$_html['name'] = $_rows['tg_name'];
			$_html['type'] = $_rows['tg_type'];
			$_html['face'] = $_rows['tg_face'];
			$_html = _html($_html);
			if (empty($_html['type'])) {
				$_html['type_html'] = '(公开)';
			} else {
				$_html['type_html'] = '(私密)';
			}
			//统计相册里的照片数量
			$_html['photo'] = _fetch_array("SELECT COUNT(*) AS count FROM tg_photo WHERE tg_sid={$_html['id']}");
		?>
	
	<div class="grid">
		<div class="imgholder">
			<a href="photo_show.php?id=<?php echo $_html['id']?>"><img class="lazy thumb_photo" title=<?php echo $_html['name']?> src="images/pixel.gif" data-original=<?php echo $_html['face'];?> width="225"/></a>
			<a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name']?> <?php echo '['.$_html['photo']['count'].']'.$_html['type_html'] ?></a>
		</div>
	</div>
	<?php }?>
	
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>


</body>
</html>
