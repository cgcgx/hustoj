<?php 
	require('./include/db_info.inc.php');

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='./include/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
<?php function checkcontest($MSG_CONTEST){
		require_once("./include/db_info.inc.php");
		$sql="SELECT count(*) FROM `contest` WHERE `end_time`>NOW() AND `defunct`='N'";
		$result=mysql_query($sql);
		$row=mysql_fetch_row($result);
		if (intval($row[0])==0) $retmsg=$MSG_CONTEST;
		else $retmsg=$row[0]."<span class=red>&nbsp;$MSG_CONTEST</span>";
		mysql_free_result($result);
		return $retmsg;
	}
	function checkmail(){
		require_once("./include/db_info.inc.php");
		$sql="SELECT count(1) FROM `mail` WHERE 
				new_mail=1 AND `to_user`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		if(!$result) return false;
		$row=mysql_fetch_row($result);
		$retmsg="<span id=red>(".$row[0].")</span>";
		mysql_free_result($result);
		return $retmsg;
	}
	
	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
		if(file_exists("./faqs.$OJ_LANG.php")){
			$OJ_FAQ_LINK="./faqs.$OJ_LANG.php";
		}
	}else{
		require_once("./lang/en.php");
	}
	

	if($OJ_ONLINE){
		require_once('./include/online.php');
		$on = new online();
	}
?>
</head>
<body>
<div id=head>
<h2><img id=logo src=./image/logo.png><span id="red">Welcome To <?php echo $OJ_NAME?> ACM-ICPC Online Judge</span></h2>
</div><!--end head-->
<div id=subhead>
<div id=menu >
		<?php 
			$url=basename($_SERVER['REQUEST_URI']);
			//echo $url;
		
		?>
		<div class=menu_item >
		<a href="<?php echo $OJ_HOME?>"><?php if ($url=="JudgeOnline") echo "<span style='color:orange'>";?>
								<?php echo $MSG_HOME?>
								<?php if ($url=="JudgeOnline") echo "</span>";?>
		</a>
		</div>
		<div class=menu_item >
		<a href="bbs.php"><?php if ($url==$OJ_BBS.".php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_BBS?><?php if ($url==$OJ_BBS.".php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="problemset.php"><?php if ($url=="problemset.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_PROBLEMS?><?php if ($url=="problemset.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="status.php"><?php if ($url=="status.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_STATUS?><?php if ($url=="status.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="ranklist.php"><?php if ($url=="ranklist.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_RANKLIST?><?php if ($url=="ranklist.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="contest.php"><?php if ($url=="contest.php") echo "<span style='color:orange'>";?>
		<?php echo checkcontest($MSG_CONTEST)?><?php if ($url=="contest.php") echo "</span>";?></a>
		</div>
		<div class=menu_item ><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "<span style='color:orange'>";?>
		<a href="<?php echo isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>"><?php echo $MSG_FAQ?><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "</span>";?></a>
		</div>
		<?php if(isset($OJ_DICT)&&$OJ_DICT&&$OJ_LANG=="cn"){?>
      <div class=menu_item >
		      <span style="color:1a5cc8" id="dict_status"></span>
      </div>
      <script src="include/underlineTranslation.js" type="text/javascript"></script> 

		<?php }?>
</div><!--end menu-->
<div id=profile >

<?php if (isset($_SESSION['user_id'])){
				$sid=$_SESSION['user_id'];
				print "&nbsp;<a href=./modifypage.php>$MSG_USERINFO
					</a>&nbsp;<a href='./userinfo.php?user=$sid'>
				<span id=red>$sid</span></a>&nbsp;";
				$mail=checkmail();
				if ($mail)
					print "<a href=./mail.php>$mail</a>&nbsp;";
				print "<a href=./logout.php>$MSG_LOGOUT</a>&nbsp;";
			}else{
				print "<a href=./loginpage.php>$MSG_LOGIN</a>&nbsp;";
				print "<a href=./registerpage.php>$MSG_REGISTER</a>&nbsp;";
			}
			if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
				print "<a href=./admin>$MSG_ADMIN</a>&nbsp;";
			
			}
		?>


</div><!--end profile-->
</div><!--end subhead-->

<?php echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>";
	require('./admin/msg.txt');
	echo "</marquee>";

?>

<script src="include/underlineTranslation.js" type="text/javascript"></script> 
<script type="text/javascript">dictInit();</script> 
<div id=main>