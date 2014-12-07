<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$objproduct=new CLS_PRODUCTS();
$data = new CLS_MYSQL();
$proIsEdit = true;
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $objproduct->getProByID($id);
    $sql = "SELECT isedit FROM tbl_products WHERE pro_id=".$id;
    $data->Query($sql);
    if($data->Numrows()>0){
        
        $rows=$data->FetchArray();
        if($rows['isedit']==0)
            $proIsEdit = false;
    }
     if(!$proIsEdit)
         $objproduct->Delete($id);
    echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
    
}
?>
