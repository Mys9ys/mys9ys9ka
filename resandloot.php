<?
include("db.php");
require_once('func.php');
$UserID=$_REQUEST['User_ID'];
$resID=$_REQUEST['resID'];
$workspecialty=$_REQUEST['workspecialty'];
$workresID=$_REQUEST['workresID'];
$worktime=$_REQUEST['worktime'];
$workcountres=$_REQUEST['workcountres'];
$stopwork=$_REQUEST['stopwork'];
$workcomplite=$_REQUEST['workcomplite'];
$locID=$_REQUEST['locID'];
$workID=$_REQUEST['workID'];

if ($resID>0) {
	$res='res'.$resID;
	$Lootupdate=mysql_query("UPDATE user_resources SET $res=$res+1 WHERE User_ID='$UserID'");
	$Resbibl=mysql_query("SELECT * FROM resources_bibl WHERE Res_ID='$resID'");
	$Lootpic=mysql_fetch_assoc($Resbibl);
	echo json_encode(array("Lootpic" => $Lootpic));
exit;
}
if ($workresID>0) {
	$workstart=date('Y-m-d H:i:s');
	$workstop=date('Y-m-d H:i:s', strtotime("+$worktime min"));
	$workwrite=mysql_query("INSERT INTO user_works (action_ID, User_ID, work_ID, start_work, stop_work, count_resource, res_ID, loc_ID) 
		VALUES ('null', '$UserID', '$workID', '$workstart', '$workstop', '$workcountres', '$workresID', '$locID')");
	
}
if ($stopwork>0) {
	$workdelete= mysql_query("DELETE FROM user_works WHERE User_ID='$UserID'");

}
if($workcomplite>0) {
	$workselect= mysql_query("SELECT * FROM user_works WHERE User_ID='$UserID'");
	$workuser=mysql_fetch_assoc($workselect);
	$count_resource=$workuser[count_resource];
	$activityXP=$count_resource*2;
	$workIDres=$workuser[res_ID];
	$res='res'.$workIDres;
	$workupdate=mysql_query("UPDATE user_resources SET $res=$res+'$count_resource' WHERE User_ID='$UserID'");	
	$activityproc=countactivity ($UserID,$activityXP);
	$proverka=mysql_query("UPDATE proverka_tabl SET arg1='$activityXP', arg2='0', arg4='$Messages[sendername]' WHERE prov_ID=1");
	$workdelete= mysql_query("DELETE FROM user_works WHERE User_ID='$UserID'");	
}