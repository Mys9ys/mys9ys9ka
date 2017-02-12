<?
include("db.php");
echo <<<END
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Style.css" />
	<title>Прогнозы на ЕВРО-2016</title>
</head>
<body>
<div class="logo"></div>
END;
$user=$_REQUEST['user'];
$pasw=$_REQUEST['password'];
$user_name=$_REQUEST['user_name'];
$gender=$_REQUEST['gender'];
$birthday=$_REQUEST['birthday'];
$email=$_REQUEST['email'];

$PrMail =mysql_query("SELECT * FROM user_reg WHERE email='$email'");
$ProverkaEmail = mysql_fetch_assoc($PrMail); 
if(mysql_num_rows($PrMail)<1){
$PrLogin =mysql_query("SELECT * FROM user_reg WHERE login='$user'");
$ProverkaLogina = mysql_fetch_assoc($PrLogin); 
if(mysql_num_rows($PrLogin)<1){
$Segodnya=date('Y-m-d');
$code=$user.$pasw;
$hash=md5($code);//для идетификации
$userIp=$_SERVER['REMOTE_ADDR'];//айпишник
$RegUserInfo= mysql_query("INSERT INTO user_reg (User_ID, login, password, hash, user_name, birthday, gender, email, data_reg, city, user_info) 
VALUES (NULL, '$user', '$pasw', '$hash', '$user_name', '$birthday', '$gender', '$email', '$Segodnya', '', '')");
$RegUserProfile= mysql_query("INSERT INTO user_profile (User_ID, level, cube_att, cube_def, XP, HP, attack, defense, skills, avoid, fortune, crit, resistance, 
 initiative, vampirism, weakness, destruction, regeneration, bleeding, speed, battle_pvp, win_pvp, battle_mobs, win_mobs) 
 VALUES (NULL, '1', '2', '1', '0', '10', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0')");
$dresssumstats=mysql_query("INSERT INTO stats_sum 
											(User_ID,
											HP,
											attack, 
											defense, 
											avoid, 
											fortune, 
											crit, 
											resistance,											 
											vampirism, 
											weakness, 
											destruction, 
											regeneration, 
											bleeding,
											initiative,
											speed)
VALUES (NULL, '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1')");	
$RegUserMoney=mysql_query("INSERT INTO user_money (User_ID, money, amber) VALUES (NULL, '100', '10')");
$treasury= mysql_query("UPDATE treasury_tabl SET new_user=new_user+50, count_money=count_money+50 WHERE id=1");
$us_equip=mysql_query("INSERT user_equipment (User_ID, equip1) VALUES (NULL, '1')");
$us_resource=mysql_query("INSERT user_resources (User_ID, res1) VALUES (NULL, '0')");
$Equip_dress=mysql_query("INSERT user_equip_dress (User_ID, armor) VALUES (NULL, '0')");
 echo "регистрация успешно завершена<br>";
$perehod='<script>location.replace("profile.php?hash='.$hash.'");</script>';
 echo $perehod; exit;
}
if(mysql_num_rows($PrLogin)>0){
$perehod='<script>location.replace("index.php?code=2");</script>';
 echo $perehod; exit;}
}
if(mysql_num_rows($PrMail)>0){
$perehod='<script>location.replace("index.php?code=1");</script>';
 echo $perehod; exit;}

 



