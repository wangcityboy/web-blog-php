<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';	

$result = _query("SELECT
		tg_id,tg_title,tg_type,tg_readcount,tg_commendcount,tg_content,tg_date,tg_classify
	FROM
		tg_article
	WHERE
		tg_reid=0
	AND
		tg_id='{$_GET['id']}'");

//多说评论插件获取数据
$web_ad = mysql_fetch_array($result);
$ad_title=$web_ad['tg_title'];
$ad_id=$web_ad['tg_id'];

//读出数据
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_username,
																	tg_nickname,
																	tg_classify,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_readcount,
																	tg_commendcount,
																	tg_last_modify_date,
																	tg_nice,
																	tg_date 
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
	
		//累积阅读量
		_query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	
		$_html = array();
		$_html['reid'] = $_rows['tg_id'];
		$_html['nickname'] = $_rows['tg_nickname'];
		$_html['classify'] = $_rows['tg_classify'];
		$_html['title'] = $_rows['tg_title'];
		$_html['type'] = $_rows['tg_type'];
		$_html['content'] = $_rows['tg_content'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commendcount'] = $_rows['tg_commendcount'];
		$_html['nice'] = $_rows['tg_nice'];
		$_html['last_modify_date'] = $_rows['tg_last_modify_date'];
		$_html['date'] = $_rows['tg_date'];	
		$_str = _getClassify($_html['classify']);
		
	} else {
		_alert_back('不存在这个主题！');
	}
} else {
	_alert_back('非法操作！');
}
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
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>

<div id="article">

	<div id="subject">
		<div class="content">
		<h1><?php echo $_html['title']?></h1>
			<div class="user">
				<span><?php echo $_html['nickname']?> | 发表于：<?php echo $_html['date']?> | 日志分类：<?php echo $_str?> | 阅读量：(<?php echo $_html['readcount']?>) </span>
			</div>
			<div class="detail">
				<?php echo ($_html['content'])?>
			</div>
		</div>
	</div>

	<!-- 多说评论框 start -->
	<div class="ds-thread" data-thread-key="<?php echo $_GET['id']?>" data-title="<?php echo $ad_title;?>" data-url="article.php?id=<?php echo $_GET['id'] ?>"></div>
	<!-- 多说评论框 end -->
	
	<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
	 <script type="text/javascript">
	var duoshuoQuery = {short_name:"wanghf"};
		(function() {
			var ds = document.createElement('script');
			ds.type = 'text/javascript';ds.async = true;
			ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
			ds.charset = 'UTF-8';
			(document.getElementsByTagName('head')[0] 
			 || document.getElementsByTagName('body')[0]).appendChild(ds);
		})();
	</script>
	<!-- 多说公共JS代码 end -->  
 
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
