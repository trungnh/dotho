<?php
                $objlang=new CLS_LANGUAGE;
                $langid=0;
                $langid=$objlang->curent_lang("back_end");
                //echo "Lang ID:".$langid;
                ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trung tâm đào tạo tin học GlowFuture</title>

<link href="<?php echo THIS_TEM_ADMIN_PATH; ?>css/gfstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo THIS_TEM_ADMIN_PATH; ?>css/jquery-ui.css" type="text/css" media="all" /> 
<link href="<?php echo THIS_TEM_ADMIN_PATH; ?>css/ui.theme.css" rel="stylesheet" type="text/css"/>


<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/jquery.min.js"></script>
<script src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/jquery-ui.min.js"></script>
<script language="javascript" src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/calendar_vi.js"></script>
<script language="javascript" src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/function.js"></script>
<script language="javascript" src="<?php echo THIS_TEM_ADMIN_PATH; ?>js/check_form.js"></script>

<script language="javascript" src="../<?php echo JSC_PATH; ?>gfscript.js"></script>
<script language="javascript" src="../<?php echo JSC_PATH; ?>jquery.validate.js"></script>
<script language="javascript" src="../<?php echo EDIT_FULL_PATH; ?>"></script>
<script language="javascript">
    $(document).ready(function(){
    	$("#navitor ul li").each(function(){
    		var popup= $(this).find(".submenu");
    		if (popup)
    		{ 
    			$(this).hover(function(){ 
                    popup.show(); 
    			},function(){
    				popup.hide();
    			});
    		}else{
				alert("not exit");
			}
    	});
    });
</script>
</head>
<body>
<a name="top" title="site top"></a>
<div id="wapper">
	<?php require_once(LAG_PATH."vi/general.php");?>
    <?php require_once(LAG_PATH."vi/lang_menu.php");?>
	<?php require_once(MOD_PATH."mod_mainmenu/layout.php");?>
	<div id="header">
    </div>
    <div id="body">
   		<?php
		global $UserLogin;
    	if($UserLogin->isLogin()!=true)
			include(COM_PATH."com_users/tem/login.php");
		else{
			if(!isset($objmem)) $objmem = new CLS_USERS(); 
        ?>  
    	<div id="panel_right">
		<div id="checkLogin">
<?php                    	include("././components/com_check_ip/checkLogin.php"); ?>
                    </div>
        	<div class="content" style="margin: 10px; border:#89b8fa 1px solid;min-height: 500px;">
            	<?php echo "<h2 align=\"center\">Chào: ".$_SESSION["IGFUSERLOGIN"]."</h2>";?>
                <ul>
                	<li><a href="index.php?com=users&task=edit&memid=<?php echo $_SESSION["IGFUSERID"];?>">Thông tin người dùng</a></li>
                    <li><a href="index.php?com=users&task=changepass&memid=<?php echo $_SESSION["IGFUSERID"];?>">Đổi mật khẩu</a></li>
                    <li><a href="index.php?com=users&task=logout"><span><?php echo $obj_mnulang->LOGOUT;?></span></a></li>  
                </ul>
				
                <hr width="90%">
           		<?php require_once(MOD_PATH."mod_leftmenu/layout.php");?>
           	</div>
        </div>  
    	<div id="panel_main">
        	<div class="content" style="margin: 10px 10px 10px 0px;">
        		<?php //----------------------------------------------?>
                <?php 
					$com="";
					if(isset($_GET["com"]))
					$com=$_GET["com"];
					define("URL",COM_PATH."com_".$com."/layout.php");
					define("HOME",COM_PATH."com_fronpage/layout.php");
					if(is_file(URL))
					include(URL);
					else include(HOME);
				?>
                <?php //----------------------------------------------?>
            </div>   
        </div>
        <?php } ?>
        <div style="clear:both; display:block;">&nbsp;</div> 
    </div>
    <div id="footer"><?php //load_mod("footer");?><?php require_once(MOD_PATH."mod_footer/layout.php");?></div>
</div>
</body>
</html>