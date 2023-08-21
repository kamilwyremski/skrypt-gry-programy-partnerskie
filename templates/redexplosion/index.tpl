<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
	<meta name="Keywords" content="{if $gra.keywords}{$gra.keywords}{else}{$ustawienia.keywords}{/if}">
	<meta name="Description" content="{if $gra.description}{$gra.description}{else}{$ustawienia.description}{/if}">
	<meta name="author" content="Kamil Wyremski - wyremski.pl">
	<title>{if $gra.nazwa}{$gra.nazwa} - {elseif $title}{$title} - {/if}{$ustawienia.title}</title>
	<link href='http://fonts.googleapis.com/css?family=Oswald&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oregano&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{$base_url}templates/{$ustawienia.template}/css/style.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="{$base_url}templates/{$ustawienia.template}/js/jquery-2.0.2.min.js"></script>
	{if $slider}
		<link rel="stylesheet" href="{$base_url}templates/{$ustawienia.template}/jcarousel/jcarousel.responsive.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="{$base_url}templates/{$ustawienia.template}/jcarousel/jquery.jcarousel.min.js"></script>
		<script type="text/javascript" src="{$base_url}templates/{$ustawienia.template}/jcarousel/jcarousel.responsive.js"></script>
	{/if}
	<script type="text/javascript" src="{$base_url}templates/{$ustawienia.template}/js/engine.js"></script>
	{if $ustawienia.favicon =='1'}
		<link rel="icon" type="image/ico" href="{$ustawienia.favicon_url}">
	{/if}
</head>
<body>
<div id="top_menu_box">
	<div id="top_menu">
		{if $ustawienia.wyszukiwarka =='1'}
		<form action="" method="post">
			<input name="szukaj" type="text" placeholder="Szukaj..." style="width:155px"/>
			<input type="submit" value="Szukaj"/>
		</form>
		{/if}
		<nav><ul>
			<li><a href="{$base_url}" title="{$ustawienia.title}">Home</a></li>
			<li><a href="#" class="link_zero">Kategorie</a>
				<ul>
				{foreach key=key item=item from=$kategorie}
					<li><a href="{$base_url}1/kategoria/{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
					<li><a href="{$base_url}" title="Wszystkie gry">Wszystkie gry</a></li>
				</ul>
			</li>
			{if $polecane}
			<li><a href="#" class="link_zero">Najlepsze</a>
				<ul>
				{foreach key=key item=item from=$polecane}
					<li><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</li>
			{/if}
			{if $nowe_gry}
			<li><a href="#" class="link_zero">Najnowsze</a>
				<ul>
				{foreach key=key item=item from=$nowe_gry}
					<li><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</li>
			{/if}
			{foreach key=key item=item from=$strony}
				<li><a href="{$base_url}{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:15}</a></li>
			{/foreach}
			{if $ustawienia.kontakt == 1}
				<li><a href="{$base_url}kontakt" title="Kontakt z nami">Kontakt</a></li>
			{/if}
		</ul></nav>
	</div>
</div>
{if $slider}
<div id="top">
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul>
				{foreach key=key item=item from=$slider}
					<li><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}">{$item.krotkiopis}</a></li>
				{/foreach}
			</ul>
		</div>
	 </div>
	{if $ustawienia.logo == 0}
		<h1>{$ustawienia.logo_text}</h1>
		<h2>{$ustawienia.logo_text2}</h2>
	{else}
		<a href="{$base_url}" title="{$ustawienia.title}"><img src="{$ustawienia.logo_url}" alt="Logo"/></a>
	{/if}
{else}
<div id="top" style="height: 160px; text-align:center">
	{if $ustawienia.logo == 0}
		<h1 style="margin:auto; padding-top: 35px;">{$ustawienia.logo_text}</h1>
		<h2 style="margin:auto; margin-top: 10px;">{$ustawienia.logo_text2}</h2>
	{else}
		<a href="{$base_url}" title="{$ustawienia.title}"><img src="{$ustawienia.logo_url}" alt="Logo" style="margin:auto; margin-top: 40px; max-height: 150px;"/></a>
	{/if}
{/if}
</div>

