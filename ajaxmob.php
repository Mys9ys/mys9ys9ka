<?
include("db.php");
$loc_ID=$_REQUEST['loc_ID'];
$User_ID=$_REQUEST['User_ID'];
$mob_ID=$_REQUEST['mob_ID'];
//убийство моба
if ($loc_ID>0) {
$vjbLoc=mysql_query("SELECT * FROM loc_bibl WHERE loc_ID='$loc_ID'");
$Location= mysql_fetch_assoc($vjbLoc);
$countmobs=$Location[live_mobs];
$mob_ID=$Location[mob_ID];
if ($countmobs<1) { 
$Killmobs[live_mobs]=$countmobs;
echo json_encode(array("Killmobs" => $Killmobs));
exit; }
else {
$regtime=$Location[mob_reg_min];
$endtime=date('Y-m-d H:i:s', strtotime("+$regtime minutes"));
$Resultbattle=mysql_query("UPDATE loc_bibl SET live_mobs=live_mobs-1, reg_time='$endtime' WHERE loc_ID='$loc_ID'");
$Seichas=date('Y-m-d H:i:s');
$Mobsreg=mysql_query("INSERT INTO mobs_regeneration (loc_ID, mob_ID, time_battle, time_regen) VALUES ('$loc_ID', '$mob_ID', '$Seichas', '$endtime')");
}
}
//запись фрага
if ($User_ID>0) {
$Dobfrag =mysql_query("SELECT * FROM user_frag WHERE User_ID='$User_ID'");
$Frag = mysql_fetch_assoc($Dobfrag); 
if(mysql_num_rows($Dobfrag)<1){
$mobnumber='mob'.$mob_ID;
$RegUserFrag= mysql_query("INSERT INTO user_frag (User_ID, $mobnumber) VALUES ( '$User_ID', '1')");
} else {
$mobnumber='mob'.$mob_ID;
$RegUserFrag=mysql_query("UPDATE user_frag SET $mobnumber=$mobnumber+1 WHERE User_ID='$User_ID'"); }
}
$Mob = array(); 
$vjbMob=mysql_query("SELECT * FROM mobs_bibl WHERE mob_ID='$mob_ID'");
$Mob= mysql_fetch_assoc($vjbMob);
echo json_encode(array("Mob" => $Mob));
exit;

?>
