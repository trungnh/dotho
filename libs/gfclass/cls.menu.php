<?php
class CLS_MENU extends CLS_MYSQL{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Code"=>"default",
					  "Name"=>"default",
					  "Desc"=>"",
					  "isActive"=>1
					  );
	function CLS_MENU()
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
	function getMenuByID($mnuid){
		$sql="SELECT * FROM `tbl_menus` WHERE `mnu_id`='$mnuid' ";
		parent::query($sql);
		if(parent::Numrows()>0)
		{
			$rows=parent::FetchArray();
			$this->pro_menu["ID"]=$rows["mnu_id"];
			$this->pro_menu["Code"]=$rows["code"];
			$this->pro_menu["Name"]=$rows["name"];
			$this->pro_menu["Desc"]=$rows["desc"];
			$this->pro_menu["isActive"]=$rows["isactive"];
		}
	}
	function getList($where=""){
		$sql="SELECT * FROM `tbl_menus` ".$where;
		parent::query($sql);
	}
	
	function getListmenu($type)
	{
		$this->getList(" WHERE `isactive`='1'");
		if($this->Numrows()<=0)
			return;
		$str="";
		while($rows=parent::FetchArray())
		{
			if($type=="list")
			$str.="<li><a  href=\"index.php?com=mnuitem&mnuid=".$rows["mnu_id"]."\" title=\"".$rows["name"]."\">".$rows["name"]."</a></li>";
			else if($type=="option")
			$str.="<option value=\"".$rows["mnu_id"]."\">".$rows["name"]."</option>";
			else 
			$str.=$rows["name"];
		}
		return $str;
	}
	function listTableMenu($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_menus` ".$strwhere ." LIMIT $star,$leng";
		parent::query($sql);
		$i=0;
		while($rows=parent::FetchArray())
		{	$i++;
			$mnuid=$rows["mnu_id"];$code=$rows["code"];$name=Substring($rows["name"],0,10);$desc=$rows["desc"];
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$mnuid\" />";
			echo "</label></td>";
			echo "<td width=\"75\" align=\"center\">$code</td>";
			echo "<td nowrap=\"nowrap\">$name</td>";
			echo "<td nowrap=\"nowrap\">$desc &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=menus&amp;task=active&amp;mnuid=$mnuid\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=menus&amp;task=edit&amp;mnuid=$mnuid\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=menus&amp;task=delete&amp;mnuid=$mnuid\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Numrows() { 
		return parent::Numrows();
	}
}
$objmenu=new CLS_MENU();
?>