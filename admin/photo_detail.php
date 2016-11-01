<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_detail');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//评论
if ($_GET['action'] == 'rephoto') {
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
		//接受数据
		$_clean = array();
		$_clean['sid'] = $_POST['sid'];
		$_clean['title'] = $_POST['title'];
		$_clean['content'] = $_POST['content'];
		$_clean['username'] = $_COOKIE['username'];
		$_clean = _mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO tg_photo_commend (
																tg_sid,
																tg_username,
																tg_title,
																tg_content,
																tg_date
															)
											 VALUES (
											 					'{$_clean['sid']}',
											 					'{$_clean['username']}',
											 					'{$_clean['title']}',
											 					'{$_clean['content']}',
											 					NOW()
											 				)"
		);
		if (_affected_rows() == 1) {
			_query("UPDATE tg_photo SET tg_commendcount=tg_commendcount+1 WHERE tg_id='{$_clean['sid']}'");
			_close();
			_location('评论成功！','photo_detail.php?id='.$_clean['sid']);
		} else {
			_close();
			_alert_back('评论失败！');
		}
	} else {
		_alert_back('非法登录！');
	}
}
//取值
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_name,
																	tg_sid,
																	tg_url,
																	tg_username,
																	tg_readcount,
																	tg_commendcount,
																	tg_content,
																	tg_date
														FROM
																	tg_photo
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
	
		//防止加密相册图片穿插访问
		//可以先取得这个图片的sid，也就是它的目录，
		//然后再判断这个目录是否是加密的，
		//如果是加密的，再判断是否有对应的cookie存在，并且对于相应的值
		//管理员不受这个限制
		
		if (!isset($_SESSION['admin'])) {
			if (!!$_dirs = _fetch_array("SELECT tg_type,tg_id,tg_name FROM tg_dir WHERE tg_id='{$_rows['tg_sid']}'")) {
				if (!empty($_dirs['tg_type']) && $_COOKIE['photo'.$_dirs['tg_id']] != $_dirs['tg_name']) {
					_alert_back('非法操作！');
				}
			} else {
				_alert_back('相册目录表出错了！');
			}
		}
	
		
	
	
		//累积阅读量
		_query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
		
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['sid'] = $_rows['tg_sid'];
		$_html['name'] = $_rows['tg_name'];
		$_html['url'] = $_rows['tg_url'];
		$_html['username'] = $_rows['tg_username'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commendcount'] = $_rows['tg_commendcount'];
		$_html['date'] = $_rows['tg_date'];
		$_html['content'] = $_rows['tg_content'];
		$_html = _html($_html);
		
		//创建一个全局变量，做个带参的分页
		global $_id;
		$_id = 'id='.$_html['id'].'&';
		
		
		//读取评论
		global $_pagesize,$_pagenum,$_page;
		_page("SELECT tg_id FROM tg_photo_commend WHERE tg_sid='{$_html['id']}'",10); 
		$_result = _query("SELECT 
											tg_username,tg_title,tg_content,tg_date
								FROM 
											tg_photo_commend 
								WHERE
											tg_sid='{$_html['id']}'
						ORDER BY 
											tg_date ASC 
								 LIMIT 
											$_pagenum,$_pagesize
		");	
											
		//上一页，取得比自己大的ID中，最小的那个即可。
		$_html['preid'] = _fetch_array("SELECT 
																			min(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id>'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['preid']['id'])) {
			$_html['pre'] = '<a href="photo_detail.php?id='.$_html['preid']['id'].'#pre">上一页</a>';
		} else {
			$_html['pre'] = '<span>到头了</span>';
		}
		
		//下一页，取得比自己小的ID中，最大的那个即可。
		$_html['nextid'] = _fetch_array("SELECT 
																			max(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id<'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['nextid']['id'])) {
			$_html['next'] = '<a href="photo_detail.php?id='.$_html['nextid']['id'].'#next">下一页</a>';
		} else {
			$_html['next'] = '<span>到底了</span>';
		}
		
	} else {
		_alert_back('不存在此图片！');
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
<link rel="stylesheet" type="text/css" href="css/photo_detail.css" />
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>



<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
<div id="member_main">
	<h2>图片详情</h2>
	<a name="pre"></a><a name="next"></a>
	<dl class="detail">
		<dd class="name"><?php echo $_html['name']?></dd>
		<dt><?php echo $_html['pre']?><img src="<?php echo $_html['url']?>" width="450" height="550" /><?php echo $_html['next']?></dt>
		<dd>[<a href="photo_show.php?id=<?php echo $_html['sid']?>">返回列表</a>]</dd>
		<dd>浏览量(<strong><?php echo $_html['readcount'];?></strong>) 评论量(<strong><?php echo $_html['commendcount'];?></strong>) 发表于：<?php echo $_html['date']?> 上传者：<?php echo $_html['username']?></dd>
		<dd>简介：<?php echo $_html['content']?></dd>
	</dl>
</div>
</div>


</body>
</html>
