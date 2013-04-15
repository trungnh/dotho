<div class="box-support">
<?php
  $nick_y = explode(",",NICKYAHOO);
  //$ten_y = explode(",",TENYAHOO);
  $name_y = explode(",",NAMEYAHOO);
  
  $n = count($nick_y);
  
 $url=WEBSITE;
  for ($i=0;$i<$n;$i++) {
     
       if(isset($nick_y[$i]))
        {
        echo '<a class="img" href="ymsgr:sendim?"'.$nick_y[$i].'"><img align="middle" alt="'.$name_y[$i].'" border="0" src="'.$url.'images/yahoo.png">'.$name_y[$i].'</a>';
        }
        else echo "";
        /*if(isset($ten_y[$i]))
        {
        echo '<span class="xuong">' .$ten_y[$i] . "</span></div></div>";
        }
        else echo "";*/   
  }  
?>
</div>