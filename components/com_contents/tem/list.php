<?php 
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

$objmedia->getList($catid,'ORDER BY `con_id` DESC LIMIT 0,20');
$title_category = $objcat->getNameCate($catid);
echo '<h3 class="title_category">'.$title_category.'</h3>';

if($objmedia->Numrows()>0){
	$total_rows=$objmedia->Numrows();
	echo '<ul>';
	while($rows=$objmedia->FetchArray())
	{
	   ?>
	<li>
	<a class="news_title" href="<?php echo WEBSITE."article/".$rows["con_id"]."-".stripUnicode($rows["title"]);?>.html" title="<?php echo stripslashes(uncodeHTML($rows["title"]));?>">		
        <?php echo stripslashes(uncodeHTML($rows["title"]));?>	
    </a>       
    </li>
<?php } 
	echo '</ul>';
} 
else { echo 'Hệ thống đang cập nhật. Vui lòng quay lại mục này sau.';}?>

