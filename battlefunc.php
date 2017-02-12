<?
include("db.php");
//восстановление мобов на локации
function mobs_regen(){
$vjbLoc=mysql_query("SELECT * FROM loc_bibl ");
while($Location= mysql_fetch_assoc($vjbLoc)){
$loc_ID=$Location[loc_ID];
$loc_name=$Location[loc_name];
$live_mobs=$Location[live_mobs];
$count_mobs=$Location[count_mobs];
$reg_time=$Location[reg_time];
if ($live_mobs<$count_mobs) {
$runtime=date('Y-m-d H:i:s');
if ($runtime>$reg_time) {
$regtime=$Location[mob_reg_min];
$endtime=date('Y-m-d H:i:s', strtotime("+$regtime minutes"));
$Resultbattle=mysql_query("UPDATE loc_bibl SET live_mobs=live_mobs+1, reg_time='$endtime' WHERE loc_ID='$loc_ID'");
} else continue;
} else continue;
} return;
}

?>