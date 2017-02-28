<?php
// Тип содержимого – картинка формата PNG
define( 'SCRIPT_BY_SIRGOFFAN', 1 ); 
include('../core/config.php');
include('../core/functions.php');
$lng=$_GET['locale'];//Язык
if($lng!='ru' AND $lng!='en' AND $lng!='nl' ){$_error='FATAL ERROR 1';}

$a=$_GET['a'];//Тип акции
if($a==1){$typeofshare="m1";}else
if($a==2){$typeofshare="m2";}else
if($a==3){$typeofshare="i1";}else
if($a==4){$typeofshare="i2";}else
if($a==5){$typeofshare="i3";}else{$_error='FATAL ERROR 2';}



$refcode=(int)$_GET['refcode'];//(N сертификата)
if($refcode<1){$_error='FATAL ERROR 3';}
$result=mysql_query("SELECT id, act_".$typeofshare.", reg_unix FROM `ss_users` WHERE refcode='$refcode'");
$rowe=mysql_fetch_array($result);
$userid=$rowe["id"]; //
$reg_unix=$rowe["reg_unix"]; //

if($userid<1){$_error='FATAL ERROR 4';}
	
$isact=(int)$rowe["act_".$typeofshare];

if($isact<1){/*$_error='FATAL ERROR 5';*/}else{
		
$result2=mysql_query("SELECT * FROM `userstat` WHERE userid='$userid' AND comment='$typeofshare' AND opisanie LIKE '<!--buyshare-->%' ORDER BY id DESC LIMIT 1");
$row=mysql_fetch_array($result2);
$data=strtotime($row["data"]); //
$data=date("d.m.Y",$data);
$dataX=$row["data"]; //
$ssid=$row["id"];
//if($ssid<1){$_error='FATAL ERROR 6';}

if(empty($dataX)){
	$reg_unix=strtotime($reg_unix); //
	$data=date("d.m.Y",$reg_unix);
}

}




function imageresizeS($im,$percents) { 
$w=imagesx($im)*$percents/100; 
$h=imagesy($im)*$percents/100; 
$im1=imagecreatetruecolor($w,$h); 
imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im)); 

imagedestroy($im); 
//imagedestroy($im1); 
return $im1;
} 






