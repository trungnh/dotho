<?php
class CLS_CATALOG{
	var $pro_catalog=array(
					  "ID"=>"-1",
					  "ParID"=>"0",
					  "Name"=>"",
					  "Intro"=>"",
					  "LangID"=>"0",
					  "isActive"=>1
					  );
	var $result;
	function CLS_CATALOG()
	{
	}
	// property set value
	function __set($proname,$value)
	{
		if(!isset($this->pro_catalog[$proname]))
		{
			echo "Error";
			return;
		}
		$this->pro_catalog[$proname]=$value;
	}
	function __get($proname)
	{
		if(!isset($this->pro_catalog[$proname]))
		{
			$this->callmess("$proname ". IS_NOT_MEMBER_IN_CLASS_MYSQL. " " );
			return;
		}
		return $this->pro_catalog[$proname];
	}
	function getCatalogByID($cataid){
		$sql="SELECT * FROM view_catalogs WHERE `cata_id`=\"$cataid\" ";
		//echo $sql;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			$rows=$objdata->FetchArray();
			$this->pro_catalog["ID"]=$rows["cata_id"];
			$this->pro_catalog["ParID"]=$rows["par_id"];
			$this->pro_catalog["Name"]=$rows["name"];
			$this->pro_catalog["Intro"]=$rows["intro"];
			$this->pro_catalog["isActive"]=$rows["isactive"];
		}
	}
	function getAllList($where=""){
		$sql="SELECT * FROM view_catalogs where 1=1 ".$where;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}	
	function getList($where=""){
			$sql="SELECT * FROM `view_catalogs` WHERE isactive=1 ".$where;
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			
		}
	function getCataIDChild($where=""){
		$sql="SELECT * FROM `view_catalogs` ".$where;
		$objdata=new CLS_MYSQL();
		$this->result=$objdata->Query($sql);
	}
	function getAllListAdmin($where="", $parid){
		$sql="SELECT * FROM view_catalogs where `par_id`=\"$parid\" ".$where;
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}	
	function getCatalogByParent($par_id){
		$sql="SELECT * FROM view_catalogs WHERE `par_id`=\"$par_id\"";
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
	}
	function listMenuCatalog($strwhere,$par_id,$level)
	{
	   $url=WEBSITE;
		$sql="SELECT name,cata_id,isactive FROM view_catalogs WHERE `par_id`='$par_id' AND  `isactive`=\"1\" $strwhere ";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()<=0) return;
		$str="";
		if($level==0)
			$style1="catalogtop";
		elseif($level==1)
			$style1="subcatalog";	
		else
			$style1="subcatalog-2";
		$str="<ul class=\"$style1\">";
		$i=0; $style2="";
		$style="";
		while($rows=$objdata->FetchArray())
		{
			$i++;
			$cataid=$rows["cata_id"];
			$name=$rows["name"];
			if($i==1)
			{
				$style="frist";
			}
			else
			{
				$style="";
			}
			if($this->haveChild($rows["cata_id"]) && $level==1) {
				$style2="li-chidl";
			}
			else
				$style2="";
			$str.='<li class="'.$style.' '.$style2.'"><a href="'.$url.'danhmuc/'.$cataid.'-'.stripUnicode($name).'.html" title="'.$name.'"><span>'.$name.'</span></a>';
			if($this->haveChild($rows["cata_id"])) {
				$str.=$this->listMenuCatalog($strwhere,$rows["cata_id"],++$level);
				--$level;
			}
			$style1="";
			$str.="</li>";
		}
		$str.="</ul>";
		return $str;
	}
	function showProNew_Numrow($cataid=0,$pro) {
			$sql="SELECT pro_id,name FROM view_products where cata_id = '$cataid' AND isactive=1 and `pro_id` in ($pro) ";
			//echo $sql;
			$objdata=new CLS_MYSQL;
			$this->result=$objdata->Query($sql);
			return $objdata->Numrows();
		}
	function listCataName($strwhere, $cata,$pro,$eventid)
	{
		$sql="SELECT name,cata_id,isactive,intro FROM view_catalogs WHERE `isactive`=\"1\" and `cata_id` in ($cata) $strwhere ";
		//echo $sql;
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		$str="";
		if($objdata->Numrows()<=0) return;
		while($rows=$objdata->FetchArray())
		{
			$i++;
			$cataid=$rows["cata_id"];
			$soluong=$this->showProNew_Numrow($cataid,$pro);
			$name=$rows["name"];
			//$str.="<a href=\"index.php?com=catalogs&ItemID=$cataid\">$name($soluong)</a>";
			echo'<li><a href="'.WEBSITE.'khuyenmai-'.$eventid.'-'.$cataid.'-'.stripUnicode($name).'.html" title="'.$name.'">'.$name.' ('.$soluong.')</a></li>';
		}
	}
	function listMenuTopCatalog($strwhere)
	{
		$sql="SELECT name,cata_id,isactive,intro FROM view_catalogs WHERE `isactive`=\"1\" '$strwhere' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$i=0;
		$str="";
		if($objdata->Numrows()<=0) return;
		while($rows=$objdata->FetchArray())
		{
			$i++;
			if($i==1)
				$style="frist";
			else
				$style="";
			$cataid=$rows["cata_id"];
			$name=$rows["name"];
			$intro=stripslashes($rows["intro"]);
			$str.="<a href=\"index.php?com=catalogs&ItemID=$cataid\">$intro$name</a>";
		}
		return $str;
	}
	function Numrows() { 
		if(mysql_num_rows($this->result))
			return @mysql_num_rows($this->result);
		return 0;
	}
	function Fecth_Array(){
			
		return @mysql_fetch_array($this->result);
	}
	function getIDByID($cataid){
        $cataid=(int)$cataid;
		$sql="SELECT * FROM `tbl_catalogs` WHERE `par_id`=\"$cataid\" ";
        //echo $sql;
        $strids="";
        $objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
		{
			while($rows=$objdata->FetchArray())
			{
				 $strids.=",".$rows["cata_id"]; 
			}
		}
        //return chop($strids)."','";
        return substr($strids,1);
	}
	function haveChild($parid) {
		$sql = "SELECT cata_id FROM tbl_catalogs WHERE par_id ='$parid' and `isactive`='1'"; 
		//echo $sql; die();
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Numrows()>0)
			return $objdata->Numrows();
		return 0;
	}
	function getChildID($parid) {
		$sql = "SELECT cata_id FROM tbl_catalogs WHERE par_id IN ('$parid')"; 
		$objdata = new CLS_MYSQL; 
		$this->result = $objdata->Query($sql);
		
		$ids='';
		if($objdata->Numrows()>0) {
			while($r = $objdata->FetchArray()) {
				$ids.=$r[0]."','";
				$ids.=$this->getChildID($r[0]);
			}
		}
		return $ids;
	}
}
?>