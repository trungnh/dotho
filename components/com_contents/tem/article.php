<?php
$item=""; $lagid=0;
if(isset($objmenu))
	$item=$objmenu->Con_ID;

if(isset($_GET["item"]))
	$item=$_GET["item"];

if($item!="")
{
	if(!isset($objitem)) $objitem=new CLS_CONTENTS();
	
	//Dem luot xem bai viet
	if(!isset($_SESSION["VIEW_ARTICLE_ID"])) {
		$_SESSION["VIEW_ARTICLE_ID"]=$item;
		$objitem->AddVisited($item);
	}
	else if($_SESSION["VIEW_ARTICLE_ID"]!=$item){
		$_SESSION["VIEW_ARTICLE_ID"]=$item;
		$objitem->AddVisited($item);
	}
	
	$objitem->getConByID($item,$lagid);
	if(!isset($objname))
		$objname= new CLS_CATE();
	$name=$objname->getNameCate($objitem->CatID);
?>
<div class="content_body">
    <div class="title"><h3><?php echo stripslashes(uncodeHTML($objitem->Title)); ?></h3></div>
    <div class="content">
        <?php echo stripslashes(uncodeHTML($objitem->Fulltext));?>
    </div>
    <div class="content_share"><?php include_once("components/com_contents/tem/icon.php");?></div>
</div>
<?php 
} 
?>
<?php
if(!isset($_GET["cur_menu"]))
{
	$cata=$objitem->CatID;
	$id=$objitem->ID;
	if(!isset($objmedia))
		$objmedia=new CLS_CONTENTS();
	$objmedia->getAllList(" AND `cat_id`='$cata' AND `con_id`<>'$item' AND `isactive`='1' ORDER BY `con_id` DESC LIMIT 0,20");
	if($objmedia->Numrows()>0)
	{
		echo '<div class="mod-new"><h3 class="newrelax">Bài viết cùng chuyên mục</h3><ul class="newlist">';
		while($rows=$objmedia->FetchArray())
		{
?>
		<li><a href="<?php echo WEBSITE; ?>article/<?php echo $rows["con_id"]; ?>-<?php echo stripUnicode($rows["title"]); ?>.html" title="<?php echo stripslashes(uncodeHTML($rows["title"]));?>"><?php echo stripslashes(uncodeHTML($rows["title"]));?></a></li>
	<?php 
		}
		echo '</ul></div>';
	}
}
?>
