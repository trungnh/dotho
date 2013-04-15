<?php
$id=0; $filename ='';
if(!isset($_GET["id"])) 
	exit;
$id = $_GET["id"];

include_once("includes/gfinnit.php");
include_once("includes/gfconfig.php");
include_once(LIB_PATH."gfclass/cls.data.php");
include_once(LIB_PATH."gfclass/cls.document.php");

if(!isset($objdoc)) 
	$objdoc= new CLS_DOCUMENT();
$filename = $objdoc->fileName($id,"/home/vnresearch/domains/vnresearch.org/public_html/agroQuynh/"); //echo $filename;//die;

if ($fd = fopen ($filename, "r")) {
    $fsize = filesize($filename);
    $path_parts = pathinfo($filename);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);

?>