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

if(isset($_SESSION['user_cms']) and isset($_SESSION['user_cms_p'])){
	$q = mysql_query('select * from cms where login="'.$_SESSION['user_cms'].'" and password="'.$_SESSION['user_cms_p'].'"');
	while($dane = mysql_fetch_array($q)){$user_cms1= $dane;}
	if(isset($user_cms1)){
		if($_POST['action']=='dodaj'){
			mysql_query('update komentarze set status="2" where id="'.$_POST['id'].'"');
		}elseif($_POST['action']=='usun'){
			mysql_query('delete from komentarze where id="'.$_POST['id'].'"');
		}
	}
}

?>