<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($_SESSION["CUR_PAGE_MNU"]))
	$_SESSION["CUR_PAGE_MNU"]=1;
if(isset($_POST["cur_page"])){
	$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];
}
$cur_page=$_SESSION["CUR_PAGE_MNU"];
if(isset($_POST["txtCurnpage"]))
		$cur_page=$_POST["txtCurnpage"];
//echo $cata;
$total_rows="";
$title="";
$ketqua=false;

if(isset($_POST["txtsearch"]))
   $title= trim($_POST["txtsearch"]);

if(!isset($objsearch))
   $objsearch=new CLS_CONTENTS();
?>


<div id="result_search">
<?php

// KET QUA TIM KIEM TU KHOA THEO BAI VIET

$objsearch->getListSearch(" where (`title` LIKE \"%".addslashes($title)."%\" OR `intro` LIKE \"%".addslashes($title)."%\") AND `isactive`='1'");
//echo $title;
if($objsearch->Numrows()>0){
	$ketqua=true;
   $total_rows=$objdata->Numrows();
   $obj=$objsearch->ListSearchPaging(" where (`title` LIKE \"%".addslashes($title)."%\" OR `intro` LIKE \"%".addslashes($title)."%\") AND `isactive`='1' order by `con_id` DESC",$cur_page);

	echo '<h3 style="border-bottom:1px solid #ccc; margin: 0 0 7px 5px; padding:5px 0"> CÁC BÀI VIẾT CÓ LIÊN QUAN ĐẾN TỪ KHÓA: <span style="color:red">"'.stripslashes($title).'"</span></h3>';	
	while($rows=$objsearch->FetchArray())
	{
	$intro = uncodeHTML(stripslashes($rows["intro"]));
		$conid = $rows["con_id"];
		$fulltext = stripslashes(uncodeHTML($rows["fulltext"]));
		//$link = 'index.php?com=contents&viewtype=block&catid='.$catid;
		$imgs=$clsimage->get_image($fulltext);
		$title=$rows["title"];
		$imgview=uncodeHTML($imgs);
		//echo $imgview;
	   ?>
<div class="news clearfix">
	<?php if($imgs!="")
		//ECHO $imgview;
		echo '<div class="boximg"><img src='.WEBSITE.$imgview.' /></div>'; 
	?>
	<h3><a class="news_title" href="<?php echo WEBSITE."article/".$rows["con_id"]."-".stripUnicode($rows["title"]); ?>.html">
        <?php echo stripslashes(uncodeHTML($rows["title"]));?>	
    </a></h3>    
    <div class="intro"><?php echo $intro; ?></div>
    <div style="float:right; pading-right:21px; color:#883300" class="readmore">		
        <a class="btn_detail" href="<?php echo WEBSITE."article/".$rows["con_id"]."-".stripUnicode($rows["title"]); ?>.html"><small>>></small> Chi tiết <small><<</small></a>	
    </div>
</div>
<?php } //end while
}  // end if
if($ketqua==false) echo '<h3 style="border-bottom:1px solid #ccc; padding:5px 0"> KHÔNG TÌM THẤY NỘI DUNG CÓ LIÊN QUAN ĐẾN TỪ KHÓA: <span style="color:red">"'.$title.'"</span></h3>';

unset($objdata);
unset($objsearch);
?>
</div>
<div id="paging_index" class="clearfix" style="text-align: center; margin-top: 10px;">
<?php 
    paging_index($total_rows,MAX_ROWS_INDEX,$cur_page);
?>
</div>