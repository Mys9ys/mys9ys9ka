<?
include("db.php");
$UserID=$_REQUEST['User_ID'];
$Equip_ID=$_REQUEST['Equip_ID'];
$Shop_ID=$_REQUEST['Shop_ID'];
$purpose=$_REQUEST['purpose'];
if ($Equip_ID>0) {
	$removeequip=mysql_query("SELECT * FROM user_equip_dress WHERE User_ID='$UserID'");
	$equipremove= mysql_fetch_assoc($removeequip);
	$IDitemremove=$equipremove[$purpose];
	remove_item($IDitemremove,$UserID);
	$proverka=mysql_query("UPDATE proverka_tabl SET arg1='$UserID', arg2='$Equip_ID', arg3='$IDitemremove', arg4='$purpose' WHERE prov_ID=1");
	$dressequip=mysql_query("UPDATE user_equip_dress SET $purpose='$Equip_ID' WHERE User_ID='$UserID'");
	dress_item($Equip_ID,$UserID);
	$checkequip=mysql_query("SELECT * FROM equipment_bibl WHERE Equip_ID='$Equip_ID'");
	$equip= mysql_fetch_assoc($checkequip);	
}
if ($Shop_ID>0) {
	$checkshop=mysql_query("SELECT * FROM magazin WHERE Equip_ID='$Shop_ID'");
	$shops=mysql_fetch_assoc($checkshop);
	$price=$shops[price];
	$changeUserMoney = mysql_query("UPDATE user_money SET money=money-'$price' WHERE User_ID='$UserID'");
	$changeshop=mysql_query("UPDATE magazin SET count_item=count_item-1 WHERE Equip_ID='$Shop_ID'");
	$Equiparg='equip'.$Shop_ID;
	$changeEquipUser= mysql_query("UPDATE user_equipment SET $Equiparg=$Equiparg+1 WHERE User_ID='$UserID'");
	$chandeTreasury= mysql_query("UPDATE treasury_tabl SET shop=shop+'$price', count_money=count_money+'$price'");
	$proverka=mysql_query("UPDATE proverka_tabl SET arg1='$Shop_ID', arg2=0, arg3='$IDitemremove', arg4='$purpose' WHERE prov_ID=1");
}
function remove_item($IDitemremove,$UserID){
	$checkequip=mysql_query("SELECT * FROM equipment_bibl WHERE Equip_ID='$IDitemremove'");
	$equip= mysql_fetch_assoc($checkequip);	
	$removeequipstats=mysql_query("UPDATE stats_equip SET 
											HP=HP-'$equip[HP]',
											attack=attack -'$equip[attack]', 
											defense=defense -'$equip[defense]', 
											avoid=avoid -'$equip[avoid]', 
											fortune=fortune -'$equip[fortune]', 
											crit=crit -'$equip[crit]', 
											resistance=resistance -'$equip[resistance]',
											initiative=initiative -'$equip[initiative]', 
											vampirism=vampirism -'$equip[vampirism]', 
											weakness=weakness -'$equip[weakness]', 
											destruction=destruction -'$equip[destruction]', 
											regeneration=regeneration -'$equip[regeneration]', 
											bleeding=bleeding -'$equip[bleeding]',
											speed=speed -'$equip[speed]'
											WHERE User_ID='$UserID'");
	$removesumstats=mysql_query("UPDATE stats_sum SET 
											HP=HP-'$equip[HP]',
											attack=attack -'$equip[attack]', 
											defense=defense -'$equip[defense]', 
											avoid=avoid -'$equip[avoid]', 
											fortune=fortune -'$equip[fortune]', 
											crit=crit -'$equip[crit]', 
											resistance=resistance -'$equip[resistance]',
											initiative=initiative -'$equip[initiative]', 
											vampirism=vampirism -'$equip[vampirism]', 
											weakness=weakness -'$equip[weakness]', 
											destruction=destruction -'$equip[destruction]', 
											regeneration=regeneration -'$equip[regeneration]', 
											bleeding=bleeding -'$equip[bleeding]',
											speed=speed -'$equip[speed]'
											WHERE User_ID='$UserID'");	
	$removesumstats=mysql_query("UPDATE user_profile SET 
											HP=HP-'$equip[HP]',
											attack=attack -'$equip[attack]', 
											defense=defense -'$equip[defense]', 
											avoid=avoid -'$equip[avoid]', 
											fortune=fortune -'$equip[fortune]', 
											crit=crit -'$equip[crit]', 
											resistance=resistance -'$equip[resistance]',
											initiative=initiative -'$equip[initiative]', 
											vampirism=vampirism -'$equip[vampirism]', 
											weakness=weakness -'$equip[weakness]', 
											destruction=destruction -'$equip[destruction]', 
											regeneration=regeneration -'$equip[regeneration]', 
											bleeding=bleeding -'$equip[bleeding]',
											speed=speed -'$equip[speed]'
											WHERE User_ID='$UserID'");											
}
function dress_item($Equip_ID,$UserID){
	$checkequip=mysql_query("SELECT * FROM equipment_bibl WHERE Equip_ID='$Equip_ID'");
	$equip= mysql_fetch_assoc($checkequip);
	$dressequipstats=mysql_query("UPDATE stats_equip SET 
											HP=HP+'$equip[HP]',
											attack=attack +'$equip[attack]', 
											defense=defense +'$equip[defense]', 
											avoid=avoid +'$equip[avoid]', 
											fortune=fortune +'$equip[fortune]', 
											crit=crit +'$equip[crit]', 
											resistance=resistance +'$equip[resistance]',
											initiative=initiative +'$equip[initiative]', 
											vampirism=vampirism +'$equip[vampirism]', 
											weakness=weakness +'$equip[weakness]', 
											destruction=destruction +'$equip[destruction]', 
											regeneration=regeneration +'$equip[regeneration]', 
											bleeding=bleeding +'$equip[bleeding]',
											speed=speed +'$equip[speed]'
											WHERE User_ID='$UserID'");
	$dresssumstats=mysql_query("UPDATE stats_sum SET 
											HP=HP+'$equip[HP]',
											attack=attack +'$equip[attack]', 
											defense=defense +'$equip[defense]', 
											avoid=avoid +'$equip[avoid]', 
											fortune=fortune +'$equip[fortune]', 
											crit=crit +'$equip[crit]', 
											resistance=resistance +'$equip[resistance]',
											initiative=initiative +'$equip[initiative]', 
											vampirism=vampirism +'$equip[vampirism]', 
											weakness=weakness +'$equip[weakness]', 
											destruction=destruction +'$equip[destruction]', 
											regeneration=regeneration +'$equip[regeneration]', 
											bleeding=bleeding +'$equip[bleeding]',
											speed=speed +'$equip[speed]'
											WHERE User_ID='$UserID'");	
	$dresssumstats=mysql_query("UPDATE user_profile SET 
											HP=HP+'$equip[HP]',
											attack=attack +'$equip[attack]', 
											defense=defense +'$equip[defense]', 
											avoid=avoid +'$equip[avoid]', 
											fortune=fortune +'$equip[fortune]', 
											crit=crit +'$equip[crit]', 
											resistance=resistance +'$equip[resistance]',
											initiative=initiative +'$equip[initiative]', 
											vampirism=vampirism +'$equip[vampirism]', 
											weakness=weakness +'$equip[weakness]', 
											destruction=destruction +'$equip[destruction]', 
											regeneration=regeneration +'$equip[regeneration]', 
											bleeding=bleeding +'$equip[bleeding]',
											speed=speed +'$equip[speed]'
											WHERE User_ID='$UserID'");											
}
