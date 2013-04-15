<?php
$linkarticle = WEBSITE."/index.php?com=products&ItemID=".$id;
$linkarticle=str_replace("/","%2F",$linkarticle);
$linkarticle=str_replace("?","%3F",$linkarticle);
$linkarticle=str_replace("&","%26",$linkarticle);
$linkarticle=str_replace("=","%3D",$linkarticle);
include_once(LIB_PATH."gfclass/cls.configcontent.php");
if(!isset($obj_config)) $obj_config = new CLS_CONFIGCONTENT();
$obj_config->getList(" WHERE isactive=1 ORDER BY id  ASC");

$tags=''; $icons=''; $author='';
if($obj_config->Numrows()>0) {
	while ($rows = $obj_config->FetchArray()) {
		$ids	=	$rows["id"];
		$name = $rows["name"];
		$icon = $rows["icon"];
		$showN = $rows["show_name"];
		$showI = $rows["show_icon"];
		//echo $ids;
		if($ids<4) {
		switch($ids) {
			case '1': 
				$author.= '<span class="showdate" href="">'; 
				$str='';
				if($showI==1 && $icon!='') $author.='<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1 && $objproduct->Joindate!="0000-00-00") $author.= $name.": ".$objproduct->Joindate;
				$author.=  '</span>';
				break;
			case '2':
				$author.=  '<span class="showdate" href="">'; 
				$str='';
				if($showI==1 && $icon!='') $author.='<img src="'.$icon.'" align="absmiddle" title="'.$name.'"/>';
				if($showN==1 && $objproduct->Joindate!="0000-00-00") $author.= $name.": ".$objproduct->Joindate;
				$author.=  '</span>';
				break;
			case '3': 
				$author.=  '<span class="showdate" href="">'; 
				$str='';
				if($showI==1 && $icon!='') $author.='<img src="'.$icon.'" align="absmiddle" title="'.$name.'"/>';
				if($showN==1 && $objproduct->Creator!='') $author.= $name.": ".$objproduct->Creator;
				$author.=  '</span>';
				break;
		}
		}
		if($ids>4) {
		switch($ids) {
			case '5':
				$icons.= '<a target="_blank" class="showicon" href="" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '6':
				$icons.= '<a target="_blank" class="showicon" href="http://link.apps.zing.vn/share?u='.$linkarticle.'" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '7':
				$icons.= '<a target="_blank" class="showicon" href="ymsgr:im?+&msg='.$linkarticle.'" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '8':
				$icons.= '<a target="_blank" class="showicon" href="http://www.facebook.com/sharer.php?u='.$linkarticle.'" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '9':
				$icons.= '<a target="_blank" class="showicon" href="http://twitter.com/home?status='.$linkarticle.'" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '10':
				$icons.= '<a target="_blank" class="showicon" onClick="javascript:window.location='."'mailto:".$linkarticle."'".'" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '11':
				$icons.= '<a class="showicon" onClick="javascript:if(document.all)window.external.AddFavorite(location.href,document.title); else if(window.sidebar)window.sidebar.addPanel (document.title,location.href,'."''".');" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			case '12':
				$icons.= '<a class="showicon" onClick="javascript:window.open('."'"."print.php?item=".$item."','In trang','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=580,height=580,directories=no,location=no'".')" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
				break;
			default:
				$icons.= '<a  class="showicon" href="" title="'.$name.'">'; 
				if($showI==1 && $icon!='') $icons.= '<img src="'.$icon.'" align="absmiddle"/>';
				if($showN==1) $icons.=$name;
				$icons.= '</a>';
		}
		}
		if($ids==4){
			$str='';
			if($showI==1 && $icon!='') $str= '<img src="'.$icon.'" align="absmiddle" title="'.$name.'"/>';
			if($showN==1 && $objproduct->Name!='') $tags= $str."<h4>".$name."</h4>".$objproduct->Name;
		}
	}
	if($author!='') 
		echo "<br style=\"clear:both\"><div id=\"showdate_author\">".$author."</div>";
	if($icons!='') 
		echo "<br style=\"clear:both\"><div id=\"showicons\">".$icons."</div>";
	if($tags!='')
		echo "<br style=\"clear:both\"><div id=\"showtags\">".$tags."</div>";
}
unset($obj_config);
unset($rows);
?>