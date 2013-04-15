<style type="text/css">
ul#main{
	margin: 0px;
	padding: 0px;
	background-color: #EEE;	
}
ul#main li{
	display: block;
	list-style: none;
}
ul#main li a{
	height: 27px;
	display: block;
	line-height: 27px;
	padding-left: 11px;
	border-bottom:  #CCC 1px dashed;
}
ul#main li a:hover{
	background-color: #CCC;
}
ul#main ul.level1,ul#main ul.level2{
	margin: 0px;
	padding: 0px;
	position: absolute;
	z-index: 999px;
	margin-left: 200px;
	margin-top: -27px;
	width: 200px;
	background-color: #EEE;
	border: #036 1px solid;
	display: none;
}
.activeMN{
	color:#0000FF;
	padding-left:11px;
	cursor:pointer;
	border-bottom:  #CCC 1px dashed;
	height: 27px;
	display: block;
	line-height: 27px;	
}
</style>

<?php 
if(!isset($objuser)) $objuser = new CLS_USERS();
$check_isadmin = $objuser->isAdmin();
?>
<script language="javascript" type="text/javascript" >
$(document).ready(function(){	 
    $('.activeMN').next().hide();
	$('#ControlMainControl').click(function(){
		$("#MainControl").slideToggle();
	});
	
	$('#controlDraw').click(function(){
		$("#draw").slideToggle();
	});
	
	$('#ControlMember').click(function(){
		$("#member").slideToggle();
	});
	
	$('#beforeStatistic').click(function(){
		$("#afterStatistic").slideToggle();
	});
	
	$("#menu").hide();
	$('#ControlMenu').click(function(){
		$("#menu").slideToggle();
	});
	
	$('#ControlProduct').click(function(){
		$("#product").slideToggle();
	});
	
	$('#ControlTiviShow').click(function(){
		$("#tiviShow").slideToggle();
	});
	
	
	$('#ControlContent').click(function(){
		$("#Content").slideToggle();
	});
	
	$('#ControlLession').click(function(){
		$("#Lession").slideToggle();
	});
	
	
	$('#ControlExtention').click(function(){
		$("#Extention").slideToggle();
	});
	
	$('#controlStory').click(function(){
		$("#Story").slideToggle();
	});
       
        $('#ControlStatistic').click(function(){
		$("#statistic").slideToggle();
	});
        $('#MainControl').show();
	
});
</script>
<ul id="main">
    <li>
		<span id="ControlMainControl" class="activeMN" ><?php echo $obj_mnulang->SYSTEM;?></span>
        <ul class="submenu"  id="MainControl">
            <li><a href="index.php">Bảng điều khiển</a></li>
            <?php if($check_isadmin==true){ ?>
            <li><a href="index.php?com=gusers"><span>Phân quyền người dùng</span></a></li>
			
			<li><a href="index.php?com=users&task=listcus"><span>Quản lý Khách hàng</span></a></li>
            <li><a href="index.php?com=users"><span>Quản lý admin</span></a></li>
            <li class="space"><a href="index.php?com=config"><span><?php echo $obj_mnulang->SITE_CONFIG;?></span></a></li>
            <?php }
			else {?>
            <li><a href="index.php?com=users&task=edit&memid=<?php echo $_SESSION["IGFUSERID"];?>"><span>Thông tin người dùng</span></a></li>
            <?php } ?>
				
        </ul>
    </li>

	<li>
		<span id="beforeStatistic" class="activeMN">Thống kê</span></a>
		<ul id="afterStatistic">	
			<li><a href="index.php?com=statistic&mode=order"><span>Thống kê hóa đơn</span></a></li>
			<li><a href="index.php?com=statistic&mode=product"><span>Thống kê sản phẩm</span></a></li>
		</ul>
	</li>
    <li>
        <span id="ControlMenu" class="activeMN"><?php echo $obj_mnulang->MENUS;?></span>
        <ul class="submenu" id="menu">
            <li class="space"><a href="index.php?com=menus"><span><?php echo $obj_mnulang->MENUS_MANAGER;?></span></a></li>
            <?php 
            $mnuobj=new CLS_MENU();
            $str=$mnuobj->getListmenu("list");
            echo $str;
            ?>
        </ul>
    </li>

	<li>
		<span id="ControlProduct" class="activeMN"><?php echo MCATALOG;?></span>
		<ul class="submenu" id="product">
			<li><a href="index.php?com=order"><span>Quản lý hóa đơn</span></a></li>
			<li class="space"><a href="index.php?com=catalogs"><span><?php echo MCATALOG;?></span></a></li>
			<li><a href="index.php?com=products"><span><?php echo MPRO;?></span></a></li>
		</ul>
	</li>
	
    <li>
        <span id="ControlContent" class="activeMN"><?php echo MCONTENT;?></span>
        <ul id="Content">
            <li class="space"><a href="index.php?com=category"><span><?php echo MCATEGORY;?></span></a></li>
            <li><a href="index.php?com=contents"><span><?php echo MARTICLE;?></span></a></li>
			
        </ul>
    </li>
	<li>
		<span id="ControlStatistic" class="activeMN">Sự kiện</span>
		<ul id="statistic">	
			<li><a href="index.php?com=event"><span>Quản lí sự kiện</span></a></li>
			<li><a href="index.php?com=event_detail"><span>Chi tiết sự kiện</span></a></li>
			<li><a href="index.php?com=statistic&mode=product"><span>Thống kê sản phẩm</span></a></li>
		</ul>
	</li>
    <?php if($check_isadmin==true){ ?>
    <li>
        <span id="ControlExtention" class="activeMN"><?php echo MEXTENSION;?></span>
        <ul class="submenu" id="Extention">
            <li><a href="index.php?com=components"><span><?php echo MCOMPONENT;?></span></a></li>
            <li><a href="index.php?com=module"><span><?php echo MMODULES;?></span></a></li>
            <li><a href="index.php?com=template"><span><?php echo MTEMPLATE;?></span></a></li>
            <li><a href="index.php?com=language"><span><?php echo MLANGUAGE;?></span></a></li>
        </ul>
    </li>
    <?php } ?>
</ul>