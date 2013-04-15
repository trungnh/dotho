<?php
include_once("includes/gfinnit.php");
include_once("libs/gfclass/cls.data.php");
include_once("libs/gfclass/cls.users.php");
if(!isset($objuser)) $objuser = new CLS_USERS();
if(isset($_POST["user_name"]) && $_POST["user_name"]!='')
{
	 $user_name=trim($_POST['user_name']);
    if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $user_name))
    {
         if($objuser->checkUserExists($user_name)==true)
    		 echo "no";
    	 else
    		 echo "yes";
       } 
     else
     {
            echo "notype";	
     }
}
else 
	echo 'nodata';
?>