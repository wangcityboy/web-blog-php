<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','about');
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
<link href='http://fonts.googleapis.com/css?family=Parisienne' rel='stylesheet' type='text/css'/>
<link rel="stylesheet" type="text/css" href="styles/aboutus.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/coin-slider.min.js"></script>
<script type="text/javascript" src="js/jquery.movebg.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#coin-slider').coinslider({ width: 462, height:288, delay: 5000, effect: 'rain' });
});
</script>
</head>

<body>
	 <div class="main_content">
	   <div class="logo">
	   </div>
	   	  <div class="book">
		     <section class="welcome_text">
		        <h2>Welcome to our website</h2>
		        <p>如果这辈子，只能跟一个人相守到老，激情慢慢褪去，看腻身边的人，感觉不到爱，没别的选择，生活平淡如水，你会不会因此感到寂寞？我们当初选择了爱，就是选择了和某个人一起寂寞到老。</p>
		        <p>两个人的世界里，总要一个闹着、一个笑着，一个吵着、一个哄着。如果一个人总是输，不是口才不够好，只是不忍心把最伤人的话说出口。总要一个人“输”了，两个人才能赢了。</p>
		        <a href="timeline.html" class="more">read more</a>
		     </section>
	     
		    <div id="coin-slider">
		        	<ul>
			            <li><a href="#"><img src="images/coin_pic6.jpg" ></a></li>
			            <li><a href="#"><img src="images/coin_pic7.jpg" ></a></li>
			            <li><a href="#"><img src="images/coin_pic8.jpg" ></a></li>
					</ul>
		    </div> 
		</div>
	</div>

    <div class="about">
        <div class="information">
            <h2><p>个人<span>简介</span></p></h2>
		    <dl>
    			<dt>姓名: <label>王海峰(Wang Hai Feng)</label></dt>
    			<dt>昵称: <label>云飞凌风</label></dt>
    			<dt>籍贯: <label> 湖北省大冶市</label> </dt>
    			<dt>现居地: <label>广东省广州市天河区</label> </dt>
    			<dt>职能: <label> 熟悉iOS开发、安卓开发、后台开发、前端开发、测试开发等</label> </dt>
    			<dt>兴趣: <label> 除了IT互联网，我还热爱电影、音乐、旅游、运动、舞蹈、文学、书法</label></dt>
    			<dt>个人说明: <label>学会爱人，学会懂得爱情，学会做一个幸福的人——这就是要学会尊重自己，就是要学会人类的美德!</label></dt>
            </dl>
            
            <h2><p>博客<span>简介</span></p></h2>
            <dl>
               <dt>1、下班后闲得无聊，所以写了个简单的个人博客，主要用于发表一些技术性的文章和大家一起学习。有什么问题，请大家留言，谢谢。</dt>
               <dt>2、已经完成后台接口的开发，同时用不同的编程语言(Nodejs,php)开发了两套接口，同时通过swift开发语言已经完成iOS程序的应用开发以及JAVA语言开发的安卓应用。</dt>
               <dt>3、本博客主要文章可以分为:生活随笔、iOS开发、PHP开发、测试开发、IT技术等，请参考博客文章分类。</dt>
            </dl>
          
          <h2><p>心情<span>语录</span></p></h2>
            <dl>
               <dt>1、“人都是逼出来的。”每个人都是有潜能的，生于安乐，死于忧患，所以，当面对压力的时候，不要焦燥，也许这只是生活对你的一点小考验，相信自己，一切都能处理好，逼急了好汉可以上梁山，时世造英雄，穷者思变，人只有压力才会有动力。</dt>
               <dt>2、“如果你简单，这个世界就对你简单。”简单生活才能幸福生活，人要自足常乐，宽容大度，什么事情都不能想繁杂，心灵的负荷重了，就会怨天忧人。要定期的对记忆进行一次删除，把不愉快的人和事从记忆中摈弃。</dt>
          	   <dt>3、“人生没有彩排，每一天都是现场直播。”偶尔会想，如果人生真如一场电子游戏，玩坏了可以选择重来，生活会变成什么样子？正因为时光流逝一去不复返，每一天都不可追回，所以更要珍惜每一寸光阴，孝敬父母、疼爱孩子、体贴爱人、善待朋友。</dt>
          	   <dt>4、“怀才就象怀孕，时间久了会让人看出来。”人，切莫自以为是，地球离开了谁都会转，古往今来，恃才放肆的人都没有好下场。所以，即便再能干，也一定要保持谦虚谨慎，做好自己的事情，是金子总会发光。</dt>
          	   <dt>5、“过去酒逢知已千杯少，现在酒逢千杯知已少。”不甚酒力，体会不了酒的美味，但却能感受知已的妙处。没有朋友的人生是孤独的，不完整的，可是，因为生活的忙碌，渐渐少了联络，友谊就变的淡了，所以，抽点时间，联络朋友一起聊聊天，让情谊在笑声中升腾，当朋友遇到了难题的时候，一定要记得挺身而出，即便帮不了忙，安慰也是最大的支持。</dt>
          	   <dt>6、“人生如果错了方向，停止就是进步。”人，总是很难改正自己的缺点，人，也总是很难发现自己的错误，有时，明知错了，却欲罢不能，一错再错。把握正确的方向，坚守自己的原则，世界上的诱惑很多，天上永远不会掉馅饼，不要因为贪图一时的快乐而付出惨痛的代价，如果发现错了，一定要止步。</dt>
            </dl>
          
		  <h2><p>联系<span>方式</span></p></h2>
		   <dl>
			<dt>电子邮件：<label>wangcityboy@163.com</label></dt>
			<dt>个人网站：<label> <a href="http://www.wanghaifeng.net/web-blog-php">http://www.wanghaifeng.net</a></label></dt>
			<dt>新浪微博：<label>云飞凌风</label></dt>
			<dt>  Q  Q：<label> <a href="http://wpa.qq.com/msgrd?v=3&uin=273262403&site=qq&menu=yes" target="_blank">273262403</a></label></dt>
		  </dl>
    </div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
