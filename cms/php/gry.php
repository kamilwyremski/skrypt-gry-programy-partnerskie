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

function tagi(){
	if(isset($_POST['tagi'])){
		$tagi = implode($_POST['tagi']);
		for($i=0; $i <= count($_POST['tagi']) - 1; $i++){
			mysql_query('update tagi set ilosc = ilosc+1 where id="'.str_replace("-","",$_POST['tagi'][$i]).'"');
		}
	}else{
		$tagi = '';
	}
	if(isset($_POST['dodajtagi']) and $_POST['dodajtagi'] != ''){
		$nowetagi = str_replace(", ",",",$_POST['dodajtagi']);
		$nowetagi = explode(',', $nowetagi);
		for($i=0; $i <= count($nowetagi) - 1; $i++){
			mysql_query('insert into tagi values(null, "'.$nowetagi[$i].'", "'.prosta_nazwa($nowetagi[$i]).'", 1)');
			$q = mysql_query('select id from tagi where nazwa = "'.$nowetagi[$i].'"');
			while($dane = mysql_fetch_array($q)){$nowy_tag= $dane;}
			$tagi .='-'.$nowy_tag['id'].'-';
		}
	}
	return $tagi;
}
function kategorie(){
	$kategorie = implode($_POST['kategorie']);
	if(isset($_POST['nowakategoria']) and $_POST['nowakategoria'] != ''){
		mysql_query('insert into kategorie values(null, "'.$_POST['nowakategoria'].'", "'.prosta_nazwa($_POST['nowakategoria']).'")');
		$q = mysql_query('select id from kategorie where nazwa = "'.$_POST['nowakategoria'].'"');
		while($dane = mysql_fetch_array($q)){$nowa_kategoria= $dane;}
		$kategorie .='-'.$nowa_kategoria['id'].'-';
	}
	return $kategorie;
}		

if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user_cms1= $dane;}
	if(isset($user_cms1)){
		if($_POST['action']=='dodaj'){

			$q = mysql_query('select pozycja from gry order by pozycja DESC limit 1');
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			$pozycja = $wynik['pozycja']+1;
			
			$opis = $_POST['opis'];
			str_replace("&lt;p&gt;&amp;lt;","&lt;p&gt;&lt;",htmlspecialchars($opis));
			
			$krotki_opis = explode('&lt;!--more--&gt;', $opis);
			if(isset($_POST['slider']) and $_POST['slider']==1){
				$slider = 1;
			}else{
				$slider = 0;
			}
			print_r($_POST['opis']);
			mysql_query('insert into gry values(null, "'.$pozycja.'", "'.$_POST['nazwa'].'", "'.prosta_nazwa($_POST['nazwa']).'", "'.kategorie().'", "'.tagi().'", "'.$opis.'", "'.$krotki_opis['0'].'", "'.$_POST['keywords'].'", "'.$_POST['description'].'", "'.$slider.'", "'.date("Y-m-d").'")');
			

		}elseif($_POST['action']=='edytuj'){

			$krotki_opis = explode('&lt;!--more--&gt;', htmlspecialchars($_POST['opis']));
			
			$q = mysql_query('select tagi from gry where id="'.$_POST['id'].'"');
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			$tagi = explode('-', $wynik['tagi']);
			for($i=0; $i <= count($tagi) - 1; $i++){
				if($tagi[$i]>0){
					mysql_query('update tagi set ilosc = ilosc-1 where id="'.$tagi[$i].'"');
				}
			}
			if(isset($_POST['slider']) and $_POST['slider']==1){
				$slider = 1;
			}else{
				$slider = 0;
			}
			
			mysql_query('update gry set nazwa="'.$_POST['nazwa'].'", prosta_nazwa="'.prosta_nazwa($_POST['nazwa']).'", kategorie="'.kategorie().'", tagi="'.tagi().'", opis="'.htmlspecialchars($_POST['opis']).'", krotkiopis="'.$krotki_opis['0'].'", keywords="'.$_POST['keywords'].'", description="'.$_POST['description'].'", slider="'.$slider.'" where id="'.$_POST['id'].'"');
	
		}elseif($_POST['action']=='usun'){
		
			$q = mysql_query('select tagi from gry where id="'.$_POST['id'].'"');
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			$tagi = explode('-', $wynik['tagi']);
			for($i=0; $i <= count($tagi) - 1; $i++){
				if($tagi[$i]>0){
					mysql_query('update tagi set ilosc = ilosc-1 where id="'.$tagi[$i].'"');
				}
			}
			
			mysql_query('delete from gry where id="'.$_POST['id'].'"');
		
		}elseif($_POST['action']=='up'){
		
			$q = mysql_query('select pozycja from gry where id="'.$_POST['id'].'"');
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			$pozycja = $wynik['pozycja'];
			$nowapozycja = $pozycja+1;
			if(isset($_POST['kategoria']) and $_POST['kategoria'] != ''){
				$q = mysql_query('select id, pozycja from gry where pozycja>"'.$pozycja.'" and kategorie like "%-'.$_POST['kategoria'].'-%" order by pozycja limit 1');
			}else{
				$q = mysql_query('select id, pozycja from gry where pozycja>"'.$pozycja.'" order by pozycja limit 1');
			}
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			if(isset($wynik)){
				mysql_query('update gry set pozycja = "'.$pozycja.'" where id="'.$wynik['id'].'" limit 1');
				mysql_query('update gry set pozycja = "'.$wynik['pozycja'].'" where id="'.$_POST['id'].'" limit 1');
			}else{
				mysql_query('update gry set pozycja = "'.$nowapozycja.'" where id="'.$_POST['id'].'" limit 1');
			}
			
		}elseif($_POST['action']=='down'){
		
			$q = mysql_query('select pozycja from gry where id="'.$_POST['id'].'"');
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			$pozycja = $wynik['pozycja'];
			$nowapozycja = $pozycja-1;
			if(isset($_POST['kategoria']) and $_POST['kategoria'] != ''){
				$q = mysql_query('select id, pozycja from gry where pozycja<"'.$pozycja.'" and kategorie like "%-'.$_POST['kategoria'].'-%" order by pozycja desc limit 1');
			}else{
				$q = mysql_query('select id, pozycja from gry where pozycja<"'.$pozycja.'" order by pozycja desc limit 1');
			}
			while($dane = mysql_fetch_array($q)){$wynik= $dane;}
			if(isset($wynik)){
				mysql_query('update gry set pozycja = "'.$pozycja.'" where id="'.$wynik['id'].'" limit 1');
				mysql_query('update gry set pozycja = "'.$wynik['pozycja'].'" where id="'.$_POST['id'].'" limit 1');
			}else{
				mysql_query('update gry set pozycja = "'.$nowapozycja.'" where id="'.$_POST['id'].'" limit 1');
			}
		}
	}
}

?>