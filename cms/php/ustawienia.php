<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 *
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 *
 * *********************************************************************/
 
include('../../controller/config.php');

session_start(); 

function obraz($obraz, $tp){
	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG", "ico", "ICO");
	$temp = explode(".", $obraz["name"]);
	$extension = end($temp);
	if ((($obraz["type"] == "image/gif") || ($obraz["type"] == "image/jpeg") || ($obraz["type"] == "image/jpg") || ($obraz["type"] == "image/pjpeg") || ($obraz["type"] == "image/x-png") || ($obraz["type"] == "image/png"))	&& ($obraz["size"] < 500000)	&& in_array($extension, $allowedExts)){
		if ($obraz["error"] > 0){
			return('error');
		}else{
			global $ustawienia;
			$image_url = $ustawienia[$tp.'_url'];
			print_r($image_url);
			if($image_url !=''){
				fclose('../../'.$image_url);
				unlink('../../'.$image_url);	
			}
			$path = $obraz['name'];
			move_uploaded_file($obraz["tmp_name"], "../../logo/".$obraz['name']);
			return("logo/".$obraz['name']);
		}
	}else{
		return('error');
	}
}
	
if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user_cms1= $dane;}
	if(isset($user_cms1)){
		
		$q = mysql_query('select logo_url, favicon_url from ustawienia limit 1');
		while($dane = mysql_fetch_array($q)){$ustawienia= $dane;}

		if($_FILES['logo_image']){
			$logo_url = obraz($_FILES['logo_image'], 'logo');
			if ($logo_url == 'error'){
				$logo_url = $ustawienia['logo_url'];
			}
		}else{
			$logo_url = $ustawienia['logo_url'];
		}
		if($_FILES['favicon_image']){
			$favicon_url = obraz($_FILES['favicon_image'], 'favicon');
			if ($favicon_url == 'error'){
				$favicon_url = $ustawienia['favicon_url'];
			}
		}else{
			$favicon_url = $ustawienia['favicon_url'];
		}
		
		$footer_url = $_POST['footer_url'];
		if(substr($footer_url, 0, 7) != "http://" and $footer_url !='') {
			$footer_url = 'http://'.$footer_url;
		}
				
		$base_url = $_POST['base_url'];
		if(substr($base_url, 0, 7) != "http://" and $base_url !='') {
			$base_url = 'http://'.$base_url;
		}
		if(substr($base_url, -1)!='/'){
			$base_url = $base_url.'/';
		}
		
		mysql_query('update ustawienia set 
		base_url="'.$base_url.'",
		template="'.$_POST['template'].'", 
		title="'.$_POST['title'].'",
		email="'.$_POST['email'].'",
		keywords="'.$_POST['keywords'].'",
		description="'.$_POST['description'].'",
		logo="'.$_POST['logo'].'",
		logo_text="'.$_POST['logo_text'].'",
		logo_text2="'.$_POST['logo_text2'].'",
		logo_url="'.$logo_url.'",
		favicon="'.$_POST['favicon'].'",
		favicon_url="'.$favicon_url.'",
		ile_wpisow="'.$_POST['ile_wpisow'].'",
		losowe_wpisy="'.$_POST['losowe_wpisy'].'",
		polecane="'.$_POST['polecane'].'",
		polecane_strony="'.$_POST['polecane_strony'].'",
		reklama_big="'.htmlspecialchars($_POST['reklama_big']).'",
		reklama_big2="'.htmlspecialchars($_POST['reklama_big2']).'",
		reklama_1="'.htmlspecialchars($_POST['reklama_1']).'",
		reklama_2="'.htmlspecialchars($_POST['reklama_2']).'",
		reklama_3="'.htmlspecialchars($_POST['reklama_3']).'",
		reklama_4="'.htmlspecialchars($_POST['reklama_4']).'",
		reklama_5="'.htmlspecialchars($_POST['reklama_5']).'",
		reklama_ukryta="'.htmlspecialchars($_POST['reklama_ukryta']).'",
		ile_nowych="'.$_POST['ile_nowych'].'",
		komentarze="'.$_POST['komentarze'].'",
		komentarze_potwierdzanie="'.$_POST['komentarze_potwierdzanie'].'",
		komentarze_nowe="'.$_POST['komentarze_nowe'].'",
		ile_komentarzy="'.$_POST['ile_komentarzy'].'",
		footer_url="'.$footer_url.'",
		footer_nazwa="'.$_POST['footer_nazwa'].'",
		slider="'.$_POST['slider'].'",
		kontakt="'.$_POST['kontakt'].'",
		statystyki="'.$_POST['statystyki'].'",
		wyszukiwarka="'.$_POST['wyszukiwarka'].'"
		limit 1');
		
		array_map('unlink', glob("../../tmp/*"));
		
	}
}
?>