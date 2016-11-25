<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//取值
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_name,
																	tg_sid,
																	tg_url,
																	tg_username,
																	tg_readcount,
																	tg_commendcount,
																	tg_content,
																	tg_date
														FROM
																	tg_photo
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
	
		//防止加密相册图片穿插访问
		//可以先取得这个图片的sid，也就是它的目录，
		//然后再判断这个目录是否是加密的，
		//如果是加密的，再判断是否有对应的cookie存在，并且对于相应的值
		//管理员不受这个限制
		
		if (!isset($_SESSION['admin'])) {
			if (!!$_dirs = _fetch_array("SELECT tg_type,tg_id,tg_name FROM tg_dir WHERE tg_id='{$_rows['tg_sid']}'")) {
				if (!empty($_dirs['tg_type']) && $_COOKIE['photo'.$_dirs['tg_id']] != $_dirs['tg_name']) {
					_alert_back('非法操作！');
				}
			} else {
				_alert_back('相册目录表出错了！');
			}
		}
		
		//累积阅读量
		_query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
		
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['sid'] = $_rows['tg_sid'];
		$_html['name'] = $_rows['tg_name'];
		$_html['url'] = $_rows['tg_url'];
		$_html['username'] = $_rows['tg_username'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commendcount'] = $_rows['tg_commendcount'];
		$_html['date'] = $_rows['tg_date'];
		$_html['content'] = $_rows['tg_content'];
		$_html = _html($_html);
		
											
		//上一页，取得比自己大的ID中，最小的那个即可。
		$_html['preid'] = _fetch_array("SELECT 
																			min(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id>'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['preid']['id'])) {
			$_html['pre'] = '<a class="left" href="photo_detail.php?id='.$_html['preid']['id'].'#pre"> </a>';
		} else {
			$_html['pre'] = '<span></span>';
		}
		
		//下一页，取得比自己小的ID中，最大的那个即可。
		$_html['nextid'] = _fetch_array("SELECT 
																			max(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id<'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['nextid']['id'])) {
			$_html['next'] = '<a class="right" href="photo_detail.php?id='.$_html['nextid']['id'].'#next"> </a>';
		} else {
			$_html['next'] = '<span></span>';
		}
		
	} else {
		_alert_back('不存在此图片！');
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
?>

<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
<script type="text/javascript" src="js/bigimg.js"></script>
</head>

<body>

<div class="photo">
		<h1 class="bw_bc_title"><?php echo $_html['name']?></h1>
                      <div class="titleTopBlock">
                     		 <span class="leftBlock">
                                发表于:&nbsp; <?php echo $_html['date']?> | 上传者:&nbsp; <?php echo $_html['username']?>
                            </span>
                            <span class="rightBlock">
                            	浏览量:&nbsp;[<strong><?php echo $_html['readcount'];?></strong>] | 评论量:&nbsp;[<strong><?php echo $_html['commendcount'];?></strong>]
                            </span>
                      </div>

    	<div class="changePhotoBlockS">
    	<div class="leftBtns"><a name="pre"></a></div>
    	<div class="rightBtns"><a name="next"></a></div>
	    	<div class="changePhotoBlock" id="changePhotoBlock">
	    	<ul><li>
	    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	           <tr>
	                <td align="center" valign="middle">
	                    <?php echo $_html['pre']?><img src="<?php echo $_html['url']?>" width="670"/><?php echo $_html['next']?>
	                </td>
	            </tr>
	        </table>
	    	</li></ul>
	    	</div>
	    </div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
