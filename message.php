<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';	
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
</head>

<body>
<div id="msg">    
	<?php
		$query = "SELECT tg_content FROM tg_message";
		$result = mysql_query($query) or die('SQL语句有误：'.mysql_error());
		$web_ad = mysql_fetch_array($result);
		$ad_xs=$web_ad['tg_content']; 
		if ($ad_xs<>""){
			echo $ad_xs;
		}
	?>
	
	<!-- 多说评论框 start -->
	<div class="ds-thread" data-thread-key="<?php echo $wz_id?>" data-title="<?php echo $wz['w_title']?>" data-url="<?php echo $row['web_url']?>/?post=<?php echo $wz_id?>"></div>
	<!-- 多说评论框 end -->
	
	
	<!-- 多说公共JS代码 start (一个网页只需插入一次) -->
	 <script type="text/javascript">
	    var duoshuoQuery = {short_name:"wanghf"};
		(function() {
			var ds = document.createElement('script');
			ds.type = 'text/javascript';ds.async = true;
			ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.unstable.js';
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
