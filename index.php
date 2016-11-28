<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','index');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php'; //转换成硬路径，速度更快
//读取帖子列表
global $_pagesize,$_pagenum,$_system;

$_classify = $_GET['classify'];

if($_classify != 0){
	_page("SELECT tg_id FROM tg_article WHERE tg_reid=0 AND tg_classify='{$_classify}'",$_system['article']);
	$_result = _query("SELECT
			tg_id,tg_title,tg_username,tg_type,tg_readcount,tg_commendcount,tg_content,tg_date,tg_classify,tg_image
			FROM
			tg_article
			WHERE
			tg_classify='{$_classify}'
			ORDER BY
			tg_date DESC
			LIMIT
			$_pagenum,$_pagesize
			");
}else{
	_page("SELECT tg_id FROM tg_article WHERE tg_reid=0",$_system['article']);
	$_result = _query("SELECT
			tg_id,tg_title,tg_username,tg_type,tg_readcount,tg_commendcount,tg_content,tg_date,tg_classify,tg_image
			FROM
			tg_article
			WHERE
			tg_reid=0
			ORDER BY
			tg_date DESC
			LIMIT
			$_pagenum,$_pagesize
			");
}


$_res = _query("SELECT
		tg_id,tg_title,tg_username,tg_type,tg_readcount,tg_commendcount,tg_content,tg_date,tg_classify,tg_image
		FROM
		tg_article
		WHERE
		tg_reid=0 AND tg_classify=10013
		ORDER BY
		tg_date DESC
		LIMIT
		5
		");

$_rank = _query("SELECT
            tg_id,tg_title,tg_type,tg_commendcount
    FROM
            tg_article
    WHERE
            tg_reid=0 
    ORDER BY
            tg_readcount DESC
    LIMIT
            6
    ");

$_test = _query("SELECT
            tg_id,tg_title,tg_type,tg_commendcount
    FROM
            tg_article
    WHERE
            tg_reid=0 AND tg_classify=10011
    ORDER BY
            tg_date DESC
    LIMIT
            6
    ");


$_it = _query("SELECT
            tg_id,tg_title,tg_type,tg_commendcount
    FROM
            tg_article
    WHERE
            tg_reid=0 AND tg_classify=10012
    ORDER BY
            tg_readcount DESC
    LIMIT
            6
    ");


//最新图片,找到时间点最后上传的那张图片，并且是非公开的
$_photo = _fetch_array("SELECT
															tg_id AS id,
															tg_name AS name,
															tg_url AS url 
												FROM 
															tg_photo 
											WHERE
															tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0)
										ORDER BY 
															tg_date DESC 
												LIMIT 
															1
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

<script type="text/javascript"  src="js/blog.js"></script>
<script type="text/javascript"  src="js/jquery.min.js"></script>
<script type="text/javascript"  src="js/sliders.js"></script>
<script type="text/javascript"  src="http://libs.baidu.com/jquery/2.1.1/jquery.min.js"></script>
</head>


<body>
<article id="index">
<div class="l_box f_l">

	<div class="banner">
	      <div id="slide-holder">
	        <div id="slide-runner"> 
	        <a href="/" target="_blank"><img id="slide-img-1" src="images/slide4.jpg"  alt="" /></a> 
	        <a href="/" target="_blank"><img id="slide-img-2" src="images/slide5.jpg"  alt="" /></a> 
	        <a href="/" target="_blank"><img id="slide-img-3" src="images/slide10.gif"  alt="" /></a> 
	        <a href="/" target="_blank"><img id="slide-img-4" src="images/slide19.jpg"  alt="" /></a>
	        <a href="/" target="_blank"><img id="slide-img-5" src="images/slide29.jpg"  alt="" /></a>
	          <div id="slide-controls">
	            <p id="slide-client" class="text"><strong></strong><span></span></p>
	            <p id="slide-desc" class="text"></p>
	            <p id="slide-nav"></p>
	          </div>
	        </div>
	      </div>
	      
	     <script>
		if(!window.slider) {
			var slider={};
		 }
	
		slider.data= [
	    {
	        "id":"slide-img-1", 
	        "client":"",
	        "desc":"陪伴是最长情的告白，相守是最温暖的承诺。" 
	    },
	    {
	        "id":"slide-img-2",
	        "client":"",
	        "desc":"一念成悦，处处繁花处处锦；一念成执，寸寸相思寸寸灰。"
	    },
	    {
	        "id":"slide-img-3",
	        "client":"",
	        "desc":"青春是一场高烧，怀念是紧接着好不了的咳。"
	    },
	    {
	        "id":"slide-img-4",
	        "client":"",
	        "desc":"伸手需要一瞬间，牵手却要很多年，无论你遇见谁，他都是你生命该出现的人，绝非偶然！"
	    },
	    {
	        "id":"slide-img-5",
	        "client":"",
	        "desc":"人生若只如初见，你若安好，便是晴天"
	    }
		];
		</script> 
	 </div>

    

	<div class="topnews">
	     <h2>
	     <span>
	     <a href="index.php" target="_self">全部</a>
	     <a href="index.php?classify=10007" target="_self">iOS开发</a>
	     <a href="index.php?classify=10008" target="_self">安卓开发</a>
	     <a href="index.php?classify=10009" target="_self">前端开发</a>
	     <a href="index.php?classify=10010" target="_self">后台开发</a>
	     <a href="index.php?classify=10011" target="_self">测试开发</a>
	     <a href="index.php?classify=10012" target="_self">信息技术</a>
	     <a href="index.php?classify=10013" target="_self">生活随笔</a>
	     <a href="index.php?classify=10014" target="_self">网络文摘</a>
	     </span>
	     <b>文章</b>推荐
	     </h2>
			<?php
				$_htmllist = array();
				while (!!$_rows = _fetch_array_list($_result)) {
					$_htmllist['id'] = $_rows['tg_id'];
					$_htmllist['type'] = $_rows['tg_type'];
					$_htmllist['readcount'] = $_rows['tg_readcount'];
					$_htmllist['commendcount'] = $_rows['tg_commendcount'];
					$_htmllist['title'] = $_rows['tg_title'];
					$_htmllist['username'] = $_rows['tg_username'];
					$_htmllist['image'] = $_rows['tg_image'];
					$_htmllist["content"] = $_rows['tg_content'];
					$_htmllist['date'] = $_rows['tg_date'];
					$_htmllist['classify'] = $_rows['tg_classify'];
					$_htmllist = _html($_htmllist);
					
					$_str = _getClassify($_htmllist['classify']);
					
					echo '<div class="blogs">';
					echo '<figure><img src="'.$_htmllist['image'].'"></figure>';
					echo '<ul>';
					echo '<h3><a href="article_detail.php?id='.$_htmllist['id'].'">'.$_htmllist['title'].'</a></h3>';
					echo '<p>'._title(strip_tags(htmlspecialchars_decode($_htmllist["content"])),100).'</p>';
					echo '<p class="autor"><span class="lm f_l"><a href="index.php?classify='.$_htmllist['classify'].'">'.$_str.'</a></span><span class="dtime f_l">'.$_htmllist['username'].' 发表于 '.$_htmllist['date'].'</span><span class="viewnum f_r">浏览（<a href="/">'.$_htmllist['readcount'].'</a>）</span></p>';
					echo '</ul>';
					echo '</div>';
		}
				_free_result($_result);
			?>
					<?php _paging($_classify,2);?>
				</div>
	
	</div>


 <div class="r_box f_r">
 
    <div class="tit01">
      <div class="gzwm">
        <ul>
          <li><a class="xlwb" href="http://weibo.com/wangcityboy" target="_blank">新浪微博</a></li>
          <li><a class="txwb" href="about.php" target="_blank">加我微信</a></li>
          <li><a class="rss" href="about.php" target="_blank">加我QQ</a></li>
          <li><a class="wx" href="mailto:wangcityboy@163.com">邮箱</a></li>
        </ul>
      </div>
    </div>

    
    <div class="ad300x100"> 
    <ul>
	    <li> <span class="STYLE1 STYLE3">今天是: 
			<script language=Javascript type=text/Javascript> 
				var day=""; 
				var month=""; 
				var ampm=""; 
				var ampmhour=""; 
				var myweekday=""; 
				var year=""; 
				mydate=new Date(); 
				myweekday=mydate.getDay(); 
				mymonth=mydate.getMonth()+1; 
				myday= mydate.getDate(); 
				myyear= mydate.getYear(); 
				year=(myyear > 200) ? myyear : 1900 + myyear; 
				if(myweekday == 0) 
				weekday=" 星期日 "; 
				else if(myweekday == 1) 
				weekday=" 星期一 "; 
				else if(myweekday == 2) 
				weekday=" 星期二 "; 
				else if(myweekday == 3) 
				weekday=" 星期三 "; 
				else if(myweekday == 4) 
				weekday=" 星期四 "; 
				else if(myweekday == 5) 
				weekday=" 星期五 "; 
				else if(myweekday == 6) 
				weekday=" 星期六 "; 
				document.write(year+"年"+mymonth+"月"+myday+"日 "+weekday); 
			</script>
			</span>
		</li>
     </ul>
	</center>
    </div>
    
   
   
   
    <div class="moreSelect" id="lp_right_select"> 
		<script>
			window.onload = function ()
			{
				var oLi = document.getElementById("tab").getElementsByTagName("li");
				var oUl = document.getElementById("ms-main").getElementsByTagName("div");
				
				for(var i = 0; i < oLi.length; i++)
				{
					oLi[i].index = i;
					oLi[i].onmouseover = function ()
					{
						for(var n = 0; n < oLi.length; n++) oLi[n].className="";
						this.className = "cur";
						for(var n = 0; n < oUl.length; n++) oUl[n].style.display = "none";
						oUl[this.index].style.display = "block"
					}	
				}
			}
		</script>
		
		
      <div class="ms-top">
        <ul class="hd" id="tab">
          <li class="cur"><a href="/">点击排行</a></li>
          <li><a href="/">测试开发</a></li>
          <li><a href="/">站长推荐</a></li>
        </ul>
      </div>
      
      
      <div class="ms-main" id="ms-main">
        <div style="display: block;" class="bd bd-news" >
          <ul>
        <?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_rank)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li> <a href="article_detail.php?id='.$_htmllist['id'].'"target="_self">'._title($_htmllist['title'],30).'</a></li>';
			}
			_free_result($_rank);
		?>
          </ul>
        </div>
        
        
        <div  class="bd bd-news">
          <ul>
            <?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_test)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li> <a href="article_detail.php?id='.$_htmllist['id'].'"target="_self">'._title($_htmllist['title'],30).'</a></li>';
			}
			_free_result($_test);
		?>
          </ul>
        </div>
        
        
        
        <div class="bd bd-news">
          <ul>
         <?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_it)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li> <a href="article_detail.php?id='.$_htmllist['id'].'"target="_self">'._title($_htmllist['title'],30).'</a></li>';
			}
			_free_result($_it);
		?>
          </ul>
        </div>
        
      </div>
      <!--ms-main end --> 
    </div>
    <!--切换卡 moreSelect end -->
    
    
    
    <div class="cloud">
      <h3>标签云</h3>
      <ul>
        <li><a href="http://wanghaifeng.net">个人博客</a></li>
        <li><a href="http://www.php186.com">web开发</a></li>
        <li><a href="http://www.yyyweb.com">前端设计</a></li>
        <li><a href="http://www.w3school.com.cn/html/">Html</a></li>
        <li><a href="http://www.w3school.com.cn/h.asp">Html5+css3</a></li>
        <li><a href="http://www.w3school.com.cn/b.asp">Javasript</a></li>
        <li><a href="http://www.cocoachina.com">iOS开发</a></li>
        <li><a href="http://numbbbbb.gitbooks.io/-the-swift-programming-language-/content/">Swift</a></li>
        <li><a href="http://testerhome.com">测试开发</a></li>
        <li><a href="http://www.baidu.com">百度</a></li>
      </ul>
    </div>
    
    
    <div class="tuwen">
      <h3>生活随笔</h3>
      <ul>
        <?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_res)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist['image'] = $_rows['tg_image'];
				$_htmllist['date'] = $_rows['tg_date'];
				$_htmllist['classify'] = $_rows['tg_classify'];
				$_htmllist = _html($_htmllist);				
				$_str = _getClassify($_htmllist['classify']);

				echo '<li><a href="article_detail.php?id='.$_htmllist['id'].'"><img src="'.$_htmllist['image'].'">'.$_htmllist['title'].'</a>';
				echo '<p><span class="tulanmu"><a href="/">'.$_str.'</a></span><span class="tutime">'.$_htmllist['date'].'</span></p>';			 		
				echo '</li>';	
	}
			_free_result($_res);
		?> 
      </ul>
    </div>
    
    
     <div class="ad">
     <h3>最新图片</h3>
          <a href="photo_detail.php?id=<?php echo $_photo['id']?>"><img src="<?php echo $_photo['url']?>" alt="<?php echo $_photo['name']?>" /></a>
     </div> 


    
    
    <div class="links">
      <h3><span>[<a href="/">申请友情链接</a>]</span>友情链接</h3>
      <ul>
        <li><a href="https://swift.zeef.com">Swift开发</a></li>
        <li><a href="https://github.com/ipader/SwiftGuide">Swift开源项目精选</a></li>
        <li><a href="http://dev.swiftguide.cn">Swift语言指南</a></li>
        <li><a href="https://www.gitbook.com/book/numbbbbb/-the-swift-programming-language-/details">《The Swift Programming Language》中文版</a></li>
        <li><a href="http://testerhome.com">TesterHome社区</a></li>
        <li><a href="http://javascript.ruanyifeng.com">javascript手册</a></li>
        <li><a href="http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html">微信JS-SDK说明</a></li>
        <li><a href="http://www.json.org/json-zh.html">中文介绍JSON</a></li>
        <li><a href="http://www.webxml.com.cn/zh_cn/web_services.aspx">WEB服务</a></li>
        <li><a href="http://www.k780.com">K780标准数据接口</a></li>
        <li><a href="http://www.bejson.com/">在线JSON校验格式化工具</a></li>
        <li><a href="http://www.mvnrepository.com">Maven依赖</a></li>
        <li><a href="http://www.open-open.com">Open家园</a></li>
        <li><a href="http://www.runoob.com">菜鸟教程</a></li>
        <li><a href="http://www.androiddevtools.cn">安卓开发工具</a></li>
        <li><a href="http://apistore.baidu.com">百度Api集市</a></li>
      </ul>
    </div>
   
  </div> 
 	
</article>


<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>


</body>
</html>
