<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_modify');
//引入公共文件
require dirname(__FILE__).'/common/common.inc.php';
//修改资料
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
		//为了防止cookies伪造，还要比对一下唯一标识符uniqid()
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include ROOT_PATH.'common/check.func.php';
		$_clean = array();
		$_clean['password'] = _check_modify_password($_POST['password'],6);
		$_clean['sex'] = _check_sex($_POST['sex']);
		$_clean['face'] = _check_face($_POST['face']);
		$_clean['email'] = _check_email($_POST['email'],6,40);
		$_clean['qq'] = _check_qq($_POST['qq']);
		$_clean['url'] = _check_url($_POST['url'],40);
		$_clean['switch'] = $_POST['switch'];
		$_clean['autograph'] = _check_autograph($_POST['autograph'],200);
		
		//修改资料
		if (empty($_clean['password'])) {
			_query("UPDATE tg_user SET 
																tg_sex='{$_clean['sex']}',
																tg_face='{$_clean['face']}',
																tg_email='{$_clean['email']}',
																tg_qq='{$_clean['qq']}',
																tg_url='{$_clean['url']}',
																tg_switch='{$_clean['switch']}',
																tg_autograph='{$_clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
		} else {
			_query("UPDATE tg_user SET 
																tg_password='{$_clean['password']}',
																tg_sex='{$_clean['sex']}',
																tg_face='{$_clean['face']}',
																tg_email='{$_clean['email']}',
																tg_qq='{$_clean['qq']}',
																tg_url='{$_clean['url']}',
																tg_switch='{$_clean['switch']}',
																tg_autograph='{$_clean['autograph']}'
													WHERE
																tg_username='{$_COOKIE['username']}' 
																");
		}
	}
	//判断是否修改成功
	if (_affected_rows() == 1) {
		_close();
		//_session_destroy();
		_location('恭喜你，修改成功！','member.php');
	} else {
		_close();
		//_session_destroy();
		_location('很遗憾，没有任何数据被修改！','member_modify.php');
	}
}
//是否正常登录
if (isset($_COOKIE['username'])) {
	//获取数据
	$_rows = _fetch_array("SELECT tg_switch,tg_autograph,tg_username,tg_sex,tg_face,tg_email,tg_url,tg_qq FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	if ($_rows) {
		$_html= array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_face'];
		$_html['email'] = $_rows['tg_email'];
		$_html['url'] = $_rows['tg_url'];
		$_html['qq'] = $_rows['tg_qq'];
		$_html['switch'] = $_rows['tg_switch'];
		$_html['autograph'] = $_rows['tg_autograph'];
		$_html = _html($_html);
		
		//性别选择
		if ($_html['sex'] == '1') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="1" checked="checked" /> 男 <input type="radio" name="sex" value="2" /> 女';
		} elseif ($_html['sex'] == '2') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="1" /> 男 <input type="radio" name="sex" value="2" checked="checked" /> 女';
		}
		
		//头像选择
		$_html['face_html'] = '<select name="face">';
		foreach (range(1,9) as $_num) {
			if ($_html['face'] == 'face/m0'.$_num.'.gif') {
				$_html['face_html'] .= '<option value="resource/face/m0'.$_num.'.gif" selected="selected">resource/face/m0'.$_num.'.gif</option>';
			} else {
				$_html['face_html'] .= '<option value="resource/face/m0'.$_num.'.gif">resource/face/m0'.$_num.'.gif</option>';
			}
		}
		foreach (range(10,64) as $_num) {
			if ($_html['face'] == 'face/m'.$_num.'.gif') {
				$_html['face_html'] .= '<option value="resource/face/m'.$_num.'.gif" selected="selected">resource/face/m'.$_num.'.gif</option>';
			} else {
				$_html['face_html'] .= '<option value="resource/face/m'.$_num.'.gif">resource/face/m'.$_num.'.gif</option>';
			}
		}
		$_html['face_html'] .= '</select>';
		
		//签名开关
		if ($_html['switch'] == 1) {
			$_html['switch_html'] = '<input type="radio" checked="checked" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" /> 禁用';
		} elseif ($_html['switch'] == 0) {
			$_html['switch_html'] = '<input type="radio" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" checked="checked" /> 禁用';
		}
		
	} else {
		_alert_back('此用户不存在');
	}
} else {
	_alert_back('非法登录');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云飞凌风后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/basic.css" />
<link rel="stylesheet" type="text/css" href="css/member_modify.css" />
<script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>

<div id="member">
<?php 
	require ROOT_PATH.'common/member.inc.php';
?>
	<div id="member_main">
		<h2>管理员资料修改</h2>
		<form method="post" action="?action=modify">
		<dl>
			<dd>用 户 名：<?php echo $_html['username']?></dd>
			<dd>密　　码：<input type="password" class="text" name="password" /> (留空则不修改)</dd>
			<dd>性　　别：<?php echo $_html['sex_html']?></dd>
			<dd>头　　像：<?php echo $_html['face_html']?></dd>
			<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>" /></dd>
			<dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>" /></dd>
			<dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>" /></dd>
			<dd>个性签名：<?php echo $_html['switch_html']?> (可以使用UBB代码)
					<p><textarea name="autograph"><?php echo $_html['autograph']?></textarea></p>
			</dd>
		 <input type="submit" class="submit" value="修改资料" /></dd>
		</dl>
		</form>
	</div>
</div>



</body>
</html>
