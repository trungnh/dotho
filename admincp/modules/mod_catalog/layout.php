<?php
$obj_mnulang=new LANG_MENU;	

if(!isset($objuser)) $objuser = new CLS_USERS();
$check_isadmin = $objuser->isAdmin();
?>
<div id="navitor">
    <ul>
        <li>
            <a href="index.php" class="active"><span><?php echo $obj_mnulang->SYSTEM;?></span></a>
            <ul class="submenu">
                <li><a href="index.php">Bảng điều khiển</a></li>
                <?php if($check_isadmin==true){ ?>
                <li><a href="index.php?com=gusers"><span>Phân quyền người dùng</span></a></li>
                <li><a href="index.php?com=users"><span>Quản lý người dùng</span></a></li>
                <li class="space"><a href="index.php?com=config"><span><?php echo $obj_mnulang->SITE_CONFIG;?></span></a></li>
                <?php }
                else {?>
                <li><a href="index.php?com=users&task=edit&memid=<?php echo $_SESSION["IGFUSERID"];?>"><span>Thông tin người dùng</span></a></li>
                <?php } ?>
                <li><a href="index.php?com=users&task=logout"><span><?php echo $obj_mnulang->LOGOUT;?></span></a></li>
            </ul>
        </li>
        <li>
            <a href="#"><span><?php echo $obj_mnulang->MENUS;?></span></a>
            <ul class="submenu">
                <li class="space"><a href="index.php?com=menus"><span><?php echo $obj_mnulang->MENUS_MANAGER;?></span></a></li>
                <?php 
                $mnuobj=new CLS_MENU();
                $str=$mnuobj->getListmenu("list");
                echo $str;
                ?>
            </ul>
        </li>
        <li>
            <a href="#"><span><?php echo MCATALOG;?></span></a>
            <ul class="submenu">
                <li class="space"><a href="index.php?com=catalogs"><span><?php echo MCATALOG;?></span></a></li>
                <li><a href="index.php?com=products"><span><?php echo MPRO;?></span></a></li>
            </ul>
        </li>
        <li>
            <a href="#"><span><?php echo MCONTENT;?></span></a>
            <ul class="submenu">
                <li class="space"><a href="index.php?com=category"><span><?php echo MCATEGORY;?></span></a></li>
                <li><a href="index.php?com=contents"><span><?php echo MARTICLE;?></span></a></li>
                <li><a href="index.php?com=con_config"><span><?php echo "Cấu hình nội dung";?></span></a></li>
            </ul>
        </li>
        <?php if($check_isadmin==true){ ?>
        <li>
            <a href="#"><span><?php echo MEXTENSION;?></span></a>
            <ul class="submenu">
                <li><a href="index.php?com=components"><span><?php echo MCOMPONENT;?></span></a></li>
                <li><a href="index.php?com=module"><span><?php echo MMODULES;?></span></a></li>
                <li><a href="index.php?com=template"><span><?php echo MTEMPLATE;?></span></a></li>
                <li><a href="index.php?com=language"><span><?php echo MLANGUAGE;?></span></a></li>
            </ul>
        </li>
        <?php } ?>
        <li>
            <a href="#"><span><?php echo MHELP;?></span></a>
            <ul class="submenu">
                <li><a href="index.php?com=install"><span><?php echo MABOUT;?></span></a></li>
                <li class="space"><a href="index.php?com=module"><span><?php echo MVERSTION;?></span></a></li>
                <li><a href="index.php?com=module"><span><?php echo MHELP;?></span></a></li>
            </ul>
        </li>
    </ul>
</div>