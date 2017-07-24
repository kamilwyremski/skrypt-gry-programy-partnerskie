<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 * 
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 * 
 * *********************************************************************/
  
session_start(); 

error_reporting(E_ALL);
error_reporting(0);

require_once('../lib/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = 'views';
$smarty->compile_dir = 'tmp';
$smarty->cache_dir = 'cache';

include('../controller/config.php');

if (isset($_GET['wyloguj'])){
	unset($_SESSION['user_cms']);
	unset($_SESSION['user_cms_p']);
}else if(isset($_GET['loguj'])){
	$usern = mysql_query('select * from cms where login="'.$_POST['login'].'" and password=md5("'.$_POST['password'].'")');
	while($dane = mysql_fetch_array($usern)){$user= $dane;}
	if(isset($user)){
		$_SESSION['user_cms'] = $_POST['login'];
		$_SESSION['user_cms_p'] = md5($_POST['password']);
		$smarty->assign("user", $user);		
	}else{
		unset($_SESSION['user_cms']);
		unset($_SESSION['user_cms_p']);
		$smarty->assign("komunikat_logowania", 'Niepoprawny login lub haslo');
	}
}

$strona = 'log';

if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user= $dane;}
	if(isset($user)){
		$smarty->assign("user", $user);
		if (isset($_GET['ustawienia'])){
		
			$path = '../templates';
			$results = scandir($path);
			$templates = array();
			foreach ($results as $result) {
				if ($result === '.' or $result === '..') continue;
				if (is_dir($path . '/' . $result)) {
				   $templates[] .= $result;
				}
			}
			$smarty->assign("templates", $templates);
			
			$smarty->assign("title", "Ustawienia");
			$strona = 'ustawienia';
		}elseif (isset($_GET['strony'])){
		
			$q = mysql_query('select * from strony');
			while($dane = mysql_fetch_array($q)){$strony[]= $dane;}
			$smarty->assign("strony", $strony);
			
			$smarty->assign("title", "Dodatkowe strony");
			$strona = 'strony';
		}elseif (isset($_GET['kategorie'])){
			$smarty->assign("title", "Kategorie");
			$strona = 'kategorie';
		}elseif (isset($_GET['gry'])){
			if (isset($_GET['kategoria'])){
				$kategoria_gier=$_GET['kategoria'];
				$q = mysql_query('select * from kategorie where id="'.$_GET['kategoria'].'"');
				while($dane = mysql_fetch_array($q)){$nazwa_kategorii= $dane;}
				$smarty->assign("nazwa_kategorii", $nazwa_kategorii);
				$smarty->assign("title", $nazwa_kategorii['nazwa']);
			}else{
				$kategoria_gier='%';
				$smarty->assign("title", "Gry");
			}
			
			if (isset($_GET['sortuj']) and ($_GET['sortuj']=='pozycja' or $_GET['sortuj']=='slider')){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by '.$_GET['sortuj'].' desc');
				$smarty->assign("sortowanie", "- sortuj wg. ".$_GET['sortuj']);
			}else if (isset($_GET['sortuj']) and ($_GET['sortuj']=='data' or $_GET['sortuj']=='nazwa')){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by '.$_GET['sortuj'].' asc');
				$smarty->assign("sortowanie", "- sortuj wg. ".$_GET['sortuj']);
			}else if (isset($_GET['sortuj']) and $_GET['sortuj']=='slider-asc'){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by slider asc');
				$smarty->assign("sortowanie", "- sortuj odwrotnie wg. slider");
			}else if (isset($_GET['sortuj']) and $_GET['sortuj']=='nazwa-desc'){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by nazwa desc');
				$smarty->assign("sortowanie", "- sortuj odwrotnie wg. nazwa");
			}else if (isset($_GET['sortuj']) and $_GET['sortuj']=='data-desc'){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by data desc');
				$smarty->assign("sortowanie", "- sortuj odwrotnie wg. data");
			}else if (isset($_GET['sortuj']) and $_GET['sortuj']=='pozycja-asc'){
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by pozycja asc');
				$smarty->assign("sortowanie", "- sortuj odwrotnie wg. pozycja");
			}else{
				$q = mysql_query('select * from gry where kategorie like "%-'.$kategoria_gier.'-%" or kategorie="" order by pozycja desc');
			}
			
			while($dane = mysql_fetch_array($q)){
				$ptagi = explode('-', $dane['tagi']);
				for($i=0; $i <= count($ptagi) - 1; $i++){
					if($ptagi[$i]>0){
						$p = mysql_query('select id, nazwa, prosta_nazwa from tagi where id='.$ptagi[$i].'');
						while($pdane = mysql_fetch_array($p)){$tagi_nazwa= $pdane;}
						if (isset($dane['tagi_nazwa'])){
							$dane['tagi_nazwa'] .= ' <a href="'.$base_url.'1/tag/'.$tagi_nazwa['id'].'/'.$tagi_nazwa['prosta_nazwa'].'" title="'.$tagi_nazwa['nazwa'].'">'.$tagi_nazwa['nazwa'].'</a>';
						}else{
							$dane['tagi_nazwa'] = ' <a href="'.$base_url.'1/tag/'.$tagi_nazwa['id'].'/'.$tagi_nazwa['prosta_nazwa'].'" title="'.$tagi_nazwa['nazwa'].'">'.$tagi_nazwa['nazwa'].'</a>';
						}
					}
				}
				$pkategorie = explode('-', $dane['kategorie']);
				for($i=0; $i <= count($pkategorie) - 1; $i++){
					if($pkategorie[$i]>0){
						$p = mysql_query('select id, nazwa, prosta_nazwa from kategorie where id='.$pkategorie[$i].'');
						while($pdane = mysql_fetch_array($p)){$kategorie_nazwa= $pdane;}
						if (isset($dane['kategorie_nazwa'])){
							$dane['kategorie_nazwa'] .= ' <a href="'.$base_url.'1/kategoria/'.$kategorie_nazwa['id'].'/'.$kategorie_nazwa['prosta_nazwa'].'" title="'.$kategorie_nazwa['nazwa'].'">'.$kategorie_nazwa['nazwa'].'</a>';
						}else{
							$dane['kategorie_nazwa'] = ' <a href="'.$base_url.'1/kategoria/'.$kategorie_nazwa['id'].'/'.$kategorie_nazwa['prosta_nazwa'].'" title="'.$kategorie_nazwa['nazwa'].'">'.$kategorie_nazwa['nazwa'].'</a>';
						}
					}
				}
			$gry[]= $dane;
			;}
			if(isset($_GET['strona'])){
				$smarty->assign("site", $_GET['strona']);
			}else{
				$smarty->assign("site", '1');
			}
			if(isset($_GET['sortuj'])){
				$smarty->assign("sortuj", $_GET['sortuj']);
			}else{
				$smarty->assign("sortuj", 'pozycja');
			}
			$smarty->assign("ile_stron", ceil(count($gry)/20));
			$smarty->assign("gry", $gry);
			$strona = 'gry';
		}elseif (isset($_GET['gra'])){
			if (isset($_GET['id'])){
				$q = mysql_query('select * from gry where id='.$_GET['id'].'');
				while($dane = mysql_fetch_array($q)){
					$dane['opis'] = htmlspecialchars_decode($dane['opis']);
					$gra= $dane;
				}
				$smarty->assign("gra", $gra);
				$smarty->assign("title", "Edytuj grę ".$gra['nazwa']);
			}else{
				$smarty->assign("title", "Dodaj nową grę");
			}
			$strona = 'gra';
		}elseif (isset($_GET['tagi'])){
			$strona = 'tagi';
			$smarty->assign("title", "Tagi");
		}elseif (isset($_GET['komentarze'])){
			if (isset($_GET['id'])){
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=0 and komentarze.id_gry ="'.$_GET['id'].'"');
				while($dane = mysql_fetch_array($q)){$komentarze_0[]= $dane;}
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=1 and komentarze.id_gry ="'.$_GET['id'].'"');
				while($dane = mysql_fetch_array($q)){$komentarze_1[]= $dane;}
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=2 and komentarze.id_gry ="'.$_GET['id'].'"');
				while($dane = mysql_fetch_array($q)){$komentarze_2[]= $dane;}
				$smarty->assign("kategoria_komentarzy", $komentarze_0['0']['nazwa']);
			}else{
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=0');
				while($dane = mysql_fetch_array($q)){$komentarze_0[]= $dane;}
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=1');
				while($dane = mysql_fetch_array($q)){$komentarze_1[]= $dane;}
				$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id and komentarze.status=2');
				while($dane = mysql_fetch_array($q)){$komentarze_2[]= $dane;}
			}
			$smarty->assign("komentarze_0", $komentarze_0);
			$smarty->assign("komentarze_1", $komentarze_1);
			$smarty->assign("komentarze_2", $komentarze_2);
			$smarty->assign("title", "Komentarze");
			$strona = 'komentarze';
		}elseif (isset($_GET['polecane'])){
			$q = mysql_query('select * from polecane_strony');
			while($dane = mysql_fetch_array($q)){$polecane_strony[]= $dane;}
			$smarty->assign("polecane_strony", $polecane_strony);
			$strona = 'polecane';
			$smarty->assign("title", "Polecane Strony");
		}elseif (isset($_GET['cms'])){
			$smarty->assign("login", $_SESSION['user_cms']);
			$strona = 'cms';
			$smarty->assign("title", "Ustawienia CMS");
		}else {
			$strona = 'home';
		}
	}else{
		unset($_SESSION['user_cms']);
		unset($_SESSION['user_cms_p']);
	}
}

$q = mysql_query('select * from tagi order by nazwa');
while($dane = mysql_fetch_array($q)){
	$dane['id_myslniki'] = '-'.$dane['id'].'-';
	$tagi[]= $dane;
}
if(isset($tagi)){
	$smarty->assign("tagi", $tagi);
}

$q = mysql_query('select * from kategorie order by nazwa');
while($dane = mysql_fetch_array($q)){
	$dane['id_myslniki'] = '-'.$dane['id'].'-';
	$kategorie[]= $dane;
}
if(isset($kategorie) and $kategorie !=''){
	$smarty->assign("kategorie", $kategorie);
}

$q = mysql_query('select * from komentarze, gry where komentarze.id_gry = gry.id group by komentarze.id_gry');
while($dane = mysql_fetch_array($q)){$komentarze_menu[]= $dane;}
if(isset($komentarze_menu)){
	$smarty->assign("komentarze_menu", $komentarze_menu);
}

$smarty->assign("ustawienia", $ustawienia);	

$smarty->assign('base_url',$base_url);
$smarty->assign('strona',$strona);
$smarty->display('index.tpl');
?>