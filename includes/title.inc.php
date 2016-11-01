<?php
//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Defined!');
}
//防止非HTML页面调用
if (!defined('SCRIPT')) {
	exit('Script Error!');
}
global $_system;
?>
<title>云飞凌风个人网站</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo SCRIPT?>.css" />
<link rel="stylesheet" type="text/css" href="styles/footer.css" />


