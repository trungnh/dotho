<?php 
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATE();

$objcat->getCatIDChild(" WHERE par_id=".$objmodule->CatID." AND isactive=1 LIMIT 0,4");

$link = WEBSITE.'block/'.$objmodule->CatID."-".stripUnicode($objmodule->Title).".html";
?>
<div class="module <?php echo " ".$objmodule->Class;?>">
	<?php if($objmodule->ViewTitle==1)
	{
		echo '<a href="'.$link.'" class="know_heading"><h2>'.$objmodule->Title.'</h2></a>';
	}

	while($rows = $objcat->Fecth_Array()) {
		$catid = $rows["cat_id"];
		$link = WEBSITE.'block/'.$catid.'-'.$rows["name"].".html";
		echo '<div class="know">
				<a href="'.$link.'" class="know_item"><h3>'.$rows["name"].'</h3></a>
				<ul>';
		$objcon->getList($catid," ORDER BY con_id DESC LIMIT 0,5");
		while ($rows2 = $objcon->Fecth_Array()) {
			$title = Substring(stripslashes($rows2["title"]),0,7);
			$link = WEBSITE.'article/'.$rows2["con_id"]."-".stripUnicode($rows2["title"]).".html";
			echo '<li><a href="'.$link.'" title="'.stripslashes($rows2["title"]).'">'.$title.'</a></li>';			
		}
		echo '</ul>
			</div>';
    } 
	?>
</div>

<?php
unset($objcat);
unset($objcon);
unset($objmodule);
?>