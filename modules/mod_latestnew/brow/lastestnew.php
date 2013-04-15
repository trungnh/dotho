<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
$objcon->getList($objmodule->CatID," LIMIT 0,4");
?>
<?php /*?>	<?php if($objmodule->ViewTitle==1)
	{?>
	<h3 class="title"><?php echo $objmodule->Title;?></h3>
    <?php 
	}<?php */?>
    <?php
	$i=1;
	while($rows = $objcon->FetchArray()) {
		$title = stripslashes($rows["title"]);
		//$intro = Substring(stripslashes($rows["intro"]),0,50);
		$fulltext = stripslashes($rows["fulltext"]);
		$link = WEBSITE.'article/'.$rows["con_id"]."-".stripUnicode($title).".html";
    	
		$imgs=$clsimage->get_image($fulltext);
		
		$width = "100%";
		if($imgs!='') {
			$imgs ='<img src="'.$imgs.'"/>';
			$width="150px";
		}
		echo "<div class=\"item\">
				<div class=\"boximg\">$imgs</div>
				<a href=\"$link\" title=\"$title\"><h4 class=\"title\">$title</h4></a>
			 </div>";
		$i++;
    } 
	?>

<?php
unset($objcon);
unset($objmodule);
unset($clsimage);
?>