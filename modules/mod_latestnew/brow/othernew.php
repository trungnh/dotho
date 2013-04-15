<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATE();

//$objcat->getCatIDChild(" WHERE par_id=".$objmodule->CatID." LIMIT 0,4");
$link = 'index.php?com=contents&viewtype=block&catid='.$objmodule->CatID;
$objcon->getList($objmodule->CatID," order by con_id DESC LIMIT 0,1");
?>
	<?php if($objmodule->ViewTitle==1)
	{
		echo "<h3><span>".$objmodule->Title.'</span></h3>';
	}
		$rows = $objcon->FetchArray();
		$conid = $rows["con_id"];
		$fulltext = stripslashes($rows["fulltext"]);
		//$link = 'index.php?com=contents&viewtype=block&catid='.$catid;
		$link = 'index.php?com=contents&viewtype=article&item='.$conid;
		$imgs=$clsimage->get_image($fulltext);
		$title=$rows["title"];
		$intro=$rows["intro"];
		$width = "100%";
		if($imgs!='') {
			$imgs ="<img src=\"$imgs\" alt=\"$title\" />";
		}
		echo "<div class=\"content\"><div class=\"new\">
			<div class=\"box-img\">$imgs</div>
			<h4 class=\"title\">$title</h4>
            <div class=\"intro\">$intro";
			echo date("m/Y",strtotime($rows["modifydate"]));
			echo "</div>
            <a class=\"readmore\" href=\"$link\">Xem thêm</a></div>
		<ul class=\"mod-relax-new\">";
		$objcon->getList($objmodule->CatID," ORDER BY con_id DESC LIMIT 1,5");
		while ($rows2 = $objcon->FetchArray()) {
			$title = Substring(stripslashes($rows2["title"]),0,7);
			$link = 'index.php?com=contents&viewtype=article&item='.$rows2["con_id"];
			echo '<li><a href="'.$link.'" title="'.stripslashes($rows2["title"]).'">'.$title.'</a></li>';			
		}
		echo '</ul></div>';
unset($objcat);
unset($objcon);
unset($objmodule);
?>
