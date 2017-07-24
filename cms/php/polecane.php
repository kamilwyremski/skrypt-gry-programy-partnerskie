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

function prosta_nazwa($arg){
	$wynik = strtolower(str_replace(array(' ',':','–',',','Ê','Ó','¥','Œ','£','¯','','Æ','Ñ','ê','ó','¹','œ','³','¿','Ÿ','æ','ñ'), array('-','','','','E','O','A','S','L','Z','Z','C','N','e','o','a','s','l','z','z','c','n'), $arg));
	return $wynik;
}

if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user_cms1= $dane;}
	if(isset($user_cms1)){
		if($_POST['action']=='dodaj'){
			$url = $_POST['url'];
			if(substr($url, 0, 7) != "http://") {
				$url = 'http://'.$url;
			}
			mysql_query('insert into polecane_strony values(null, "'.$_POST['nazwa'].'", "'.$url.'")');
		}elseif($_POST['action']=='edytuj'){
			$url = $_POST['url'];
			if(substr($url, 0, 7) != "http://") {
				$url = 'http://'.$url;
			}
			mysql_query('update polecane_strony set nazwa="'.$_POST['nazwa'].'", url="'.$url.'" where id="'.$_POST['id'].'"');
		}elseif($_POST['action']=='usun'){
			mysql_query('delete from polecane_strony where id="'.$_POST['id'].'"');
		}
	}
}
?>