<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();
$catid=0;
if(isset($_GET["catid"])) $catid = $_GET["catid"];
if(!isset($objmedia))
	$objmedia=new CLS_CONTENTS();
$total_rows="0";
if(!isset($_SESSION["CUR_PAGE_MNU"]))
	$_SESSION["CUR_PAGE_MNU"]=1;	
if(isset($_POST["cur_page"])){	$_SESSION["CUR_PAGE_MNU"]=$_POST["cur_page"];	}

$cur_page=$_SESSION["CUR_PAGE_MNU"];	
if(isset($_POST["txtCurnpage"])) $cur_page=$_POST["txtCurnpage"];
	
if(!isset($objdata)) $objdata = new CLS_MYSQL;
if(!isset($objcat)) $objcat = new CLS_CATE;

$objmedia->getList($catid,'ORDER BY `con_id`');
$title_category = $objcat->getNameCate($catid);
echo '<h3 class="title_category">'.$title_category.'</h3>';

if($objmedia->Numrows()>0){
	$total_rows=$objmedia->Numrows();
	$objmedia->ListByPaging($catid,'ORDER BY `con_id` DESC ',$cur_page);
	while($rows=$objmedia->FetchArray())
	{
		$intro = uncodeHTML(stripslashes($rows["intro"]));
		$conid = $rows["con_id"];
		$fulltext = stripslashes(uncodeHTML($rows["fulltext"]));
		//$link = 'index.php?com=contents&viewtype=block&catid='.$catid;
		$link = 'index.php?com=contents&viewtype=article&item='.$conid;
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
	<h3><a class="news_title" href="<?php echo WEBSITE; ?>article/<?php echo $rows["con_id"]; ?>-<?php echo stripUnicode($rows["title"]);?>.html" title="<?php echo stripslashes(uncodeHTML($rows["title"])); ?>">
        <?php echo stripslashes(uncodeHTML($rows["title"]));?>	
    </a></h3>    
    <div class="intro"><?php echo $intro; ?></div>
    <div style="float:right; pading-right:21px; color:#883300" class="readmore">		
        <a class="btn_detail" href="<?php echo WEBSITE."article/".$rows["con_id"]."-".stripUnicode($rows["title"]); ?>.html" title="Xem chi tiết"><small>>></small> Chi tiết <small><<</small></a>	
    </div>
</div>
<?php } 
?>
    <div id="paging_index" class="clearfix">
    <?php 
        paging_index($total_rows,MAX_ROWS_INDEX,$cur_page);
    ?>
    </div>
<?php
} 
else { echo 'Hệ thống đang cập nhật. Vui lòng quay lại mục này sau.';}?>

