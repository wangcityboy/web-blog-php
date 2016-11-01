<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php'; //转换成硬路径，速度更快

//读取全部帖子列表
	$_result = _query("SELECT
			tg_id,tg_title,tg_content,tg_image
			FROM
			tg_article
			WHERE
			tg_reid=0 AND tg_classify in (10007,10008,10009,10010,10011,10012,10013,10014)
			ORDER BY
			tg_date DESC
			LIMIT
			6
			");
	
	
	//读取全个人日志帖子列表
	$_res = _query("SELECT
			tg_id,tg_content,tg_title,tg_image
			FROM
			tg_article
			WHERE
			tg_reid=0
			ORDER BY
			tg_readcount DESC
			LIMIT
			4
			");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
<script src="js/modernizr.js"></script>
</head>
<body>
  
<div class="blog">
		<?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_result)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['content'] = $_rows['tg_content'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist['image'] = $_rows['tg_image'];
				$_htmllist = _html($_htmllist);
				
				echo '<figure> <a href="article.php?id='.$_htmllist['id'].'"><img src="'.$_htmllist['image'].'"></a>';
				echo '<p><a href="article_detail.php?id='.$_htmllist['id'].'">'.$_htmllist['title'].'</a></p>';
				echo '<figcaption>'._title(strip_tags(htmlspecialchars_decode($_htmllist['content'])), 80).'</figcaption>';
				echo '</figure>';
			}
			_free_result($_result);
		?>
</div>

<div class="text6">技术・成长</div>
<div class="hope">
  <ul>
    <div class="visitors">	
    	<?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_res)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['content'] = $_rows['tg_content'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist['image'] = $_rows['tg_image'];
				$_htmllist = _html($_htmllist);
				echo '<dl>';
				echo '<dt><img src="'.$_htmllist['image'].'"> </dt>';
				echo '<dd><a href="article_detail.php?id='.$_htmllist['id'].'">'.$_htmllist['title'].'</a> </dd>';
				echo '<dd>'._title(strip_tags(htmlspecialchars_decode($_htmllist['content'])), 80).'</dd>';
				echo '</dl>';
			}
			_free_result($_res);
		?>
    </div>
  </ul>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
