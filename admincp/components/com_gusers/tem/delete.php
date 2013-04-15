<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	$obj=new CLS_GUSER();
	//begin update tuan 25/11/2011---------------------------------------------------------------------------------
	if($id == '1')
		echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D05'</script>"; 
	else{
		$result = $obj->Delete($id);
		if(!$result)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D02'</script>"; 
		else 
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=D01'</script>";
	}
	//end update tuan 25/11/2011---------------------------------------------------------------------------------
?>