if(isset($_GET['previewpercent']) AND $_GET['previewpercent']>1 AND $_GET['previewpercent']<100){
$previewpercent=(int)$_GET['previewpercent'];	
if($previewpercent<1){$previewpercent=100;}
}else{
$previewpercent=100;	
}




	if(empty($_error)){
$source_img='shares/'.$lng.'/'.$typeofshare.'.jpg';
$img = imageCreateFromJpeg($source_img);		


// получаем массив, содержащий размеры изображения 
$size = getimagesize ($source_img); 
$CENTER=$size[0]/2;







		if($typeofshare=='m1'){
			$color = imagecolorallocatealpha($img, 0, 0, 0, 0); 

if($isact!=0){	
	$box = imagettftext($img, 22, 0, 148, 172, $color, "./shares.ttf", $refcode);//160 172
	$box = imagettftext($img, 22, 0, 762, 172, $color, "./shares.ttf", $data);		
	$costtxt=printlng("$".($isact*$sh['cost_m'][1]),"$".($isact*$sh['cost_m'][1]),($isact*$sh['cost_m'][1])." $","","","",$lng);
	$box = imagettfbbox(88, 0, "./CollegeHalo.ttf", $costtxt);
	// размер отступа влево, чтобы текст оказался посередине заданной точки
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($img, 88, 0, $left, 330, $color, "./CollegeHalo.ttf", $costtxt);	
}	



	$desctxt=printlng("Shareholder Investment Corporation
Dit certificaat, met de nominale waarde van $".($isact*$sh['cost_m'][1])." is het eigendom van Shareholder
Investment Corporation, inclusief, en wordt betaald door de eigenaar volledig. 
Dit aandeel wordt niet belast en voldoet aan de oprichters-overeenkomst en het corporatie reglement.","Shareholder Investment Corporation
This certificate, with the face value of $".($isact*$sh['cost_m'][1])." is the property of Shareholder Investment
Corporation, inclusive, and is paid for by its owner in full. This share is not taxed and 
conforms to the Foundation Agreement and the Corporation’s By-Laws.","Shareholder Investment Corporation 
Этот сертификат, стоимостью ".($isact*$sh['cost_m'][1])." $ является собственностью Shareholder
Investment Corporation, включительно и полностью оплачен владельцем. 
Данная акция не облагается налогом, соответствует Учредительскому 
Договору и Уставу Корпорации.","","","",$lng);	
	imagettftext($img, 20, 0, 100, 370, $color, "./share_d.ttf", $desctxt);
	
		}else
		if($typeofshare=='m2'){
			///////
			$color = imagecolorallocatealpha($img, 0, 0, 0, 0); 


			
if($isact!=0){	
	$box = imagettftext($img, 22, 0, 149, 172, $color, "./shares.ttf", $refcode);
	$box = imagettftext($img, 22, 0, 760, 172, $color, "./shares.ttf", $data);		
	$costtxt=printlng("$".($isact*$sh['cost_m'][2]),"$".($isact*$sh['cost_m'][2]),($isact*$sh['cost_m'][2])." $","","","",$lng);
	$box = imagettfbbox(91, 0, "./CollegeHalo.ttf", $costtxt);
	// размер отступа влево, чтобы текст оказался посередине заданной точки
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($img, 91, 0, $left, 300, $color, "./CollegeHalo.ttf", $costtxt);	
}		
		


	$desctxt=printlng("Shareholder Investment Corporation
Dit certificaat, met de nominale waarde van $".($isact*$sh['cost_m'][2])." is het eigendom van Shareholder
Investment Corporation, inclusief, en wordt betaald door de eigenaar volledig. 
Dit aandeel wordt niet belast en voldoet aan de oprichters-overeenkomst en het corporatie reglement.","Shareholder Investment Corporation
This certificate, with the face value of $".($isact*$sh['cost_m'][2])." is the property of Shareholder Investment
Corporation, inclusive, and is paid for by its owner in full. This share is not taxed and 
conforms to the Foundation Agreement and the Corporation’s By-Laws.","Shareholder Investment Corporation 
Этот сертификат, стоимостью ".($isact*$sh['cost_m'][2])." $ является собственностью Shareholder
Investment Corporation, включительно и полностью оплачен владельцем. 
Данная акция не облагается налогом, соответствует Учредительскому 
Договору и Уставу Корпорации.","","","",$lng);	
	imagettftext($img, 20, 0, 100, 370, $color, "./share_d.ttf", $desctxt);
	
		}else			
		if($typeofshare=='i1'){
			$color = imagecolorallocatealpha($img, 0, 0, 0, 0); 


			
if($isact!=0){		
	$box = imagettftext($img, 22, 0, 119, 171, $color, "./shares.ttf", $refcode);	
    $box = imagettftext($img, 22, 0, 784, 171, $color, "./shares.ttf", $data);
	$costtxt=printlng("$".($isact*$sh['cost_i'][1]),"$".($isact*$sh['cost_i'][1]),($isact*$sh['cost_i'][1])." $","","","",$lng);
	$box = imagettfbbox(91, 0, "./CollegeHalo.ttf", $costtxt);	
	// размер отступа влево, чтобы текст оказался посередине заданной точки
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($img, 91, 0, $left, 320, $color, "./CollegeHalo.ttf", $costtxt);	
}
		



	$desctxt=printlng("Shareholder Investment Corporation
Dit certificaat, met de nominale waarde van $".($isact*$sh['cost_i'][1])." is het eigendom van Shareholder
Investment Corporation, inclusief, en wordt betaald door de eigenaar volledig. 
Dit aandeel wordt niet belast en voldoet aan de oprichters-overeenkomst en het corporatie reglement.","Shareholder Investment Corporation
This certificate, with the face value of $".($isact*$sh['cost_i'][1])." is the property of Shareholder Investment
Corporation, inclusive, and is paid for by its owner in full. This share is not taxed and 
conforms to the Foundation Agreement and the Corporation’s By-Laws.","Shareholder Investment Corporation 
Этот сертификат, стоимостью ".($isact*$sh['cost_i'][1])." $ является собственностью Shareholder
Investment Corporation, включительно и полностью оплачен владельцем. 
Данная акция не облагается налогом, соответствует Учредительскому 
Договору и Уставу Корпорации.","","","",$lng);	
	imagettftext($img, 20, 0, 100, 370, $color, "./share_d.ttf", $desctxt);
	
			
		}else
		if($typeofshare=='i2'){
			$color = imagecolorallocatealpha($img, 0, 0, 0, 0); 


			
if($isact!=0){	
	$box = imagettftext($img, 22, 0, 179, 212, $color, "./shares.ttf", $refcode);
	$box = imagettftext($img, 22, 0, 763, 212, $color, "./shares.ttf", $data);		
	$costtxt=printlng("$".($isact*$sh['cost_i'][2]),"$".($isact*$sh['cost_i'][2]),($isact*$sh['cost_i'][2])." $","","","",$lng);
	$box = imagettfbbox(80, 0, "./CollegeHalo.ttf", $costtxt);
	// размер отступа влево, чтобы текст оказался посередине заданной точки
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($img, 80, 0, $left, 333, $color, "./CollegeHalo.ttf", $costtxt);	
}			
		
	$desctxt=printlng("Shareholder Investment Corporation
Dit certificaat, met de nominale waarde van $".($isact*$sh['cost_i'][2])." is het eigendom van Shareholder
Investment Corporation, inclusief, en wordt betaald door de eigenaar volledig. 
Dit aandeel wordt niet belast en voldoet aan de oprichters-overeenkomst en het corporatie reglement.","Shareholder Investment Corporation
This certificate, with the face value of $".($isact*$sh['cost_i'][2])." is the property of Shareholder Investment
Corporation, inclusive, and is paid for by its owner in full. This share is not taxed and 
conforms to the Foundation Agreement and the Corporation’s By-Laws.","Shareholder Investment Corporation 
Этот сертификат, стоимостью ".($isact*$sh['cost_i'][2])." $ является собственностью Shareholder
Investment Corporation, включительно и полностью оплачен владельцем. 
Данная акция не облагается налогом, соответствует Учредительскому 
Договору и Уставу Корпорации.","","","",$lng);	
	imagettftext($img, 20, 0, 100, 380, $color, "./share_d.ttf", $desctxt);
				
		}else			
		if($typeofshare=='i3'){
			$color = imagecolorallocatealpha($img, 0, 0, 0, 0); 


			
if($isact!=0){	
	$box = imagettftext($img, 22, 0, 194, 228, $color, "./shares.ttf", $refcode);	
	$box = imagettftext($img, 22, 0, 792, 228, $color, "./shares.ttf", $data);		
	$costtxt=printlng("$".($isact*$sh['cost_i'][3]),"$".($isact*$sh['cost_i'][3]),($isact*$sh['cost_i'][3])." $","","","",$lng);
	$box = imagettfbbox(80, 0, "./CollegeHalo.ttf", $costtxt);
	// размер отступа влево, чтобы текст оказался посередине заданной точки
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($img, 80, 0, $left, 350, $color, "./CollegeHalo.ttf", $costtxt);	
}			
		


	$desctxt=printlng("Shareholder Investment Corporation
Dit certificaat, met de nominale waarde van $".($isact*$sh['cost_i'][3])." is het eigendom van Shareholder
Investment Corporation, inclusief, en wordt betaald door de eigenaar volledig. 
Dit aandeel wordt niet belast en voldoet aan de oprichters-overeenkomst en het corporatie reglement.","Shareholder Investment Corporation
This certificate, with the face value of $".($isact*$sh['cost_i'][3])." is the property of Shareholder Investment
Corporation, inclusive, and is paid for by its owner in full. This share is not taxed and 
conforms to the Foundation Agreement and the Corporation’s By-Laws.","Shareholder Investment Corporation 
Этот сертификат, стоимостью ".($isact*$sh['cost_i'][3])." $ является собственностью Shareholder
Investment Corporation, включительно и полностью оплачен владельцем. 
Данная акция не облагается налогом, соответствует Учредительскому 
Договору и Уставу Корпорации.","","","",$lng);	
	imagettftext($img, 20, 0, 100, 400, $color, "./share_d.ttf", $desctxt);
		
			
		}				
	}else{
	/*if($userid==21)	
	echo $_error;	
	exit();	
	*/
$img = imageCreateFromJpeg('shares_null/'.$lng.'/'.$typeofshare.'.jpg');

	}



if(isset($_GET['previewpercent'])){	
$img = imageresizeS($img,$previewpercent);		
}	
	
	
	
	
	
	
	
	
	
	
header("Content-type: image/png");

// выводим готовую картинку в формате PNG
imagepng($img);
// освобождаем память, выделенную для картинки
imagedestroy($img);
exit();


?> 
