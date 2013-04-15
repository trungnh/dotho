<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define("COMS","users");

// Begin Toolbar
require_once(LAG_PATH."vi/lang_default.php");
require_once(libs_path."cls.users.php");
require_once(libs_path."cls.guser.php");

if(!isset($objlag)) $objlag=new LANG_DEFAULT;

$title_manager = "Quản lý người dùng";
if(isset($_GET["task"]) && $_GET["task"]=="add")
	$title_manager = "Thêm mới người dùng";
if(isset($_GET["task"]) && $_GET["task"]=="edit")
	$title_manager = "Sửa thông tin người dùng";
if(isset($_GET["task"]) && $_GET["task"]=="changepass")
	$title_manager = "Đổi mật khẩu";	

if(!isset($objmem)) $objmem = new CLS_USERS();
?>
<div id="menus" class="toolbars">
	  <form id="frm_menu" name="frm_menu" method="post" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><h2 style="margin:0px; padding:0px;"><?php echo $title_manager;?></h2></td>
			<td>
            <label>
			  <input type="hidden" name="txtids" id="txtids" />
			  <input type="hidden" name="txtaction" id="txtaction" />
			</label>
            </td>
			<td align="right">
			<ul>
				<?php 
				$task="";
				if($objmem->isAdmin()==false) {
					if(isset($_GET["task"])){
				?>
                    <li><a class="save"  href="#" onclick="dosubmitAction('frm_action','save');" title="<?php echo MSAVE;?>">
					<?php echo MSAVE;?></a></li>
                    <?php
                    }
				}
				else {
				if(!isset($_GET["task"])){
				?>
                <li><a class="publish" href="#" onclick="dosubmitAction('frm_menu','public');" title="<?php echo MPUBLISH;?>"><?php echo MPUBLISH;?></a> </li>
                <li><a class="unpublish" href="#" onclick="dosubmitAction('frm_menu','unpublic');" title="<?php echo MUNPUBLISH;?>"><?php echo MUNPUBLISH;?></a></li>
                <li><a class="edit" href="#" onclick="dosubmitAction('frm_menu','edit');" title="<?php echo MEDIT;?>"><?php echo MEDIT;?></a></li>
                <li><a class="addnew" href="index.php?com=<?php echo COMS;?>&task=add" title="<?php echo MADDNEW;?>"><?php echo MADDNEW;?></a></li>
                <li><a class="delete" href="#" onclick="dosubmitAction('frm_menu','delete');" title="<?php echo MDELETE;?>"><?php echo MDELETE;?></a></li>
                <?php 
				}
				else
				{?>
                <li><a class="save"  href="#" onclick="dosubmitAction('frm_action','save');" title="<?php echo MSAVE;?>"><?php echo MSAVE;?></a></li>
                <li><a class="close"  href="index.php?com=<?php echo COMS;?>" title="<?php echo MCLOSE;?>"><?php echo MCLOSE;?></a></li>
                <li><a class="help"  href="index.php?com=<?php echo COMS;?>&task=help" title="<?php echo MHELP;?>"><?php echo MHELP;?></a></li>
			<?php } 
				}
			?>
            </ul>
			</td>
		  </tr>
		</table>
	  </form>
	</div>
<?php

if(!isset($objmember)) $objmember =new CLS_USERS();
if(isset($_POST["txttask"]) && $_POST["txttask"]==1)
{
	$objmember->UserName=$_POST["txtusername"];
	$objmember->FirstName=$_POST["txtfirstname"];
	$objmember->LastName=$_POST["txtlastname"];
	
	$txtjoindate = $_POST["txtbirthday"];
	$joindate = mktime(0,0,0,substr($txtjoindate,3,2),substr($txtjoindate,0,2),substr($txtjoindate,6,4));
	$objmember->Birthday=date("Y-m-d",$joindate);
		
	$objmember->Gender=$_POST["optgender"];
	$objmember->Address=$_POST["txtaddress"];
	$objmember->Phone=$_POST["txtphone"];
	$objmember->Mobile=$_POST["txtmobile"];
	$objmember->Email=$_POST["txtemail"];
	$objmember->Gmember=$_POST["cbo_gmember"];
	$objmember->isActive=$_POST["optactive"];
	if(isset($_POST["txtid"]))
		$objmember->ID=$_POST["txtid"];
	if($objmember->ID=="-1")
	{
		$objmember->Password= trim($_POST["txtpassword"]);
		$result1=$objmember->Add_new();
		if(!$result1)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A02'</script>";
		else	
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=A01'</script>";
	}
	else {
		$result3=$objmember->Update();
		if(!$result3)
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U02'</script>";
		else	
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&mess=U01'</script>";
	}
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!="")
{
	$mnuids=$_POST["txtids"];
	$mnuids=str_replace(",","','",$mnuids);
	switch ($_POST["txtaction"])
	{
		case "public": 		$objmember->Publish($mnuids); 		break;
		case "unpublic": 	$objmember->UnPublish($mnuids); 		break;
		case "edit": 	
			$id=explode("','",$mnuids);
			echo "<script language=\"javascript\">window.location='index.php?com=".COMS."&task=edit&comid=".$id[0]."'</script>";
			exit();
			break;
		case "delete": 		$objmember->Delete($mnuids); 			break;
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}


define("THIS_COM_PATH",COM_PATH."com_".COMS."/");
if(isset($_GET["task"]))
	$task=$_GET["task"];
switch($task)
{
	case "add"	: include(THIS_COM_PATH."tem/add.php"); 	break;
	case "edit"	: include(THIS_COM_PATH."tem/edit.php");	break;
	case "active"	: include(THIS_COM_PATH."tem/active.php");	break;
	case "delete"	: include(THIS_COM_PATH."tem/delete.php");	break;
	case "logout"	: include(THIS_COM_PATH."tem/logout.php");	break;
	case "changepass"	: include(THIS_COM_PATH."tem/changepass.php");	break;
	default:  include(THIS_COM_PATH."tem/list.php");
}

// close object
unset($objmember);
unset($objlag);
unset($result1);unset($result2);unset($result3);
?>