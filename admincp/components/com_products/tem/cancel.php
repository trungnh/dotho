<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$objproduct=new CLS_PRODUCTS();
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $objproduct->getProByID($id);

    $objproduct->Delete($id);
    unset($_SESSION['NEWID']);
    echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
    
}
?>
