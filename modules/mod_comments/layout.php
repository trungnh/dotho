<?php include("helper.php");
$theme = 'brow1';
if($objmodule->Theme!='') 
$theme = $objmodule->Theme;

if(!isset($objcom))
$objcom= new CLS_COMM();
//echo $_SESSION["IGFUSERNAME"];
if(isset($_POST["bt_submit"]))
{
	//print_r($_POST); die();
$objcom->par_id=0;
$objcom->con_id=$_POST["txtconid"];
$objcom->pro_id=addslashes($_POST["title"]);
$objcom->username=$_POST["name"];
$objcom->joindate=date("Y-m-d h:i:s");
$objcom->isactive=1;
$sContent=addslashes($_POST["content"]);
$objcom->Content=encodeHTML($sContent);
if($objcom->Content!="")
$objcom->Add_new();
echo "<script language=\"javascript\">alert(\"Cảm ơn bạn đã góp ý cho chúng tôi!\");</script>";
}

?>
	<?php if($objmodule->ViewTitle==1){?>
		<h3><span><?php echo $objmodule->Title;?></span></h3>
	<?php } 

 include_once(MOD_PATH."mod_comments/brow/".$theme.".php"); ?>
<?php 
unset($objmodule);

?>