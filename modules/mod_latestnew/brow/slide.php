<?php
/*
require_once(libs_path."gfclass/cls.simple_image.php");

if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
$objcon->getList($objmodule->CatID," ORDER BY `order` ASC");
?>
<div class="slide">
    <div class="slidepad">
        <div class="slideshow">
            <?php if($objmodule->ViewTitle==1)
            {?>
            	<h3 class="title"><?php echo $objmodule->Title;?></h3>
            <?php 
            }
            $n = $objcon->Numrows();
            while($rows = $objcon->FetchArray()) {
                $intro = stripslashes(uncodeHTML($rows["fulltext"]));
                $link = WEBSITE.'article/'.$rows["con_id"]."-".$rows["title"].".html";
                echo '<div class="slideitem">'.$intro.'</div>';
            } 
            ?>
        </div>
        <div class="slide_paging" style="display: block;">
			<?php 
            for($i=1;$i<=$n;$i++) { 
                if($i==1)
                    echo '<a rel="'.$i.'" href="#" class="active"></a>';
                else
                    echo '<a rel="'.$i.'" href="#" class=""></a>';
            } ?>
        </div>
    </div>
    
</div>

<?php
unset($objcon);
unset($objmodule);
unset($clsimage);
 * 
 */
?>
<script src="jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function() {

    $('#slidernivo').nivoSlider({

        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'

        slices: 15, // For slice animations

        boxCols: 8, // For box animations

        boxRows: 4, // For box animations

        animSpeed: 500, // Slide transition speed

        pauseTime: 3000 // How long each slide will show

        

    });

});

</script>

<div class="sliderwrapper">

<div id="slidernivo" class="container nivoSlider">

    <img src="<?php echo WEBSITE.THIS_TEM_PATH; ?>images/s1.jpg" alt="SteelViet" height="180" width="540" />

    <img src="<?php echo WEBSITE.THIS_TEM_PATH; ?>images/s7.jpg" alt="SteelViet" height="180" width="540" />

    <img src="<?php echo WEBSITE.THIS_TEM_PATH; ?>images/s5.jpg" alt="SteelViet" height="180" width="540" />

    <img src="<?php echo WEBSITE.THIS_TEM_PATH; ?>images/s6.jpg" alt="SteelViet" height="180" width="540" />

</div>

</div><!-- end slider -->