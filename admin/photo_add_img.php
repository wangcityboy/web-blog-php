<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_add_img');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//这张页面必须会员
if (!$_COOKIE['username']) {
	_alert_back('非法登录！');
}
//保存图片信息入表
if ($_GET['action'] == 'addimg') {
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
		include 'common/check.func.php';
		//接收数据
		$_clean = array();
		$_clean['name'] = _check_dir_name($_POST['name'],2,20);
		$_clean['url'] = _check_photo_url($_POST['imagepath']);
		$_clean['content'] = $_POST['content'];
		$_clean['sid'] = $_POST['sid'];
		$_clean = _mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_photo (
																	tg_name,
																	tg_url,
																	tg_content,
																	tg_sid,
																	tg_username,
																	tg_date
															) 
											VALUES (	
																	'{$_clean['name']}',
																	'{$_clean['url']}',
																	'{$_clean['content']}',
																	'{$_clean['sid']}',
																	'{$_COOKIE['username']}',
																	NOW()
															)"
		);
		if (_affected_rows() == 1) {
			_close();
			_location('图片添加成功！','photo_show.php?id='.$_clean['sid']);
		} else {
			_close();
			_alert_back('图片添加失败！');
		}
	} else {
		_alert_back('非法登录！');
	}
}
//取值
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_dir
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['dir'] = $_rows['tg_dir'];
		$_html = _html($_html);
	} else {
		_alert_back('不存在此相册！');
	}
} else {
	_alert_back('非法操作！');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/photo_add_img.css" />
<script type="text/javascript" src="js/photo_add_img.js"></script>

<link rel="stylesheet" href="../editor/themes/default/default.css" />
<script charset="utf-8" src="../editor/kindeditor-min.js"></script>
<script charset="utf-8" src="../editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="../editor/kindeditor.js"></script>


		
			
<script>
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#image1').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					imageUrl : K('#url1').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#url1').val(url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>


</head>
<body>

<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
<div id="member_main">
  <div id="form">
	<h2>上传图片</h2>
	<form method="post" class="form" name="up" action="?action=addimg">
	<input type="hidden" name="sid" value="<?php echo $_html['id']?>" />
	<dl>
		<dd>图片名称：<input type="text" name="name" class="text" /></dd>
		
		<dd>图片地址：<input type="text" name="imagepath" id="url1"  readonly="readonly" class="text" /> 
		<input type="button" id="image1" value="选择图片" /></dd>
		
		<dd>图片描述：<textarea name="content"></textarea></dd>
		<dd><input type="submit" class="submit" value="添加图片" /></dd>
	</dl>
	</form>
	</div>
</div>
</div>

</body>
</html>
