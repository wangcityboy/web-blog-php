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
               <dt>1、我不主动找你，不是因为你不重要，而是我不知道我重不重要。</dt>
               <dt>2、我不愿送人，亦不愿人送我。对于自己真正舍不得离开的人，离别的那一刹那像是开刀。</dt>
          	   <dt>3、当有人突然从你的生命中消失，不用问为什么，只是她到了该走的时候了，你只需要接受就好，不论朋友，还是恋人。 所谓成熟，就是知道有些事情终究无能为力。</dt>
          	   <dt>4、如果一个人足够想你，她绝对会忍不住思念来找你，而不总是你理她，她才理你。友情也好，爱情也罢，这之间没有腼腆一说。</dt>
          	   <dt>5、愿恋人待你如初，疼你入骨，从此深情不被辜负。</dt>
          	   <dt>6、生活赋予我们一种巨大的和无限高贵的礼品，这就是青春：充满着力量，充满着期待志愿，充满着求知和斗争的志向，充满着希望信心和青春。</dt>
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
