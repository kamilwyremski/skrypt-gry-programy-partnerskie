<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 *
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 *
 * *********************************************************************/
 
function pobierz_nazwy($zapytanie){
	while($dane = mysql_fetch_array($zapytanie)){
		$ptagi = explode('-', $dane['tagi']);
		for($i=0; $i <= count($ptagi) - 1; $i++){
			if($ptagi[$i]>0){
				$p = mysql_query('select id, nazwa, prosta_nazwa from tagi where id='.$ptagi[$i].'');
				while($pdane = mysql_fetch_array($p)){$tagi_nazwa= $pdane;}
				global $base_url;
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
				global $base_url;
				if (isset($dane['kategorie_nazwa'])){
					$dane['kategorie_nazwa'] .= ' <a href="'.$base_url.'1/kategoria/'.$kategorie_nazwa['id'].'/'.$kategorie_nazwa['prosta_nazwa'].'" title="'.$kategorie_nazwa['nazwa'].'">'.$kategorie_nazwa['nazwa'].'</a>';
				}else{
					$dane['kategorie_nazwa'] = ' <a href="'.$base_url.'1/kategoria/'.$kategorie_nazwa['id'].'/'.$kategorie_nazwa['prosta_nazwa'].'" title="'.$kategorie_nazwa['nazwa'].'">'.$kategorie_nazwa['nazwa'].'</a>';
				}
			}
		}
		$dane['krotkiopis'] = htmlspecialchars_decode($dane['krotkiopis']);
		$dane['opis'] = htmlspecialchars_decode($dane['opis']);
		$gry[]= $dane;
	;}
	
	return($gry);
}

?>