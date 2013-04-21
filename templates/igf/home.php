<?php
if(!isset($_SESSION["CUR_MENU"]))
	$_SESSION["CUR_MENU"]="";
if(isset($_GET["cur_menu"]))
	$_SESSION["CUR_MENU"]=$_GET["cur_menu"];
	
$title=WEBTITLE;
if(!isset($objcata))		$objca= new CLS_CATALOG();
if(!isset($objpro))			$objpro= new CLS_PRODUCTS();
if(!isset($objcon)) 		$objcon= new CLS_CONTENTS(); 
if(!isset($objcategory))	$objcategory= new CLS_CATE(); 
if(!isset($objevent))		$objevent=new CLS_EVENT(); 
if(isset($_GET["com"])){
	if($_GET["com"]=="catalogs"){
	  if(isset($_GET["ItemID"])){
		  $id=(int)$_GET["ItemID"];
		  $objca->getCatalogByID($id);
		  $title=$objca->Name;
	  }
	}
	if($_GET["com"]=="products"){
	  if(isset($_GET["ItemID"])){
		  $id=(int)$_GET["ItemID"];
		  $objpro->getProByID($id,0);
		  $title=$objpro->Name;
	  }
	}
	if($_GET["com"]=="contents"){
	  if(isset($_GET["viewtype"])){
		 if($_GET["viewtype"]=="article"){
			$id=(int)$_GET["item"];
			$objcon->getConByID($id,0);
			$title=$objcon->Title;
		 }
		 else if($_GET["viewtype"]=="block"){
			$id=(int)$_GET["catid"];
			$objcategory->getCateByID($id);
			$title=$objcategory->Name;
		 }
		 else
		 $title=WEBTITLE;
	  }
	}
	if($_GET["com"]=="event"){
	  if(isset($_GET["itemID"])){
		  $id=(int)$_GET["itemID"];
		  $objevent->getProByID($id);
		  $title=$objevent->Name;
	  }
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta content="<?php echo WEBKEYWORDS;?>" name="keywords">
		<meta content="<?php echo WEBDESC;?>" name="description">
		<meta content="IGF.COM.VN" name="copyright">
		<meta content="nxtuyen.pro@gmail.com" name="author">
		<title><?php echo $title; ?></title>
		<?php unset($objca);unset($objpro);unset($objcon);unset($objcategory);unset($objevent);?>
		<link type="image/x-icon" href="<?php echo WEBSITE; ?>favicon.ico" rel="shortcut icon">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/tooltip.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH;?>css/slide.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/jquery.lightbox-0.5.css">
		<link rel="stylesheet" type="text/css" href="<?php echo WEBSITE.THIS_TEM_PATH; ?>css/nivo-slider.css">
		<!--[if IE 6]>
			<script src="<?php echo WEBSITE.THIS_TEM_PATH;?>js/DD_belatedPNG.js"></script>
			<script>
			  DD_belatedPNG.fix('img, div, a, span');
			</script>
		<![endif]-->
		<script type="text/javascript" src="<?php echo WEBSITE; ?>js/gfscript.js"></script>
		<script language="javascript" src="<?php echo WEBSITE; ?>js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE; ?>js/code.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE; ?>js/function_js.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE; ?>js/jquery_004.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE; ?>js/carousel.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE.THIS_TEM_PATH; ?>js/jquery.lightbox-0.5.js"></script>
		<script type="text/javascript" src="<?php echo WEBSITE;?>js/slideshow.js"></script>
		<script type="text/javascript">/*
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".list_product pre," : strTooltipProductOb + ".list_product pre,");
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".list_order_item pre," : strTooltipProductOb + ".list_order_item pre,");
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".list_new_product pre," : strTooltipProductOb + ".list_new_product pre,");
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".list-item pre," : strTooltipProductOb + ".list-item pre,");
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".carousel-wrap pre," : strTooltipProductOb + ".carousel-wrap .item pre,");
		strTooltipProductOb= (typeof(strTooltipProductOb) == "undefined" ? ".carousel-wrap pre," : strTooltipProductOb + ".carousel-wrap .item pre,");
		jQuery(window).load(function(){ tooltipProduct();tooltipVendor();});

		var isIE		= (navigator.userAgent.toLowerCase().indexOf("msie") == -1 ? false : true);
		var isIE6	= (navigator.userAgent.toLowerCase().indexOf("msie 6") == -1 ? false : true);
		var isIE7	= (navigator.userAgent.toLowerCase().indexOf("msie 7") == -1 ? false : true);
		var isChrome= (navigator.userAgent.toLowerCase().indexOf("chrome") == -1 ? false : true);
		*/
		</script>
		<!--<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>-->
		<script type="text/javascript">
		  /*var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-32342542-1']);
		  _gaq.push(['_trackPageview']);
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();*/
		</script>
	</head>
<?php 
if(!isset($objmod)) $objmod = new CLS_MODULE();
?>  
<body>
    <div style="background: #FFF7CB;" id="an" class='registry-email user'>
        <?php $this->loadModule("banenr");?> 
    </div> 
	<div style="height:20px;"  id="hien" class="close">
		<span class="buttton_block close">Hiện [x]</span>
    </div>
	<div class="container">
		<div id="header" class="clearfix">
			<div class="header-left">
				<?php echo stripslashes(LOGO); ?>
			</div>
			<div class="header_right clearfix user">   
                <?php $this->loadModule("header");?>            
			</div>
        </div>
		<div class="top-container"> 
			<?php //$this->loadModule("search");
                include_once("modules/mod_search/brow/brow1.php");
            ?>                                     
		</div>
		<?php $idhome="container-content";
    		if($this->isFrontpage()) $idhome="container-content";
    		else $idhome="content"
        ?>
		<div id="<?php echo $idhome; ?>" class="home">
			 <?php if($this->isFrontpage()){?>
			<div class="main clearfix">
				<div class="banner-home clearfix user">
					<?php $this->loadModule("top");?>
					<div id="slider" class="nivoSlider user">
					<?php $this->loadModule("navitor"); ?>
					</div>
				</div>
			</div>
			<div id="right" class='user'>
				<?php 
                include_once("modules/mod_latestpro/brow/otherpro.php");
                include_once("modules/mod_latestpro/brow/hotnew.php");
                include_once("modules/mod_latestpro/brow/lastestnew.php");
                $this->loadModule('right');
                ?>
                <div id="fb-root"></div>
                    <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-like" data-href="<?php echo WEBSITE;?>" data-send="true" data-width="300" data-show-faces="true" data-font="tahoma"></div>
			</div> 
			<div id="main-content" class="main">
					<div class="clearfix content-content1 user">
						<?php 
                            include_once("modules/mod_latestpro/brow/giamgia.php");
                            $this->loadModule("user1"); 
                        ?>
						<div class="module mod-comment">
							<h2>Cảm nhận khách hàng!</h2>
							<div class="content">
								<?php if(!isset($objcom))
									$objcom= new CLS_COMM();
									$objcom->getList(" order by `comm_id` desc limit 0,1 ");
									$rows=$objcom->Fecth_Array();
									echo '<p><span>'.$rows["username"].':</span><a href="#" class="hiencom">'.Substring(($rows["content"]),0,20).'</span></p>'; unset($objcom);
								?>
							</div>
							<a class="writecontact" href="#">Viết góp ý</a>
						</div>
					</div> 
					<?php 
					include_once("modules/layout_.php");
					//$this->loadModule("left");
                    include_once("modules/mod_catalog/brow/brow3.php"); ?>
			</div>
			<?php } else { ?>
				<?php $this->loadComonent();?>
			<?php } ?>
			<div id="content-bot" class="clearfix">
				<?php 
				include_once("modules/layout.php"); ?>
			</div>
			<div id="content-bottom" class="clearfix user">
				<?php $this->loadModule("bottom");?>
			</div>
			<div id="footer-wapper">
				<div class="content">
					<?php echo FOOTER; ?>
				</div>
			</div>
		</div>
	</div>
<div class='user'>
<?php 
    //$this->loadModule("user5");$this->loadModule("user4");
?>
</div>
</body>
</html>