<?
$HOST = 'mir.beget.com';//имя сервера
$USER = 'rjbexaj9_games';
$PASS = '32tameda';
$DB = 'rjbexaj9_games';//база данных

$con = mysql_connect ($HOST,$USER,$PASS) or die('ошибка соединения с сервером');
mysql_select_db($DB) or die('ошибка выбора БД');
?>