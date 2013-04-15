<?php
class CLS_VIDEO extends CLS_MYSQL{
	var $pro_menu=array(
					  "ID"=>"-1",
					  "Title"=>"default",
					  "Link"=>"default",
					  "Content"=>"",
					  "isActive"=>1
					  );
    var $numrow=0;
	function CLS_VIDEO()
	{
	}
	// property set value
	function __set($proLink,$value)
	{
		if(!isset($this->pro_menu[$proLink]))
		{
			echo "Error";
			return;
		}
		$this->pro_menu[$proLink]=$value;
	}
	function __get($proLink)
	{
		if(!isset($this->pro_menu[$proLink]))
		{
			$this->callmess("$proLink ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_menu[$proLink];
	}
	function getMenuByID($id){
		$sql="SELECT * FROM `tbl_video` WHERE `id`='$id' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_menu["ID"]=$rows["id"];
			$this->pro_menu["Title"]=$rows["title"];
			$this->pro_menu["Link"]=$rows["link"];
			$this->pro_menu["Content"]=$rows["content"];
			$this->pro_menu["isActive"]=$rows["isactive"];
		}
	}
	function getList($where=""){
		$sql="SELECT * FROM `tbl_video` ".$where;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
        $this->numrow=$objdata->Numrows();
		return $objdata;
	}
	
	function getListmenu($type)
	{
		$objdata=$this->getList(" WHERE `isactive`='1'");
		if($objdata->Numrows()<=0)
			return;
		$str="";
		while($rows=$objdata->FetchArray())
		{
			if($type=="list")
			$str.="<li><a href=\"index.php?com=mnuitem&mnuid=".$rows["id"]."\">".$rows["link"]."</a></li>";
			else if($type=="option")
			$str.="<option value=\"".$rows["id"]."\">".$rows["link"]."</option>";
			else 
			$str.=$rows["link"];
		}
		return $str;
	}
	function listTableMenu($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_video` ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		while($rows=$objdata->FetchArray())
		{	$i++;
			$id=$rows["id"];$Title=$rows["title"];$Link=Substring($rows["link"],0,10);$Content==Substring($rows["content"],0,20);
			echo "<tr Link=\"trow\">";
			echo "<td width=\"30\" align=\"center\">$i</td>";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" Link=\"checkid\" id=\"checkid\" onclick=\"docheckonce('checkid');\" value=\"$id\" />";
			echo "</label></td>";
			echo "<td width=\"75\" align=\"center\">$Title</td>";
			echo "<td nowrap=\"nowrap\">$Link</td>";
			echo "<td nowrap=\"nowrap\">$Content &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=video&amp;task=active&amp;id=$id\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=video&amp;task=edit&amp;id=$id\">";
			showIconFun('edit','');
			echo "</a>";
			
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			
			echo "<a href=\"index.php?com=video&amp;task=delete&amp;id=$id\">";
			showIconFun('delete','');
			echo "</a>";
			
			echo "</td>";
		  	echo "</tr>";
		}
	}
	function Numrows() { 
		return $this->numrow;
	}
	function Add_new(){
		$sql="INSERT INTO `tbl_video`(`title`,`link`,`content`,`isactive`) VALUES ";
		$sql.=" ('".$this->pro_menu["Title"]."','".$this->pro_menu["Link"]."','".$this->pro_menu["Content"]."','".$this->pro_menu["isActive"]."') ";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Update(){
		$sql="UPDATE `tbl_video` SET `title`='".$this->pro_menu["Title"]."',`link`='".$this->pro_menu["Link"]."',`content`='".$this->pro_menu["Content"]."',`isactive`='".$this->pro_menu["isActive"]."' ";
		$sql.=" WHERE `id`='".$this->pro_menu["ID"]."'";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function ActiveOnce($ids){
		$sql="UPDATE `tbl_video` SET `isactive` = IF(isactive=1,0,1) WHERE `id` in ('$ids')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Publish($ids){
		$sql="UPDATE `tbl_video` SET `isactive` = '1' WHERE `id` in ('$ids')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function UnPublish($ids){
		$sql="UPDATE `tbl_video` SET `isactive` = '0' WHERE `id` in ('$ids')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
	function Delete($ids){
		$sql="DELETE FROM `tbl_video` WHERE `id` in ('$ids')";
		$objdata=new CLS_MYSQL();
		return $objdata->Query($sql);
	}
}
?>