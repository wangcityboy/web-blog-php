<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article_modify');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//登陆后才可以发帖
if (!isset($_COOKIE['username'])) {
	_location('发帖前，必须登录','index.php');
}
//修改,还需要判断一下权限
if ($_GET['action'] == 'modify') {
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
		
		//开始修改
		include ROOT_PATH.'common/check.func.php';
		$_clean = array();
		$_clean['id'] = $_POST['id'];
		$_clean['classify'] = $_POST['classify'];
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean['image'] = $_POST['imagepath'];
		$_clean['content'] = _check_post_content($_POST['content'],10);
		$_clean = _mysql_string($_clean);
		
		//执行SQL
		_query("UPDATE tg_article SET 
																tg_classify='{$_clean['classify']}',
																tg_title='{$_clean['title']}',
																tg_image='{$_clean['image']}',
																tg_content='{$_clean['content']}',
																tg_last_modify_date=NOW()
													WHERE
																tg_id='{$_clean['id']}'
		");
		if (_affected_rows() == 1) {
			_close();
			//_session_destroy();
			_location('帖子修改成功！','../article.php?id='.$_clean['id']);
		} else {
			_close();
			//_session_destroy();
			_alert_back('帖子修改失败！');
		}
	} else {
		_alert_back('非法登录！');
	}
}
//读取数据



if (isset($_GET['id'])) {
		if (!!$_rows = _fetch_array("SELECT 
																	tg_classify,
																	tg_username,
																	tg_title,
																	tg_image,
																	tg_type,
																	tg_content
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
			$_html = array();
			$_html['id'] = $_GET['id'];
			$_html['classify'] = $_rows['tg_classify'];
			$_html['username'] = $_rows['tg_username'];
			$_html['title'] = $_rows['tg_title'];
			$_html['image'] = $_rows['tg_image'];
			$_html['content'] = $_rows['tg_content'];
			$_html = _html($_html);	

			
			
			$_para = $_html['classify'];
			echo "<script>var para=\"$_para\";</script>";
			//判断权限
// 			if (!$_SESSION['admin']) {
// 				if ($_COOKIE['username'] != $_html['username']) {
// 					_alert_back('你没有权限修改！');
// 				}
// 			}
			
		} else {
			_alert_back('不存在此帖子！');
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
<script type="text/javascript" src="js/post.js"></script>
<link rel="stylesheet" type="text/css" href="css/article_modify.css" />
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

<script>
	
	window.onload = function(){
        var opts = document.getElementById("select");
        var value = para;
	 for(var i=0;i<opts.options.length;i++){
	           if(value==opts.options[i].value){
	                  opts.options[i].selected = 'selected';
	                   break;
	           }
          }
}
</script>


</head>
<body>


	<div id="post">
		<form method="post" name="post" action="?action=modify">
			<input type="hidden" value="<?php echo $_html['id']?>" name="id" />
			<dl>
			
				<dt>请认真修改以下内容</dt>
				<dd>
					日志分类： 
					<select name="classify" id="select">
						<option value="1">iOS开发</option>
						<option value="2">安卓开发</option>
						<option value="3">后台开发</option>
						<option value="4">前端开发</option>
						<option value="5">测试开发</option>						
						<option value="6">IT技术</option>		
						<option value="7">生活随笔</option>
						<option value="8">网络文摘</option>
					</select>
				
     
     

				</dd>
				<dd>
					标 题：<input type="text" name="title"
						value="<?php echo $_html['title']?>" class="text" /> (*必填，2-40位)
				</dd>
				<dd>
					<p>
						角色扮演：<input type="text" id="url1" name="imagepath"
							value="<?php echo $_html['image']?>" /> <input type="button"
							id="image1" value="选择图片" />（网络图片 + 本地上传）
					</p>
				</dd>
				<dd>
					<textarea name="content"
						style="width: 100%; height: 500px; visibility: hidden;"><?php echo htmlspecialchars_decode($_html['content'])?></textarea>
				</dd>
				<input type="submit" class="submit" value="修改帖子" />
				</dd>
			</dl>
		</form>
	</div>


</body>
</html>