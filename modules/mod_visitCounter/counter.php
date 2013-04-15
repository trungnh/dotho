<?php
/*Giải thích:

Hàm trả về số người đang online nếu bạn để return $online Nếu không để return $online thì khi gọi hàm sẽ lấy được hai giá trị: $maxu ( Số người truy cập nhiều nhất cùng lúc) và $online ( Số người đang online).

Ở trên mình cho $online=$online +26 và $maxu=$maxu+126 tức là lúc nào cũng có tối thiểu 5 người đang online và lúc nhiều nhất là 126 người.Cái này bạn có thể thay đổi tùy ý.
*/


$rip = $_SERVER['REMOTE_ADDR'];
$sd = time();
$online = 1;
$maxu = 1;

$file1 = "counter.txt";
$lines = file($file1);
$line2 = "";

$CF = fopen ($file1, "r");
$arr = fread ($CF, filesize ($file1) );
fclose ($CF);

//echo $arr;

$arr = explode("||",$arr);
$all = (int)$arr[0]; //echo " tong= ".$all;

$arr_IP = $arr[1];
if(strpos($arr_IP,$rip)===false)	{
	$all++;
}

foreach ($lines as $line_num => $line)
{
	if($line_num == 0)
	{
		$maxu = $line;
	}
	else
	{
		//echo $line."<br>"; die;	
		$fp = strpos($line,'****');
		$nam = substr($line,0,$fp);
		$sp = strpos($line,'++++');
		$val = substr($line,$fp+4,$sp-($fp+4));
		$diff = $sd-$val;
		
		if($diff < 300 && $nam != $rip)
		{
			$online = $online+1;
			$line2 = $line2.$line;
			
			//echo $line2;
		}
	}
}

$my = $rip."****".$sd."++++\n";
if($online > $maxu)
	$maxu = $online;

$open1 = fopen($file1, "w");
fwrite($open1,"$all ||\n");
fwrite($open1,"$line2");
fwrite($open1,"$my");
fclose($open1);
//tang online va maxu len cho nhieu
//$online=$online+26;
//$maxu=$maxu+126;

//echo 'So nguoi dang online: '.$online.'<br>';
//echo 'Tong so luot truy cap: '.($all+100000);

?>