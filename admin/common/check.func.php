<?php
//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

if (!function_exists('_alert_back')) {
	exit('_alert_back()函数不存在，请检查!');
}

if (!function_exists('_mysql_string')) {
	exit('_mysql_string()函数不存在，请检查!');
}

/**
 * _check_uniqid
 * @param unknown_type $_first_uniqid
 * @param unknown_type $_end_uniqid
 */

function _check_uniqid($_first_uniqid,$_end_uniqid) {
	
	if ((strlen($_first_uniqid) != 40) || ($_first_uniqid != $_end_uniqid)) {
		_alert_back('唯一标识符异常');
	}
	
	return _mysql_string($_first_uniqid);
}

/**
 * _check_username表示检测并过滤用户名
 * @access public 
 * @param string $_string 受污染的用户名
 * @param int $_min_num  最小位数
 * @param int $_max_num 最大位数
 * @return string  过滤后的用户名 
 */
function _check_username($_string,$_min_num,$_max_num) {
	global $_system;
	//去掉两边的空格
	$_string = trim($_string);
	
	//长度小于两位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('用户名长度不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//限制敏感字符
	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('用户名不得包含敏感字符');
	}
	
	//限制敏感用户名
	$_mg = explode('|',$_system['string']);
	//告诉用户，有哪些不能够注册
	foreach ($_mg as $value) {
		$_mg_string .= '[' . $value . ']' . '\n';
	}
	//这里采用的绝对匹配
	if (in_array($_string,$_mg)) {
		_alert_back($_mg_string.'以上敏感用户名不得注册');
	}
	
	//将用户名转义输入
	return _mysql_string($_string);
}


/**
 * _check_password验证密码
 * @access public
 * @param string $_first_pass
 * @param string $_end_pass
 * @param int $_min_num
 * @return string $_first_pass 返回一个加密后的密码
 */

function _check_password($_first_pass,$_end_pass,$_min_num) {
	//判断密码
	if (strlen($_first_pass) < $_min_num) {
		_alert_back('密码不得小于'.$_min_num.'位！');
	}
	
	//密码和密码确认必须一致
	if ($_first_pass != $_end_pass) {
		_alert_back('密码和确认密码不一致！');
	}
	
	//将密码返回
	return sha1($_first_pass);
}

function _check_modify_password($_string,$_min_num) {
	//判断密码
	if (!empty($_string)) { 
		if (strlen($_string) < $_min_num) {
			_alert_back('密码不得小于'.$_min_num.'位！');
		}
	} else {
		return null;
	}
	return sha1($_string);
}
	
/**
 * _check_question 返回密码提示
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return string $_string 返回密码提示
 */

function _check_question($_string,$_min_num,$_max_num) {
	$_string = trim($_string);
	//长度小于4位或者大于20位
	if (mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
		_alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//返回密码提示
	return _mysql_string($_string);
}

/**
 *_check_answer()
 *@access public 
 * @param string $_ques
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 * @return $_answ
 */
function _check_answer($_ques,$_answ,$_min_num,$_max_num) {
	$_answ = trim($_answ);
	//长度小于4位或者大于20位
	if (mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('密码回答不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
	}
	
	//密码提示与回答不能一致
	if ($_ques == $_answ) {
		_alert_back('密码提示与回答不得相同');
	}
	
	//加密返回
	return _mysql_string(sha1($_answ));
}

/**
 * _check_sex  性别
 * @access public
 * @param string $_string
 * @return string 
 */

function _check_sex($_string) {
	return _mysql_string($_string);
}

/**
 * _check_face 头像
 * @access public
 * @param string $_string
 * @return string 
 */

function _check_face($_string) {
	return _mysql_string($_string);
}

/**
 * _check_email() 检查邮箱是否合法
 * @access public
 * @param string $_string 提交的邮箱地址
 * @return string $_string 验证后的邮箱
 */

function _check_email($_string,$_min_num,$_max_num) {
	//参考bnbbs@163.com
	//[a-zA-Z0-9_] => \w
	//[\w\-\.] 16.3.
	//\.[\w+] .com.com.com.net.cn
	//正则挺起来比较麻烦，但是你理解了，就很简单了。
	//如果听起来比较麻烦，就直接套用

	if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
		_alert_back('邮件格式不正确！');
	}
	if (strlen($_string) < $_min_num || strlen($_string) > $_max_num) {
		_alert_back('邮件长度不合法！');
	}


	
	return _mysql_string($_string);
}

/**
 * _check_qq ....
 * @access public
 * @param int $_string
 * @return int $_string  QQ号码
 */

function _check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		//123456
		if (!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)) {
			_alert_back('QQ号码不正确！');
		}
	}
	
	return _mysql_string($_string);
}

/**
 * _check_url 网址验证
 * @access public
 * @param string $_string
 * @return string $_string 返回验证后的网址
 */

function _check_url($_string,$_max_num) {
	if (empty($_string) || ($_string == 'http://')) {
		return null;
	} else {
		//http://ww.yc60.com
		//?表示0次或者一次
		if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('网址不正确！');
		}
		if (strlen($_string) > $_max_num) {
			_alert_back('网址太长！');
		}
	}
	
	return _mysql_string($_string);
}

function _check_content($_string) {
	if (mb_strlen($_string,'utf-8') < 10 || mb_strlen($_string,'utf-8') > 200) {
		_alert_back('短信内容不得小于10位或者大于200位！');
	}
	return $_string;
}


function _check_post_title($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max) {
		_alert_back('帖子标题内容不得小于'.$_min.'位大于'.$_max.'位！');
	}
	return $_string;
}

function _check_post_content($_string,$_num) {
	if (mb_strlen($_string,'utf-8') < $_num) {
		_alert_back('帖子内容不得小于'.$_num.'位！');
	}
	return $_string;
}

function _check_autograph($_string,$_num) {
	if (mb_strlen($_string,'utf-8') >$_num) {
		_alert_back('帖子内容不得小于'.$_num.'位！');
	}
	return $_string;
}

function _check_dir_name($_string,$_min,$_max) {
	if (mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max ) {
		_alert_back('名称不得小于'.$_min.'位或者不能大于'.$_max.'位！');
	}
	return $_string;
}

function _check_dir_password($_string,$_num) {
	if (strlen($_string) < $_num) {
		_alert_back('密码不得小于'.$_num.'位！');
	}
	return sha1($_string);
}

function _check_photo_url($_string) {
	if (empty($_string)) {
		_alert_back('地址不能为空！');
	}
	return $_string;
}

?>