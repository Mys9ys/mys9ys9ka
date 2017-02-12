<?
include("db.php");
$Mes_ID=$_REQUEST['mes_ID'];
$Admin_message=$_REQUEST['adminmestext'];
if (isset($Admin_message)) {
	$datawrite=date('Y-m-d H:i:s');
	$writemessage=mysql_query("INSERT messages (mes_ID, addressee_ID, sender_ID, readmes, date_send, date_read, topic, text_content) 
	VALUES (NULL, '1', '1', '1', '$datawrite', '', 'проверка', '$Admin_message')");	
}
$Messages = array();
$checkMes=mysql_query("SELECT * FROM messages WHERE mes_ID='$Mes_ID'");
$Messages= mysql_fetch_assoc($checkMes);
$senderID=$Messages[sender_ID];
$checksenderID=mysql_query("SELECT * FROM user_reg WHERE User_ID='$senderID'");
$Profile= mysql_fetch_assoc($checksenderID);
$sendername=$Profile[login];
$Messages[sendername]=$sendername;
$checkread=$Messages[readmes];
if ($checkread==1) {
	$dataread=date('Y-m-d H:i:s');
	$datareadupdate=mysql_query("UPDATE messages SET date_read='$dataread', readmes=0 WHERE mes_ID='$Mes_ID'");
}
$proverka=mysql_query("UPDATE proverka_tabl SET arg1='$Mes_ID', arg2='$senderID', arg4='$Messages[sendername]' WHERE prov_ID=1");
echo json_encode(array("Messages" => $Messages));
exit;
?>