<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$objproduct=new CLS_PRODUCTS();
$id = $_GET['id'];
$con = $_GET['con'];
if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
{
    $objproduct->Name=addslashes($_POST["txtname"]);
    $objproduct->CataID=addslashes($_POST["cbo_cata"]);
    $objproduct->Unit=addslashes($_POST["txtunit"]);
    $objproduct->Quantity=addslashes($_POST["txtquantity"]);
    $objproduct->Video=addslashes($_POST["txtthumb"]);

    $txtjoindate=trim($_POST["txtcreadate"]);
    $joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
    $objproduct->Joindate = date("Y-m-d",$joindate);
    $objproduct->Creator=$_SESSION["IGFUSERNAME"];
    $objproduct->Old_price=addslashes($_POST["txtoldprice"]);
    $objproduct->Cur_price=addslashes($_POST["txtcurprice"]);

    $objproduct->Sale=round(100-(((int)$_POST["txtcurprice"] / (int)$_POST["txtoldprice"])*100));

    $sproduct=addslashes($_POST['txtintro']);
    $objproduct->Intro=$sproduct;
    $objproduct->Fulltext=addslashes($_POST['txtdesc']);
    if(isset($_POST["cbocheck_iscan"]))
            $objproduct->Iscan=1;
    else
            $objproduct->Iscan=0;
    $objproduct->IsActive=(int)$_POST["optactive"];
    if(isset($_POST["txtid"])){
            $objproduct->ID=$_POST["txtid"];
    }
    //

    if($objproduct->ID=="-1"){
        $result_action = $objproduct->Update();
    }
    echo '<script type="text/javascript">window.location="index.php?com='.$con.'&task=add&proid='.$id.'"</script>';
}
?>
