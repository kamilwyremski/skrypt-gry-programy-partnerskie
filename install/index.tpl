<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta name="author" content="Kamil Wyremski - wyremski.pl">
	<title>Instalacja skryptu do gier z PP</title>
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="jquery-2.0.2.min.js"></script>
	<script type="text/javascript" src="engine.js"></script>
</head>
<body>
<div id="site">
	<div class="center">
		<a href="http://wyremski.pl" title="Tworzenie stron www"><img src="../cms/img/cms.png" alt="CMS Kamil Wyremski" id="logo"/></a>
	<h2>Witaj w programie instalacyjnym strony<br> do skryptu dla gier z Programów Parnerskich.<br> Prosimy o wypełnienie poniższych pól<br> aby wstępnie skonfigurować stronę.<br><span style="color: red">Uwaga! Program instalacyjny usunie wszystkie<br>dotychczasowe rekordy z podanej bazy danych!</span></h2>
	{if $error}
		<h3>{$error}</h3>
	{/if}
	<form method="post" action="">
		<table>
			<tr>
				<td>Adres URL strony:</td>
				<td><input class="input" type="text" name="url" placeholder="Adres URL" value="{$url}" required/></td>
			</tr>
			<tr>
				<td>Serwer bazy danych:</td>
				<td><input class="input" type="text" name="serwer" placeholder="Serwer mysql" value="{$serwer}" required/></td>
			</tr>
			<tr>
				<td>Port serwera bazy danych:</td>
				<td><input class="input" type="text" name="port" placeholder="Port serwera" value="{$port}" required/></td>
			</tr>
			<tr>
				<td>Nazwa użytkownika bazy danych:</td>
				<td><input class="input" type="text" name="uzytkownik" placeholder="Użytkownik" value="{$uzytkownik}" required/></td>
			</tr>
			<tr>
				<td>Nazwa bazy danych:</td>
				<td><input class="input" type="text" name="nazwa" placeholder="Nazwa bazy" value="{$nazwa}" required/></td>
			</tr>
			<tr>
				<td>Hasło do bazy danych:</td>
				<td><input class="input" type="password" name="haslo" placeholder="Hasło do bazy" value="{$haslo}"/></td>
			</tr>
			<tr>
				<td>Login do systemu CMS:</td>
				<td><input class="input" type="text" name="logincms" placeholder="Login do CMS" value="{$logincms}" required/></td>
			</tr>
			<tr>
				<td>Hasło do systemu CMS:</td>
				<td><span class="red">Podane hasła są różne</span><input class="input" type="password" name="haslocms" placeholder="Hasło do CMS" value="{$haslocms}" required/></td>
			</tr>
			<tr>
				<td>Powtórz hasło do systemu CMS:</td>
				<td><input class="input" type="password" name="haslocms2" placeholder="Hasło do CMS" required/></td>
			</tr>
		</table>
		<input type="submit" value="Zapisz" class="submit" style="margin:10px"/>
	</form>
	</div>
</div>
<br><br><br>
<footer>
	<div>
		<span>CMS v1.2 Copyright and project © 2014 by <a href="http://wyremski.pl" target="_blank" title="Tworzenie Stron Internetowych">Kamil Wyremski</a>. All rights reserved.</span>
	</div>
</footer>
</body>
</html>
