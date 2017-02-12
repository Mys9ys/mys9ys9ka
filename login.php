<?
include("db.php");
$user=$_REQUEST['user'];
$pasw=$_REQUEST['password'];
$ProvLog =mysql_query("SELECT * FROM user_reg WHERE login='$user' AND password='$pasw'");
$ProverkaLogina = mysql_fetch_assoc($ProvLog); 
if(mysql_num_rows($ProvLog)<1){
$perehod='<script>location.replace("index.php?code=3");</script>';
 echo $perehod; exit;}
if(mysql_num_rows($ProvLog)>0){
$code=$user.$pasw;
$hash=md5($code);
$perehod='<script>location.replace("profile.php?hash='.$hash.'");</script>';
 echo $perehod; exit;}
?>