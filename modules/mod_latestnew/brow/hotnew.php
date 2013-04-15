<?php
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
$objcon->getList($objmodule->CatID," LIMIT 0,5");
?>
<div id="service_box">
<div class="module<?php echo " ".$objmodule->Class;?>">
	<?php if($objmodule->ViewTitle==1)
	{?>
	<h3 class="title"><?php echo $objmodule->Title;?></h3>
    <?php 
	}
	while($rows = $objcon->FetchArray()) {
		$title = stripslashes($rows["title"]);
		$intro = stripslashes($rows["intro"]);
		$price='';
		if(strpos($intro,"{price:")===false) {
		}
		else {
			$arr   = explode("{price:",$intro);
			$arr_price   = explode("}",$arr[1]);
			$price = trim($arr_price[0]);
			
			$intro = Substring($arr[0],0,35);
		}
		$fulltext = stripslashes($rows["fulltext"]);
		$link = WEBSITE.'article/'.$rows["con_id"]."-".stripUnicode($title).".html";
		
		echo '<div class="service">
				<div class="serpad">
					<a href="'.$link.'"><h1>'.$title.'</h1></a>
		  	  		<div class="serconent">'.$intro.'</div>
					<a href="'.$link.'" class="readmore"><small>>></small> Chi tiết <small><<</small> </a>
		  	  		<div class="serprice">'.$price.'</div>
				</div>
			</div>';
    } 
	?>
</div>
</div>
<?php
unset($objcon);
unset($objmodule);
?>