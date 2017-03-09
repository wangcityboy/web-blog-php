<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','post');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//登陆后才可以发帖
if (!isset($_COOKIE['username'])) {
	_location('发帖前，必须登录','index.php');
}
//将帖子写入数据库
if ($_GET['action'] == 'post') {
	if (!!$_rows = _fetch_array("SELECT 
																tg_post_time
													FROM 
																tg_user 
												 WHERE 
																tg_username='{$_COOKIE['username']}' 
													 LIMIT 
																1"
		)) {
		global $_system;
		//为了防止cookies伪造，还要比对一下唯一标识符uniqid()
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//验证一下是否在规定的时间外发帖
// 		_timed(time(),$_rows['tg_post_time'],$_system['post']);
		include ROOT_PATH.'common/check.func.php';
		//接受帖子内容
		
		$_clean = array();
		$_clean['username'] = $_COOKIE['username'];
		$_clean['classify'] = $_POST['classify'];
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean['image'] = $_POST['imagepath'];
		$_clean['content'] = _check_post_content($_POST['content'],10);
		$_clean = _mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_article (
																tg_classify,
																tg_username,
																tg_title,
																tg_image,
																tg_content,
																tg_date
															) 
											VALUES (
																'{$_clean['classify']}',
																'{$_clean['username']}',
																'{$_clean['title']}',
																'{$_clean['image']}',
																'{$_clean['content']}',
																NOW()
															)
		");
		if (_affected_rows() == 1) {
			$_clean['id'] = _insert_id();
			$_clean['time'] = time();
			_query("UPDATE tg_user SET tg_post_time='{$_clean['time']}' WHERE tg_username='{$_COOKIE['username']}'");
			_close();
// 			_location('帖子发表成功！','../article.php?id='.$_clean['id']);
			_location('帖子发表成功', './note_manage.php');
		} else {
			_close();
			_alert_back('帖子发表失败！');
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/post.css" />
<script type="text/javascript" src="js/post.js"></script>

<link rel="stylesheet" href="../editor/themes/default/default.css" />
<script charset="utf-8" src="../editor/kindeditor-min.js"></script>
<script charset="utf-8" src="../editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="../editor/kindeditor.js"></script>

<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
</script>
		
			
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
	<form method="post" id="post" name="post" action="?action=post">
		<dl>
			<dt>请认真填写一下内容</dt>
			<dd>日志分类：
			<select name="classify" id="select">
				<option value="10007"selected="selected">iOS开发</option>  
				<option value="10008">安卓开发</option>
				<option value="10009">前端开发</option>
				<option value="10010">后台开发</option>
				<option value="10011">测试开发</option>						
				<option value="10012">信息技术</option>		
				<option value="10013">生活随笔</option>
				<option value="10014">网络文摘</option>
			</select>
			</dd>
			
			<dd>标　　题：<input type="text" name="title" class="text" /> (*必填，2-40位)</dd>
			
			<dd><p>角色扮演：<input type="text" id="url1" name="imagepath" value="" /> <input type="button" id="image1" value="选择图片" />（245*200）</p></dd>
			
			<dd>
				<textarea name="content" style="width:99%;height:550px;visibility:hidden;"></textarea>
			</dd>
			<input type="submit" class="submit" value="发表帖子" /></dd>
		</dl>
	</form>
</div>
</div>

</body>
</html>