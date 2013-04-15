<?php
  include("../capchar/securimage.php");
  $img = new Securimage();  
  if(isset($_POST["check_validate"]) && $_POST["check_validate"]!='')
	{
	 $check_validate=trim($_POST['check_validate']);
	 $valid = $img->check($check_validate);
	 
	 if($valid == false)
		 echo "no";
	 else
		 echo "yes";
	}
else 
	echo 'nodata';
?>