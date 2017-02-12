<?
include("db.php");
$UserID=$_REQUEST['User_ID'];
$XP=$_REQUEST['XP'];
$BattleLose=$_REQUEST['BattleLose'];
$Skills=$_REQUEST['Skills'];
$listenerID=$_REQUEST['listenerID'];
// прокачка атаки скилами
if ($Skills==1) {
$changeskills=mysql_query("UPDATE user_profile SET attack=attack+1, skills=skills-1 WHERE User_ID='$UserID'");
}
// прокачка защиты скилами
if ($Skills==2) {
$changeskills=mysql_query("UPDATE user_profile SET defense=defense+1, skills=skills-1 WHERE User_ID='$UserID'");
}
// увеличение опыта за победу
if ($XP>0) {
$Resultbattle=mysql_query("UPDATE user_profile SET XP=XP+'$XP', battle_mobs=battle_mobs+1, win_mobs=win_mobs+1 WHERE User_ID='$UserID'");
$activityproc=countactivity ($UserID,$XP);
$lvlcheck=lvlUp($UserID);
}
// запись поражения
if ($BattleLose>0) {
$Resultbattle=mysql_query("UPDATE user_profile SET battle_mobs=battle_mobs+1 WHERE User_ID='$listenerID'");
$activityproc=countactivity ($UserID,0);
$lvlcheck=lvlUp ($UserID);
}
if ($listenerID>0) {
	$listener = array();
	$workselect= mysql_query("SELECT * FROM user_works WHERE User_ID='$listenerID'");
	$listener=mysql_fetch_assoc($workselect);	
	$checkwork=mysql_query("SELECT * FROM works_bibl WHERE work_ID='$listener[work_ID]'");
	$works= mysql_fetch_assoc($checkwork);
	$listener[workname]=$works[name];
	$worktime=strtotime($listener[stop_work])-strtotime(date('Y-m-d H:i:s'));
	if ($worktime<0) {$worktime=0;}
	$listener[worktime]=$worktime;
	$listener[workspecialty]=$works[work_specialty];	
	$dlina=count($listener);
	//$proverka=mysql_query("UPDATE proverka_tabl SET arg3='$worktime', arg2='$dlina', arg4='$listener[workname]' WHERE prov_ID=1");
	$statuswork=$listener[action_ID];
	if ($statuswork>0) {	
		$dlina=count($listener);
		$proverka=mysql_query("UPDATE proverka_tabl SET arg3='$worktime', arg2='$dlina', arg3='$listener[workspecialty]', arg4='$listener[workname]' WHERE prov_ID=1");
		echo json_encode(array("listener" => $listener));
		exit;
	} else {
		$listener[action_ID]=0;
		echo json_encode(array("listener" => $listener));
		exit;
	}
}
$Warrior = array(); 
$vjbUser=mysql_query("SELECT * FROM user_reg WHERE User_ID='$UserID'");
$Profile= mysql_fetch_assoc($vjbUser);
$login=$Profile[login];
$checkActivity=mysql_query("SELECT * FROM user_activity WHERE User_ID='$UserID'");
$Activity= mysql_fetch_assoc($checkActivity); 
$week_activity=$Activity[week_activity];
$Checkmoney=mysql_query("SELECT * FROM user_money WHERE User_ID='$UserID'");
$moneycheck=mysql_fetch_assoc($Checkmoney);
$money=$moneycheck[money];
$amber=$moneycheck[amber];
$vjbWarrior=mysql_query("SELECT * FROM user_profile WHERE User_ID='$UserID'");
$Warrior= mysql_fetch_assoc($vjbWarrior);
$Warrior[login]=$login;
$Warrior[money]=$money;
$Warrior[amber]=$amber;
$Userlvl=$Warrior[level];
$CheckXP=mysql_query("SELECT * FROM XP_table WHERE LVL='$Userlvl'");
$XPtable= mysql_fetch_assoc($CheckXP);
$lvlupXP=$XPtable[XP];
$Warrior[lvlupXP]=$lvlupXP;
$Warrior[week_activity]=$week_activity;
echo json_encode(array("Warrior" => $Warrior));
exit;
// начисление активности
function countactivity ($UserID,$XP){
	$actball=$XP+1;
	$Dobactivity =mysql_query("SELECT * FROM user_activity WHERE User_ID='$UserID'");
	$activity = mysql_fetch_assoc($Dobactivity); 
	if(mysql_num_rows($Dobactivity)<1){
		$Segodnya=date('Y-m-d');
		$UserActivity= mysql_query("INSERT INTO user_activity (User_ID, day_activity, last_day_act, max_day_activity, week_activity, max_week_activity, sum_activity ) VALUES ( '$UserID', '1', '$Segodnya', '1', '1', '1', '1')");
	} 
	else {
		$Dayactivity =mysql_query("SELECT * FROM user_activity WHERE User_ID='$UserID'");
		$dayact = mysql_fetch_assoc($Dayactivity); 
		$todayactivity=$dayact[last_day_act];
		$max_day_activity=$dayact[max_day_activity];
		$today_activity=$dayact[day_activity];
		$today=date('Y-m-d', strtotime("-1 days"));
		$Segodnya=date('Y-m-d');
		if ($today>=$todayactivity) {	
			if ($today_activity>$max_day_activity){$max_day_activity=$today_activity;}
			$UserActivity=mysql_query("UPDATE user_activity SET day_activity='$actball', last_day_act='$Segodnya', max_day_activity='$max_day_activity', week_activity=week_activity+'$actball', max_week_activity=max_week_activity+'$actball', sum_activity=sum_activity+'$actball' WHERE User_ID='$UserID'");
		} else {
			$UserActivity=mysql_query("UPDATE user_activity SET day_activity=day_activity+'$actball', last_day_act='$Segodnya', week_activity=week_activity+'$actball', sum_activity=sum_activity+'$actball' WHERE User_ID='$UserID'");
		}
		$wday=date('w');
		if ($wday==1) { 
			$activity =mysql_query("SELECT * FROM flag_activity");
			$act = mysql_fetch_assoc($activity); 
			$flag_activity=$act[flag_count];
			if ($flag_activity==1) {
				$checkactivity=mysql_query("SELECT * FROM user_activity");
				while($useractivity= mysql_fetch_array($checkactivity)){
					$actuserID=$useractivity[User_ID];
					$lastweek=$useractivity[week_activity];
					$maxweek=$useractivity[max_week_activity];
					if ($maxweek<$lastweek) {$maxweek=$lastweek;}
					$UserActivity=mysql_query("UPDATE user_activity SET week_activity=0, last_week='$lastweek', max_week_activity='$maxweek' WHERE User_ID='$actuserID'");
				}
				$resetflag=mysql_query("UPDATE flag_activity SET flag_count=0");
				$activityMes=mysql_query("SELECT * FROM user_activity");
				while($checkuseractivity= mysql_fetch_array($activityMes)){
					$addressee_ID=$checkuseractivity[User_ID];
					$datawrite=date('Y-m-d H:i:s');
					$writemessage=mysql_query("INSERT messages (mes_ID, addressee_ID, sender_ID, readmes, date_send, date_read, topic, text_content) 
					VALUES (NULL, '$addressee_ID', '1', '1', '$datawrite', '', 'завершение недели активности', 'завершилась неделя набора активности. Вы набрали $lastweek баллов активности')");						
				}
			}
		} else {
			$resetflag=mysql_query("UPDATE flag_activity SET flag_count=1");
		}
	}
}
		//повышение лвла
function lvlUp ($UserID){
	$vjbUser=mysql_query("SELECT * FROM user_profile WHERE User_ID='$UserID'");
	$Profile= mysql_fetch_assoc($vjbUser);
	$UserXP=$Profile[XP];
	$UserLVL=$Profile[level];
	$PrXP= mysql_query("SELECT * FROM XP_table");
	while($Bibl= mysql_fetch_assoc($PrXP)){
		$XP_table=$Bibl[XP];
		$LVL=$Bibl[LVL];
		$money_treasury=$Bibl[money_treasury];
		$amber=$Bibl[amber];
		if ($UserXP>$XP_table) {
			if ($UserLVL<$LVL) {	
			$HPplus=$Bibl[HP]; 
			$Skill=$Bibl[skill]; 
			$cube_att=$Bibl[cube_att]; 
			$cube_def=$Bibl[cube_def]; 
			$initiative=$Bibl[initiative]; 
			$speed=$Bibl[speed];
			$UserLVLUP=mysql_query("UPDATE user_profile SET level=level+1, HP=HP+'$HPplus', skills=skills+'$Skill', cube_att=cube_att+'$cube_att', 
			cube_def=cube_def+'$cube_def', initiative=initiative+'$initiative', speed=speed+'$speed' WHERE User_ID='$UserID'");
			$user_money= mysql_query("UPDATE user_money SET amber=amber+'$amber' WHERE User_ID='$UserID' ");
			$treasury= mysql_query("UPDATE treasury_tabl SET lvl_up=lvl_up+'$money_treasury', count_money=count_money+'$money_treasury' WHERE id=1");
			}
		}
	}
}

?>
