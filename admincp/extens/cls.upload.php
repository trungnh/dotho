<?php
class CLS_UPLOAD{
        var $_baseImages = "../../images/";
	var $file_name=NULL;
	var $file_type=NULL;
	var $file_size=NULL;
	var $file_error=NULL;
	var $array_type=array('video/x-flv','application/kapsulefile','image/jpg','image/jpeg','image/gif','image/png','image/x-png','application/x-shockwave-flash','audio/x-ms-wma','audio/mpeg3','audio/mpeg','video/avi','application/octet-stream','video/x-ms-wmv','');
	var $max_size=100000000; // 8 MB
	var $_path="";
	
	function CLS_MEDIA(){
	}
	function setType($array)
	{
		$this->$array_type=$array;
	}
	function setMaxSize($maxsize)
	{
		$this->$max_size=$maxsize;
	}
	function setPath($path)
	{
		$this->_path=$path;
	}
	function checkType(){
		if(in_array($this->file_type,$this->array_type))
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không tồn tại hoặc không phải định dạng cho phép !. Lỗi tại Image->checkType() for '.$this->file_type.'")');
	}
	function checkSize(){
		if($this->file_size < $this->max_size)
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không quá lớn so với kích thước cho phép!. Lỗi tại Image->checkSize()");');
	}
	function checkError(){
		if($this->file_error==0)
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">Có lỗi trong quá trình truyền file!. Lỗi tại Image->checkError()'.$this->file_error.'");');
	}
	function checkExistFile(){
		if(file_exists($this->_path.$this->file_name))
			return true;
		else
			return false;
	}
	function NewFile(){
		$this->file_name=date("dnYhis").$this->file_name;
	}
	function SaveFile(){
		move_uploaded_file($this->file_temp,$this->_path.$this->file_name);
	}
	function UploadFile($filename,$patch){
		$this->file_name=$_FILES[$filename]["name"];
		$this->file_type=$_FILES[$filename]["type"];
		$this->file_size=$_FILES[$filename]["size"];
		$this->file_error=$_FILES[$filename]["error"];
		$this->file_temp=$_FILES[$filename]["tmp_name"];
		$this->checkError();
		$this->checkType();
		$this->checkSize();
		$this->checkExistFile();
		$this->SaveFile();
        $MyImg = new Image;
        $MyImg->SrcFile = $this->_path.$this->file_name; //?nh g?c
        $MyImg->DestFile = $this->_path.$this->file_name;
        $MyImg->HeightPercent = 600;
    	$MyImg->WidthPercent = 600;
    	/*$MyImg->NewWidth = 500;
        $MyImg->NewHeight = 200;*/
        $param=getimagesize($MyImg->SrcFile);
        $sizeW=$param[0];
        $sizeH=$param[1];
        if($sizeW/$sizeH<1.333)
            $MyImg->SaveFileH();
        else
            $MyImg->SaveFileW();
        $MyImg->HeightPercent = 135;
    	$MyImg->WidthPercent = 135;
        $_thisPathArr = explode("/", $this->_path);
        $_thisPath = "";
        if($_thisPathArr[count($_thisPathArr)-2]!="images") $_thisPath = $_thisPathArr[count($_thisPathArr)-2];
        if(!file_exists($this->_baseImages."thumb/".$_thisPath)){
            mkdir($this->_baseImages."thumb/".$_thisPath, 0777);
        }
        $MyImg->DestFile = $this->_baseImages."thumb/".$_thisPath."/".$this->file_name; 
        if($sizeW/$sizeH<1.333)
            $MyImg->SaveFileH();
        else
            $MyImg->SaveFileW();
       $file=$this->_path.$this->file_name;
       unset($MyImg);
		return $file;
	}
    function uploadMedia($filename,$path) {
        $this->file_name=$this->rename($_FILES[$filename]["name"]);
		$this->file_type=$_FILES[$filename]["type"];
		$this->file_size=$_FILES[$filename]["size"];
		$this->file_error=$_FILES[$filename]["error"];
		$this->file_temp=$_FILES[$filename]["tmp_name"];
        $this->checkError();
        $this->checkType();
		$this->SaveFile();
        return $this->file_name;
    }
    function rename($cs)
    {
        /*Mảng chứa tất cả ký tự có dấu trong Tiếng Việt*/
        $marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
        "ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề",
        "ế","ệ","ể","ễ",
        "ì","í","ị","ỉ","ĩ",
        "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ",
        "ờ","ớ","ợ","ở","ỡ",
        "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
        "ỳ","ý","ỵ","ỷ","ỹ",
        "đ",
        "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
        "Ằ","Ắ","Ặ","Ẳ","Ẵ",
        "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
        "Ì","Í","Ị","Ỉ","Ĩ",
        "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
        "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
        "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
        "Đ"," ","%","?","~","@");
        
        /*Mảng chứa tất cả ký tự không dấu tương ứng với mảng $marTViet bên trên*/
        $marKoDau=array("a","a","a","a","a","a","a","a","a","a","a",
        "a","a","a","a","a","a",
        "e","e","e","e","e","e","e","e","e","e","e",
        "i","i","i","i","i",
        "o","o","o","o","o","o","o","o","o","o","o","o",
        "o","o","o","o","o",
        "u","u","u","u","u","u","u","u","u","u","u",
        "y","y","y","y","y",
        "d",
        "A","A","A","A","A","A","A","A","A","A","A","A",
        "A","A","A","A","A",
        "E","E","E","E","E","E","E","E","E","E","E",
        "I","I","I","I","I",
        "O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
        "U","U","U","U","U","U","U","U","U","U","U",
        "Y","Y","Y","Y","Y",
        "D","-","","","","");
        
        /*Hàm thay thế các kí tự Tiếng Việt trong mảng $marTViet bằng các ký tự không dấu trong mảng $marKoDau*/
        return str_replace($marTViet,$marKoDau,$cs);
    }
}
?>