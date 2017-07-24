<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="Keywords" content="CMS Content Management System, System zarządzania treścią">
	<meta name="Description" content="CMS - system zarządzania treścią dla Twojej strony internetowej.">
	<meta name="author" content="Kamil Wyremski - wyremski.pl">
	<title>{$title|default:CMS}</title>
	<base href="{$base_url}cms/"/>
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="views/css/style.css">
	<script type="text/javascript" src="js/jquery-2.0.2.min.js"></script>
    <script type="text/javascript" src="js/engine_cms.js"></script>
	<script type="text/javascript" src="js/whcookies.js"></script>
</head>
<body>
<div id="site">
	{if isset($user)}
		{if $ustawienia.logo == 0}
			<p style="color: #a8020b;	text-shadow: 0px 1px 0px #e5e5ee; font-size:20px; float: left; margin: 20px;">{$ustawienia.logo_text}<br>
				<span style="color: #0140d5; font-size: 18px;">{$ustawienia.logo_text2}</span></p>
		{else}
			<a href="{$base_url}" title="{$ustawienia.title}"><img src="../{$ustawienia.logo_url}" id="logo2" alt="Logo"/></a>
		{/if}
		<a href="http://wyremski.pl" title="Tworzenie stron internetowych" target="_blank"><img src="img/cms.png" id="logo" alt="Logo"/></a>
		<nav>
			<ul>
				<li><a href="{$base_url}cms/ustawienia">Ustawienia</a></li>
				<li><a href="{$base_url}cms/strony">Strony</a></li>
				<li><a href="{$base_url}cms/kategorie">Kategorie</a></li>
				<li><a href="{$base_url}cms/gry">Gry</a>
					<ul><li><a href="{$base_url}cms/gra" class="green_menu">Dodaj nową</a></li>
					{foreach key=key item=item from=$kategorie}
						<li><a href="{$base_url}cms/gry/1/pozycja/{$item.id}/{$item.prosta_nazwa}">{$item.nazwa}</a></li>
					{/foreach}
						<li><a href="{$base_url}cms/gry" class="green_menu">Wszystkie gry</a></li>
					</ul>
				</li>
				<li><a href="{$base_url}cms/tagi">Tagi</a></li>
				<li><a href="{$base_url}cms/komentarze">Komentarze</a>
					<ul><li><a href="{$base_url}cms/komentarze" class="green_menu">Wszystkie komentarze</a></li>
					{foreach key=key item=item from=$komentarze_menu}
						<li><a href="{$base_url}cms/komentarze/{$item.id}/{$item.prosta_nazwa}">{$item.nazwa}</a></li>
					{/foreach}
					</ul>
				</li>
				<li><a href="{$base_url}cms/polecane">Polecane Strony</a></li>
				<li class="last_menu"><a href="?wyloguj">Wyloguj</a></li>
				<li class="last_menu"><a href="?cms">CMS</a></li>
			</ul>
		</nav>
	{/if}

	{include file="$strona.html"}

</div>
<br><br><br>
<footer>
	<div>
		<span>CMS v1.2 Copyright and project © 2014 by <a href="http://wyremski.pl" target="_blank" title="Tworzenie Stron Internetowych">Kamil Wyremski</a>. All rights reserved.</span>
	</div>
</footer>
</body>
</html>
	