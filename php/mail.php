<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 *
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 *
 * *********************************************************************/
 
	
	if(isset($_POST['code']) and isset($_POST['temat']) and isset($_POST['tresc']) and isset($_POST['email']) and isset($_POST['imie'])){
	
		include("../securimage/securimage.php");
		$img = new Securimage();
		$valid = $img->check($_POST['code']);
		if ($valid == FALSE) {
		
			echo('error');
			
		} else{
		
			header('Content-Type: text/html; charset=utf-8');
		
			$header = "MIME-Version: 1.0\n";
			$header .= "Content-Type: text/plain;charset=utf-8\n";
			$header .= "Content-Transfer-Encoding: 8bit\n";
			$message = $_POST['email_kontakt'].'
				Witaj! Została wysłana wiadomość ze strony '.$_SERVER['HTTP_HOST'].':
				Imię i nazwisko: '.$_POST['imie'].'
				Adres e-mail: '.$_POST['email'].'
				Temat wiadomości: '.$_POST['temat'].'
				Wiadomość: '.$_POST['tresc'].'';
			$address = $_POST['email_kontakt'];
			$subject = "=?UTF-8?B?".base64_encode("Wiadomość ze strony ".$_SERVER['HTTP_HOST']."")."?=";
			mail($address, $subject, $message, $header);

			echo('ok');
			
		}
	}
	
?>
