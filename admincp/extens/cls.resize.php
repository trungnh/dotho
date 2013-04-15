<?php
/*
Email: [email]sincos10@gmail.com[/email]
Ho�n th�nh ng�y: 5-4-2007
T�n l?p: Image
C�ng d?ng: Resize ?nh
    + JPG
    + GIF kh�ng �?ng ( ?nh gif 1 frame )
    + PNG 
C� 3 c�ch Resize 1 b?c ?nh:
C�ch 1: Resize ?nh v?i Width v� Height do ta ch? �?nh kh�ng c?n bi?t Width v� Height c?a ?nh g?c l� bao nhi�u - n?u t? l? ko t?t => ?nh m�o m�
    V� d?:
    $MyImg = new Image;
    $MyImg->SrcFile = "./images/pic.gif"; //?nh g?c
    $MyImg->DestFile = "new.gif"; //?nh sao ch�p sau khi resize
    $MyImg->NewWidth = 200;
    $MyImg->Newheight = 150;
    $MyImg->SaveFileWH();
C�ch 2: resize ?nh v?i Width dc ch? �?nh Height s? l?y d�ng t? l? ?nh g?c => ?nh m?i s? c� t? l? ��ng so v?i ?nh g?c
    V� d?:
    $MyImg = new Image;
    $MyImg->SrcFile = "./images/pic.gif"; //?nh g?c
    $MyImg->DestFile = "new.gif"; //?nh sao ch�p sau khi resize
    $MyImg->WidthPercent = 200;
    $MyImg->SaveFileW();
C�ch 3: resize ?nh v?i Height dc ch? �?nh Width s? l?y d�ng t? l? ?nh g?c => ?nh m?i s? c� t? l? ��ng so v?i ?nh g?c
    V� d?:
    $MyImg = new Image;
    $MyImg->SrcFile = "./images/pic.gif"; //?nh g?c
    $MyImg->DestFile = "new.gif"; //?nh sao ch�p sau khi resize
    $MyImg->HeightPercent = 200;
    $MyImg->SaveFileH();
*/
class Image
{
    var $SrcFile = false;//File ngu?n
    var $DestFile = false;//File ��ch n?u ��?c l�u
    var $Quality = 100; //Ch?t l�?ng ?nh s? ��?c t?o
    var $NewWidth = 0; //�? r?ng c?a ?nh s? ��?c t?o
    var $NewHeight = 0;//�? cao c?a ?nh s? ��?c t?o
    var $WidthPercent = 0;//chi?u r?ng c?a ?nh c?n t?o d�ng khi mu?n resize ?nh nh�ng gi? nguy�n t? l? d�i/r?ng
    var $HeightPercent = 0;//chi?u cao c?a ?nh c?n t?o d�ng khi mu?n resize ?nh nh�ng gi? nguy�n t? l? d�i/r?ng
	function GetType()//H�m l?y ki?u c?a file ngu?n - ch? h? tr? jpg(1), gif(2), png(3)
    {
        $arr['mime'] = false;
        $arr = getimagesize($this->SrcFile);
		//echo $arr['mime'];
        $type = 0;
        switch($arr['mime'])
        {
            case 'image/pjpeg':
				$type = 1;
                break;
			case 'image/jpeg':
                $type = 1;
                break;
            case 'image/gif':
                $type = 2;
                break;
			case 'image/x-png':
				$type = 3;
                break;
            case 'image/png':
                $type = 3;
                break;
            default:
                $type = 0;
                break;
        }
        if($type > 0)
            return $type;
        else
            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File ngu?n kh�ng t?n t?i ho?c kh�ng ph?i �?nh d?ng cho ph�p !. L?i t?i Image->GetType()");
    }
	function GetWidth() //H�m l?y chi?u r?ng c?a ?nh g?c
    {
        $arr[0] = 0;
        $arr = getimagesize($this->SrcFile);
        if(intval($arr[0]) > 0)
            return intval($arr[0]);
        else
            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File ngu?n kh�ng t?n t?i ho?c kh�ng ph?i �?nh d?ng cho ph�p !. L?i t?i Image->GetWidth()");
    }
	function GetHeight() //H�m l?y chi?u cao c?a ?nh g?c
    {
        $arr[1] = 0;
        $arr = getimagesize($this->SrcFile);
        if(intval($arr[1]) > 0)
            return intval($arr[1]);
        else
            die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File ngu?n kh�ng t?n t?i ho?c kh�ng ph?i �?nh d?ng cho ph�p !. L?i t?i Image->GetHeight()");
    }
	function LoadImageFromFile()//Ham t?o m?t ?nh v�o trong b? nh? t? file ngu?n - tr? v? �?a ch? v�ng nh? ch?a anh dc t?o
    {
        $type = $this->GetType();
        $img = false;
        switch($type)
        {
            case 1:
                $img = imagecreatefromjpeg($this->SrcFile);
                break;
            case 2:
                $img = imagecreatefromgif($this->SrcFile);
                break;
            case 3:
                $img = imagecreatefrompng($this->SrcFile);
                break;
        }
        return $img;
    }
	function NewImage($W, $H) //H�m t?o 1 ?nh m?i trong b? nh? - tr? v? �?a ch? c?a n� trong b? nh?
    {
        if($this->GetType() != 2)
		    $imgNew = imagecreatetruecolor($W,$H);//Dung cho gif - chua ho tro gif nen gif se khong transfer
        else
            $imgNew = imagecreate($W, $H);
        $white = imagecolorallocate($imgNew, 255, 255, 255);//Dung cho PNG
        imagefilledrectangle( $imgNew, 0, 0, $W, $H, $white);//Dung cho PNG
        return $imgNew;
    }
	function CopyImage($Src, $Dest, $Width, $Height) //H�m copy v� resize t? ?nh c� �?a ch? trong b? nh? $Src t?i ?nh c� �?a ch? $Dest
    {
        //imagecopyresized($Dest, $Src,0,0,0,0, $Width, $Height, $this->GetWidth(), $this->GetHeight());
		$cur_w=$this->GetWidth(); $dx=$cur_w/$Width;
		$cur_h=$this->GetHeight(); $dy=$cur_h/$Height;
		$newx=$Width/2;
		$newh=$Height/2;
		if($dx>$dy)
		{
			$Height=$cur_h/$dx;
		}else{
			$Width=$cur_w/$dy;
		}
		$newx-=$Width/2; $newx=ceil($newx);
		$newh-=$Height/2; $newh=ceil($newh);
		imagecopyresized($Dest, $Src,$newx,$newh,0,0, $Width, $Height, $this->GetWidth(), $this->GetHeight());
    }
	function SaveFile($Src, $Dest)//H�m ghi th�nh file n?u c?n
    {
        $type = $this->GetType();
        switch($type)
        {
            case 1:
                imagejpeg($Dest, $this->DestFile, $this->Quality);
                break;
            case 2:
                if(function_exists('imagegif')) //PHP < 5 no support
                    imagegif($Dest, $this->DestFile, $this->Quality);
                else
                    imagejpeg($Dest, $this->DestFile, $this->Quality);
                break;
            case 3:
				//header('Content-type: image/png');
				if(function_exists('function.imagepng'))
				{
					$this->Quality=9;
                	imagepng($Dest, $this->DestFile, $this->Quality);
				}
				else
					imagejpeg($Dest, $this->DestFile, $this->Quality);
                break;
        }
    }
	function FreeMemory($Src, $Dest)//H�m gi?i ph�ng b? nh? ch?a h?nh ?nh ngu?n v� ��ch
    {
        imagedestroy($Src);
        imagedestroy($Dest);
    }

//H�m ��?c g?i
	function SaveFileWH()//H�m tr? v? file ?nh ��?c resize v?i Width v� Height do ta ch? �?nh
    {
        $img = false;
        $imgNew = false;
        $img = $this->LoadImageFromFile();
        $imgNew = $this->NewImage($this->NewWidth, $this->NewHeight);
        $this->CopyImage($img, $imgNew, $this->NewWidth, $this->NewHeight);
        $this->SaveFile($img, $imgNew);
        $this->FreeMemory($img, $imgNew);
    }
//H�m ��?c g?i
	function SaveFileW()//Resize voi Width do ta chi dinh va Height lay theo ti le cua Width
    {
        $oldW = $this->GetWidth();
        $oldH = $this->GetHeight();
        $newW = $this->WidthPercent;
        $newH = $newW*($oldH/$oldW);
        $img = false;
        $imgNew = false;
        $img = $this->LoadImageFromFile();
        $imgNew = $this->NewImage($newW, $newH);
        $this->CopyImage($img, $imgNew, $newW, $newH);
        $this->SaveFile($img, $imgNew);
        $this->FreeMemory($img, $imgNew);
    }
//H�m ��?c g?i
	function SaveFileH()//Resize voi Height do ta chi dinh va Width lay theo ti le cua Height
    {
        $oldW = $this->GetWidth();
        $oldH = $this->GetHeight();
        $newH = $this->HeightPercent;
        $newW = $newH*($oldW/$oldH);
        $img = false;
        $imgNew = false;
        $img = $this->LoadImageFromFile();
        $imgNew = $this->NewImage($newW, $newH);
        $this->CopyImage($img, $imgNew, $newW, $newH);
        $this->SaveFile($img, $imgNew);
        $this->FreeMemory($img, $imgNew);
    }
}
//Mot so ham phu tro
function getImageWidth($FileName)
{
    if(!file_exists($FileName)) return false;
    $arr = getimagesize($FileName);
    return $arr[0];
}
function getImageHeight($FileName)
{
    if(!file_exists($FileName)) return false;
    $arr = getimagesize($FileName);
    return $arr[1];
}
?>