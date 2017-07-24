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
	$wynik = strtolower(str_replace(array(' ',':','–',',','Ę','Ó','Ą','Ś','Ł','Ż','Ź','Ć','Ń','ę','ó','ą','ś','ł','ż','ź','ć','ń'), array('-','','','','E','O','A','S','L','Z','Z','C','N','e','o','a','s','l','z','z','c','n'), $arg));
	return $wynik;
}

if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user_cms1= $dane;}
	if(isset($user_cms1)){
		if($_POST['action']=='dodaj'){
			mysql_query('insert into kategorie values(null, "'.$_POST['kategoria'].'", "'.prosta_nazwa($_POST['kategoria']).'")');
		}elseif($_POST['action']=='edytuj'){
			mysql_query('update kategorie set nazwa="'.$_POST['kategoria'].'", prosta_nazwa="'.prosta_nazwa($_POST['kategoria']).'" where id="'.$_POST['id'].'"');
		}elseif($_POST['action']=='usun'){
			$q = mysql_query('select id, kategorie from gry where kategorie like "%-'.$_POST['id'].'-%"');
			while($dane = mysql_fetch_array($q)){
				$wynik[]= $dane;
				mysql_query('update gry set kategorie="'.str_replace("-".$_POST['id']."-","",$dane['kategorie']).'" where id="'.$dane['id'].'"');
			}
			mysql_query('delete from kategorie where id="'.$_POST['id'].'"');
		}
	}
}
?>