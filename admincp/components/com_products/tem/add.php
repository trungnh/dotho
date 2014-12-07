<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$objproduct=new CLS_PRODUCTS();
        $objproduct->Name = "Tên sản phẩm mới";
        $objproduct->Add_new();
        $proid = $objproduct->lastProId;
        $_SESSION['addnew'] = "1";
        echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&proid=".$proid."'</script>";
?>
