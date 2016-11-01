<?php
//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Defined!');
}
?>
<link rel="stylesheet" type="text/css" href="styles/header.css" />
<link rel="stylesheet" type="text/css" href="styles/menu.css" />


<div class="wraper">
  <div class="quotes">
    <p>静，是一种休息，更是一种修行。所有的烦恼，都来自于喧嚣，所有的伤痛，都来自于躁动。身体奔波太久会劳累，灵魂游离太久会成伤。红尘淹没了纯洁，欲望吞噬了安详，经年后，心若一动，泪已千行。
    停一停追逐的脚步，缓一缓紧绷的心弦，让心宁静，让伤口复原，让灵魂升华。</p>
<!--     <div class="text5">学习・分享</div> -->
<!--     <div class="flower"><img src="images/flower.jpg"></div> -->
  </div>
  

	<div class="menu">
		<ul>
			<li><a href="index.php">凌风之家</a></li>
			<li><a href="about.php">关于我</a></li>
			<li><a href="article.php">原创文章</a></li>
			<li><a href="photo.php">记忆碎片</a></li>
			<li><a href="message.php">用户留言</a></li>
			<li><a href="/">手机客户端</a></li>
			<li><a href="api/index.php">我的工作云</a></li>
			<li><a href="admin/index.php">管理员后台</a></li>
		</ul>
	</div>	
</div>
	
	<!-- 动画菜单 -->
	<script src="js/jquery.min.js"></script>
	<script>
		$(function(){
			$(".menu li a").wrapInner( '<span class="out"></span>');
			$(".menu li a").each(function() {
				$('<span class="over">' +  $(this).text() + '</span>').appendTo(this);
			});
			$(".menu li a").hover(function() {
				$(".out",this).stop().animate({'top':'48px'},300);
				$(".over",this).stop().animate({'top':'0px'},300);
			},function() {
				$(".out",this).stop().animate({'top':'0px'},300);
				$(".over",this).stop().animate({'top':'-48px'},300);
			});
		})
	</script>










