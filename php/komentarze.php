<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 *
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 *
 * *********************************************************************/
 
	header('Content-Type: text/html; charset=utf-8');
	
	include('../controller/config.php');
	
	if($ustawienia['komentarze']=='1' and isset($_POST['id']) and isset($_POST['status']) and isset($_POST['komentarz']) and isset($_POST['podpis']) and isset($_POST['email']) and isset($_POST['code']) and isset($_POST['url'])){
	
		include("../securimage/securimage.php");
		$img = new Securimage();
		$valid = $img->check($_POST['code']);
		if ($valid == FALSE) {
		
			echo('error');
			
		} else{
		
			$validation_code = md5(uniqid(rand(), true));
			
			mysql_query('insert into komentarze values(null, "'.$_POST['id'].'", "'.$_POST['status'].'", "'.htmlspecialchars($_POST['komentarz']).'", "'.$_POST['podpis'].'", "'.$_POST['email'].'", '.time().', "'.$validation_code.'")');
			
			if($ustawienia['komentarze_potwierdzanie'] !='0'){
				if($ustawienia['komentarze_potwierdzanie']=='1'){
					$message = '
						Witaj na stronie '.$_SERVER['HTTP_HOST'].'. Dziękujemy za dodanie komentarza. 
						Prosimy o potwierdzenie swojego adresu e-mail klikając w link: '.$_POST['url'].'/'.$validation_code.' 
						Następnie Twój komentarz będzie musiał być aktywowany przez administratora.
						Pozdrawiamy
						Zespół '.$ustawienia['title'];
				}else{
					$message = '
						Witaj na stronie '.$_SERVER['HTTP_HOST'].'. Dziękujemy za dodanie komentarza. 
						Prosimy o potwierdzenie swojego adresu e-mail klikając w link: '.$_POST['url'].'/'.$validation_code.' 
						Pozdrawiamy
						Zespół '.$ustawienia['title'];
				}
				$header = "MIME-Version: 1.0\n";
				$header .= "Content-Type: text/plain;charset=utf-8\n";
				$header .= "Content-Transfer-Encoding: 8bit\n";
				$address = $_POST['email'];
				$subject = "Komentarz ze strony ".$_SERVER['HTTP_HOST'];
				mail($address, $subject, $message, $header);

			}

			echo('ok');
			
		}
	}
	
?>