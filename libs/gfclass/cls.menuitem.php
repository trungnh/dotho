<?php
class CLS_MENUITEM{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Par_ID"=>"0",
					  "Code"=>"",
					  "Name"=>"default",
					  "Desc"=>"",
					  "Mnu_ID"=>"0",
					  "Viewtype"=>"block", // block, link, list, detail
					  "Cat_ID"=>"0",
					  "Con_ID"=>"0",
					  "Link"=>"",
					  "Class"=>"",
					  "Order"=>"",
					  "isActive"=>1
					  );
	var $result;
	function CLS_MENUITEM()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_menu[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_menu[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_menu[$proname];
	}
	function getMenuItemByID($mnuid){
		$sql="SELECT * FROM `tbl_mnuitem` WHERE `mnuitem_id`='$mnuid' ";
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_menu["ID"]=$rows["mnuitem_id"];
			$this->pro_menu["Par_ID"]=$rows["par_id"];
			$this->pro_menu["Code"]=$rows["code"];
			$this->pro_menu["Name"]=$rows["name"];
			$this->pro_menu["Desc"]=$rows["desc"];
			$this->pro_menu["Mnu_ID"]=$rows["mnu_id"];
			$this->pro_menu["Viewtype"]=$rows["viewtype"];
			$this->pro_menu["Cat_ID"]=$rows["cat_id"];
			$this->pro_menu["Con_ID"]=$rows["con_id"];
			$this->pro_menu["Link"]=$rows["link"];
			$this->pro_menu["Class"]=$rows["class"];
			$this->pro_menu["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($mnuid=0,$where=""){
		if($where!="")
			$where=" WHERE `mnu_id`='$mnuid' AND ".$where;
		$sql="SELECT * FROM `view_mnuitem` ".$where;
		//echo $sql;
		$objdata=new CLS_MYSQL;
		$this->result=$objdata->Query($sql);
	}
	function haveChild($parid) {
		$sql = "SELECT * FROM view_mnuitem WHERE par_id='$parid'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
			return $objdata->Numrows();
		return 0;
	}
	
	function ListMenuItem($mnuid,$par_id,$level,$curmenu)
	{
	   $url=WEBSITE;
		$sql="SELECT * FROM `view_mnuitem` WHERE `par_id`='$par_id' AND `mnu_id`='$mnuid' AND`isactive`='1' ORDER BY `order` ASC";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()<=0)
			return;
		$style=""; $style2="";
		if($level!=0)
			$style="submenutop";
		else
			$style="clearfix topmenu";
		$str="<ul class=\"$style\">";
		$i=0;
		while($rows=$objdata->FetchArray())
		{
			$i++;
			$urllink="index.php?com=contents&viewtype=".$rows["viewtype"]."&cur_menu=".$rows["mnuitem_id"];
			$taget="";
			if($i==1)
				$style2="none";
			else
				$style2="";
			if($rows["viewtype"]=="link")
			{
				if(trim($rows["link"])!="")
				{
					$urllink=$rows["link"];
					if(strpos($urllink,"?com")=== false)
						$urllink.="?cur_menu=".$rows["mnuitem_id"];
					else
						$urllink.="&cur_menu=".$rows["mnuitem_id"];
				}
				else{
					$urllink="index.php"."?cur_menu=".$rows["mnuitem_id"];
				}
			}
			else if($rows["viewtype"]=="article")
			{
                $urllink=$url."article/".$rows["con_id"]."-".stripUnicode($rows["name"]).".html";
			}
			else if($rows["viewtype"]=="block" || $rows["viewtype"]=="list" )
			{
				$urllink=$url."block/".$rows["cat_id"]."-".stripUnicode($rows["name"]).".html";
			}
			$cls=$rows["class"];
			$curmenu=$_SESSION["CUR_MENU"];
			if(isset($curmenu) && $curmenu!="")
				$cls="";
			if($curmenu==$rows["mnuitem_id"])
			$cls="active";
			$str.="<li class=\"$cls\"><a class=\"nav$i $style2\" href=\"$urllink\" $taget title=\"".$rows["name"]."\" ><span>".$rows["name"]."</span></a>";
			if($this->haveChild($rows["mnuitem_id"])) {
				//$str.='<div class="box_submenu">';
				if(trim($rows["desc"])!='' && trim($rows["desc"])!='<br>' && trim($rows["desc"])!='&nbsp;' )
					$str.='<div class="intro_submenu">'.$rows["desc"].'</div>';
				$str.=$this->ListMenuItem($mnuid,$rows["mnuitem_id"],$level+1,$curmenu);
				//$str.='</div>';
			}
			$str.="</li>";			
		}
		$str.="</ul>";
		return $str;
	}
	function Numrows() { 
		return @mysql_numrows($this->result);
	}
	function FetchArray(){
		return mysql_fetch_array($this->result);
	}
}
$objmenu=new CLS_MENU();
?>