<div class="site">
	{if $ustawienia.reklama_big !=''}
	<div class="reklama_big">
		{$ustawienia.reklama_big}
	</div>
	{else}
	<div style="height:5px; width: 1098px;"></div>
	{/if}
	<div class="left">
		<div class="right_box">
			<h3>KATEGORIE GIER</h3>
			<ul>
			{foreach key=key item=item from=$kategorie}
				<li><a href="{$base_url}1/kategoria/{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
			{/foreach}
				<li><a href="{$base_url}" title="Wszystkie gry">Wszystkie gry</a></li>
			</ul>
		</div>
		{if $ustawienia.reklama_1 !=''}
			<div class="right_box">
				<div class="reklama1">{$ustawienia.reklama_1}
				</div>
			</div>
		{/if}
		{if $polecane}
			<div class="right_box">
				<h3>NAJLEPSZE GRY</h3>
				<ul>
				{foreach key=key item=item from=$polecane}
					<li><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</div>
		{/if}
		{if $ustawienia.reklama_2 !=''}
			<div class="right_box">
				<div class="reklama1">{$ustawienia.reklama_2}
				</div>
			</div>
		{/if}
		{if $nowe_gry}
			<div class="right_box">
				<h3>NAJNOWSZE GRY</h3>
				<ul>
				{foreach key=key item=item from=$nowe_gry}
					<li><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</div>
		{/if}
		{if $tagi}
		<div class="right_box">
			<h3>TAGI</h3>
			<div class="right_tagi">
			{foreach key=key item=item from=$tagi}
				<a class="tagi{$item.size}" href="{$base_url}1/tag/{$item.id}/{$item.prosta_nazwa}" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a>
			{/foreach}
			</div>
		</div>
		{/if}
		{if $ustawienia.reklama_3 !=''}
			<div class="right_box">
				<div class="reklama1">{$ustawienia.reklama_3}
				</div>
			</div>
		{/if}
		{if $ustawienia.polecane_strony=='1' && $polecane_strony}
			<div class="right_box">
				<h3>POLECANE STRONY</h3>
				<ul>
				{foreach key=key item=item from=$polecane_strony}
					<li><a href="{$item.url}" target="_blank" title="{$item.nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</div>
		{/if}
		{if $ustawienia.statystyki == '1'}
			<div class="right_box">
				<h3>STATYSTYKI</h3>
				<table id="table_statystyki">
					<tr><td>Gier w bazie:</td><td>{$st_gry}</td><td></td></tr>
					<tr><td>Kategorii:</td><td>{$st_kategorie}</td><td></td></tr>
					<tr><td>Tagów:</td><td>{$st_tagi}</td><td></td></tr>
					<tr><td>Komentarzy:</td><td>{$st_komentarze}</td><td></td></tr>
				</table>
			</div>
		{/if}
		{if $ustawienia.reklama_4 !=''}
			<div class="right_box">
				<div class="reklama1">{$ustawienia.reklama_4}
				</div>
			</div>
		{/if}
		{if $nowe_komentarze}
			<div class="right_box">
				<h3>NAJNOWSZE KOMENTARZE</h3>
				<ul>
				{foreach key=key item=item from=$nowe_komentarze}
					<li><span>{$item.podpis|truncate:30} o </span><a href="{$base_url}{$item.id}/{$item.prosta_nazwa}">{$item.nazwa|truncate:30}</a></li>
				{/foreach}
				</ul>
			</div>
		{/if}
		{if $ustawienia.reklama_5 !=''}
			<div class="right_box">
				<div class="reklama1">{$ustawienia.reklama_5}
				</div>
			</div>
		{/if}
	</div>
	<div class="right">
	
		{if $left_info}
			<div id="left_info">
				<h1>{$left_info}</h1>
			</div>
		{/if}
		
		{if $site}
		<div class="strony">
			<div class="strona_div">Strona {$site} z {$ile_stron}</div>
			<a {if $site>2}href="{$base_url}1{$site_url}" class="strona"{else} class="strona nieaktywne"{/if} title="Pierwsza strona">« Pierwsza</a>
			<a {if $site>1}href="{$base_url}{$site-1}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Poprzednia strona">« Poprzednia</a>
			<a {if $site<$ile_stron}href="{$base_url}{$site+1}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Następna strona">Następna »</a>
			<a {if $site<$ile_stron-1}href="{$base_url}{$ile_stron}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Ostatnia strona">Ostatnia »</a>
		</div>
		{/if}
		
		{include file="$strona.html"}
		
		{if $site}
		<div class="strony">
			<div class="strona_div">Strona {$site} z {$ile_stron}</div>
			<a {if $site>2}href="{$base_url}1{$site_url}" class="strona"{else} class="strona nieaktywne"{/if} title="Pierwsza strona">« Pierwsza</a>
			<a {if $site>1}href="{$base_url}{$site-1}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Poprzednia strona">« Poprzednia</a>
			<a {if $site<$ile_stron}href="{$base_url}{$site+1}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Następna strona">Następna »</a>
			<a {if $site<$ile_stron-1}href="{$base_url}{$ile_stron}{$site_url}" class="strona" {else}class="strona nieaktywne"{/if} title="Ostatnia strona">Ostatnia »</a>
		</div>
		{/if}
		
	</div>
	{if $ustawienia.reklama_big2 !=''}
	<div class="reklama_big2">
		{$ustawienia.reklama_big2}
	</div>
	{/if}
	<footer>
		<!-- Skrypt na licencji MIT. Usuwanie informacji o autorze oprogramowania jest zakazane -->
		<p>{if $ustawienia.footer_nazwa}Copyright © by <a href="{$ustawienia.footer_url}" target="_blank" title="{$ustawienia.footer_nazwa}">{$ustawienia.footer_nazwa}</a> - wszelkie prawa zastrzeżone. {/if}Project © 2014 - 2016 by <a href="http://wyremski.pl" target="_blank" title="Tworzenie Stron Internetowych">Kamil Wyremski</a></p>
	</footer>
</div>
{$ustawienia.reklama_ukryta}
<div id="back_top"></div>
</body>
</html>
