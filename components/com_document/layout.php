
<script language="javascript" src="js/function_doc.js"></script>
<?php
$msg ='';

  if(!isset($objdata)) $objdata = new CLS_MYSQL();
  if(!isset($objdoc)) $objdoc = new CLS_DOCUMENT();

  $folderid =''; $url='';


  if(isset($_GET["folderid"])) 
	$folderid=$_GET["folderid"]; //echo $id;
	
  if(isset($_POST["cbofolder"]) && $_POST["cbofolder"]!='') 
	$folderid=$_POST["cbofolder"]; //echo $folderid;	
	
  if(isset($_POST["txturl"])) {
	$url=$_POST["txturl"];
	if(strlen($url)>8) 
		{$url = substr($url,0,strlen($url)-1); // loai bỏ ký tự "/" ở cuối xâu
		$vitri = strrpos($url,"/"); // Tìm vị trí cuối cùng xuất hiện của dấu "/". strrpos:Tìm vị trí lần xuất hiện cuối cùng cùng của một kí tự trong một xâu.
		//echo $vitri;
		if($vitri!=0) $url = substr($url,0,$vitri)."/"; 
	}
  }
?>
<h3 class="tailieu">Tài liệu Download</h3>
<form name="frmdocument" id="frmdocument" action="" method="post">
  <table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
	  <tr>
	    <td>Chọn thư mục 
	      <select name="cbofolder" id="cbofolder" onchange="frmdocument.submit()">
          <option value="" style="background-color:#ccc;">-- Chọn thư mục & tệp tin --</option>
          <option value="0" <?php if($folderid==0) echo ' selected="selected"' ;?>>Tất cả các thư mục & tệp tin gốc</option>
          <?php  $objdoc->getListDoc(0,1,$folderid);?>
        </select> <?php //echo "url=".$url." ; docid=".$folderid;?>   </td>
    </tr>
  </table>
</form>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tbldocument">
  <tr><td colspan="3">
  <?php if( ($url=='' && $folderid!=0 && $folderid!='') || ($url!='' && $url!='tailieu/' ) ) { ?>
  <form name="frmbackdocument" id="frmbackdocument" action="#" method="post">
  <input type="submit" name="backurl" id="backurl" onclick="javascript:frmbackdocument.submit()" value="<< Quay lại thư mục trước"/>
  </a>
  <input type="hidden" name="txturl" id="txturl" value="<?php echo $_SESSION["URLDOC"];?>" />
  </form>
  <?php } ?>
  </td></tr>
  <?php
    
  if($folderid==''){
	 	$objdata = $objdoc->getAllList(" WHERE par_id=0 ORDER BY loai DESC, name ASC");
  }
  else
  	$objdata = $objdoc->getAllList(" WHERE par_id=".$folderid." ORDER BY loai DESC, name ASC");

 if($url!='') {
	$objdata = $objdoc->getAllList(" WHERE urlfile='$url' ORDER BY loai DESC, name ASC");
 }
// Lay link tai lieu
if(!isset($_SESSION["URLDOC"])) $_SESSION["URLDOC"]='tailieu/';

if($folderid=='' || $folderid==0) 
	$_SESSION["URLDOC"]='tailieu/';
else
	$_SESSION["URLDOC"]=$objdoc->getURLdoc($folderid);

if($url!='' && $url!="tailieu/") {
	$_SESSION["URLDOC"]=$url;
}
  $i=1;
  while ($r=$objdoc->FetchArray()) {
  ?>
  <tr class="row<?php echo $i;?>">
    <td width="50">
	<?php 
	$isactive 	= $r["isactive"];
	$docid 		= $r["doc_id"];
	$outsite 	= $r["outsite"];
	$loai 		= $r["loai"];
	$type 		= $r["type"];
	
	if($loai==1) 
		echo '<img src="images/icon/folder.gif" height="32" />'; 
	else {
		switch($type) {
			case 'image/png': 
			case 'image/x-png':
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/gif':	
				echo '<img src="images/icon/7.gif" height="32"/>'; break;
			
			case 'text/plain': //.txt
			break;
			
			case 'application/msword':	
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': //.docx word 2007
				echo '<img src="images/icon/icon_doc.gif" height="11"/>'; break;
			
			case 'application/vnd.ms-excel':	
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation': //.xlsx Excel 2007
				echo '<img src="images/icon/icon_xls.gif" height="11"/>'; break;
			
			case 'application/vnd.ms-powerpoint':
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation"': //.pptx PowerPoint 2007	
				echo '<img src="images/icon/icon_ppt.gif" height="11"/>'; break;
				
			case 'application/pdf':	
				echo '<img src="images/icon/icon_pdf.gif" height="11"/>'; break;
				
			case 'application/download': 
			case 'application/octet-stream': //.zip	
				echo '<img src="images/icon/icon_zip.gif" height="11"/>'; break;
				
			case 'application/x-rar-compressed': 
			case 'application/rar':	
				echo '<img src="images/icon/icon_rar.gif" height="11"/>'; break;
			default: 	echo '<img src="images/icon/5.gif" height="32"/>';
		}
	}
	?></td>
    
    <td>
    <?php 
	if($loai!=1) 
		 echo stripslashes($r["name"]);
	else {
	?>

    <a href="?com=document&folderid=<?php echo $docid;?>"><?php echo stripslashes($r["name"]);?></a>
    <?php } ?>
    </td>
    <td width="200" align="center">    
    <?php 
	//require_once(LIB_PATH."gfclass/cls.customer.php");
	//if(!isset($objcus)) $objcus = new CLS_CUSTOMER();

	//$objcus-> LOGOUT();
	if($loai!=1) { 
		//if($objcus-> isLogin()==false) {
			//echo "<a href=\"?com=login\" class=\"download\"><img src=\"images/icon/download.gif\" height=\"24\" align=\"absmiddle\" alt=\"Download File\"/> Download File</a>";
		//}
		// else {
			if($outsite!='')
				echo '<a href="'.$outsite.'" target="_blank" class="download"><img src="images/icon/download.gif" height="24" align="absmiddle" alt="Download File"/> Download File</a>';
			else 
				echo "<a href=\"javascript:download_file('".HOST_URL."download.php?id=".$docid."')\" class=\"download\"><img src=\"images/icon/download.gif\" height=\"24\" align=\"absmiddle\" alt=\"Download File\"/> Download File</a>";
		//}
	} // end if $loai!=1
	?>
    </td>
  </tr>
  <?php 
  if($i==1) $i=2;
	  else $i=1;
  } // end while
  ?>
</table>
