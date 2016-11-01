<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//删除目录
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
		//删除目录
		if (!!$_rows = _fetch_array("SELECT 
																		tg_dir
															FROM 
																		tg_dir 
														 WHERE 
																		tg_id='{$_GET['id']}' 
															 LIMIT 
																		1"
		)) {
			$_html = array();
			$_html['url'] = $_rows['tg_dir'];
			$_html = _html($_html);

			//3.删除磁盘的目录
			if (file_exists($_html['url'])) {
				
				if (_remove_Dir($_html['url'])) {
					
					//1.删除目录里的数据库图片
					_query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
					//2.删除这个目录的数据库
					_query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
					_close();
					_location('目录删除成功!','photo.php');
				} else {
					_close();
					_alert_back('目录删除失败!');
				}
			}else {
			//2.删除这个目录的数据库
			_query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
			_close();
			_location('目录删除成功!','photo.php');	
		}
		
		} else{
			
			_close();
			_location('目录删除成功!','photo.php');
			
		}
	} else {
		_alert_back('非法登录！');
	}
}
//读取数据
global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_dir",4);
$_result = _query("SELECT 
												tg_id,tg_name,tg_type,tg_face
									FROM 
												tg_dir 
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
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/photo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>

<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
<div id="member_main">
	<h2>相册列表</h2>
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
			if (empty($_html['face'])) {
				$_html['face_html'] = '';
			} else {
				$_html['face_html'] = '<img src="'.$_html['face'].'" alt="'.$_html['tg_name'].'" />';
			}
			//统计相册里的照片数量
			$_html['photo'] = _fetch_array("SELECT COUNT(*) AS count FROM tg_photo WHERE tg_sid={$_html['id']}");
		?>
		
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['face_html'];?></a></dt>
		<dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name']?> <?php echo '['.$_html['photo']['count'].']'.$_html['type_html'] ?></a></dd>
		<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
		<dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id']?>">修改</a>] [<a href="photo.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
		<?php }?>
	</dl>
	<?php }
	_paging(1,1);?>
	
	<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
	<p><a href="photo_add_dir.php">添加目录</a></p>
	<?php }?>
</div>
</div>

</body>
</html>
