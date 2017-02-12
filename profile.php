<?
include("db.php");
require_once("battlefunc.php");
$mobs_reg=mobs_regen();
echo <<<END
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Style.css" />
	<title>Новый мир</title>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script type='text/javascript' src='userlistener.js'></script>
	<script>
$(document).ready(function() {  
   $.ajax({
    url: "ajaxuser.php",
    type: "POST",
    dataType: "json",
    data: ("User_ID="+$("#UserID").val()),
    success: function(json){
	var userXP =json.Warrior['XP'];
    $("#XP").text(userXP);
	$("#HP").text(json.Warrior['HP']);	
	$("#LVL").text(json.Warrior['level']);	
	$("#attcube").text(json.Warrior['cube_att']);
	$("#defcube").text(json.Warrior['cube_def']);
	$("#attack").text(json.Warrior['attack']);
	$("#defense").text(json.Warrior['defense']);
	$("#free_skills").text(json.Warrior['skills']);
	$("#activity").text(json.Warrior['week_activity']);
	$("#money").text(json.Warrior['money']);
	$("#amber").text(json.Warrior['amber']);	
	var lvlupXP = json.Warrior['lvlupXP'];
	var lastXP = (lvlupXP*2+100)-userXP;
	$("#XP_contener").attr("title",'осталось набрать '+lastXP+' опыта');
	var widthXPline=(130*(userXP-lvlupXP)/(lvlupXP*1+100));
	$("#XP_line").css("width",widthXPline);	
    }
    }); 		
});
// распределение скилов
var interval = setTimeout( function() {freeskills()}, 1000);
	function freeskills(){
		var freeskills=$("#free_skills").text();
		if (freeskills >0){
			$('.addskills').css({"display":"block"});
			$('#attskills').click(function(){
				$.ajax({
				url: "ajaxuser.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $("#UserID").val(),Skills: '1'},
				success: function(json){
				$("#attack").text(json.Warrior['attack']);
				$("#free_skills").text(json.Warrior['skills']);
				$('.addskills').css({"display":"none"});
				}
				});
			});			
			$('#defskills').click(function(){
				$.ajax({
				url: "ajaxuser.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $("#UserID").val(),Skills: '2'},
				success: function(json){
				$("#defense").text(json.Warrior['defense']);
				$("#free_skills").text(json.Warrior['skills']);
				$('.addskills').css({"display":"none"});
				}
				});
			});
			return;
		}	
	}
$(function(){
$('#buttonprof0').click(function(){	
	$('.divswitch').css("display", "none");	
	$('#page00').css("display", "block");
});
$('#buttonprof1').click(function(){	
	$('.divswitch').css("display", "none");	
	$('#page01').css("display", "block");
	$('.message_listing').css("display", "block");
});
$('#buttonprof2').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page02').css("display", "block");
});
$('#buttonprof3').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page03').css("display", "block");
});
$('#buttonprof4').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page04').css("display", "block");
});
$('#buttonprof5').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page05').css("display", "block");
});
$('#buttonprof6').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page06').css("display", "block");
});
$('#buttonprof7').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page07').css("display", "block");
});
$('#buttonprof8').click(function(){	
	$('.divswitch').css("display", "none");
	$('#page08').css("display", "block");
});
$('#openrating').click(function(){	
	$('#userrating').css("display", "block");	
});
$('#closerating').click(function(){	
	$('#userrating').css("display", "none");
	$('#city_cont').css("display", "block");
});
$('#journal_button').click(function(){	
	$('.content_contener').css("display", "none");
	$('#journal_cont').css("display", "block");	
});
$('#bag_button').click(function(){	
	$('.content_contener').css("display", "none");
	$('#bag_cont').css("display", "block");	
});
$('#city_button').click(function(){	
	$('.content_contener').css("display", "none");
	$('#city_cont').css("display", "block");	
});
$('#map_button').click(function(){	
	$('.content_contener').css("display", "none");
	$('#map_cont').css("display", "block");	
});
$('#button_eqiup').click(function(){	
	$('.cargo').css("display", "none");
	$('#cargo_eqiup').css("display", "block");	
});
$('#button_resource').click(function(){	
	$('.cargo').css("display", "none");
	$('#cargo_resource').css("display", "block");	
});
$('#button_quest').click(function(){	
	$('.cargo').css("display", "none");
	$('#cargo_quest').css("display", "block");	
});
});
$(function(){
$('.cargo_equip').bind('click', function(){		
	var id = $(this).attr('id');
	var selpurpose ='#'+id+' .hiddenequippurpose';
	var selequipID='#'+id+' .hiddenequipID';
	var purpose= $(selpurpose).text();	
	$.ajax({
			url: "equipchange.php",
			type: "POST",
			dataType: "json",
			data: {User_ID: $("#UserID").val(),Equip_ID: $(selequipID).text(),purpose: $(selpurpose).text()}
		});	
		var picid ='item/equip'+$(selequipID).text()+'.jpg';
	var IDpic_purpose = '#'+purpose+'_pic';
	$(IDpic_purpose).css("display", "block");	
	$(IDpic_purpose).attr("src",picid);
});
});
$(function(){
	$('.message_contener').bind('click', function(){
		var mesID = $(this).attr('id');	
		var idmes = '#readID'+mesID;			
		$(idmes).css("display", "block");				
		$.ajax({
			url: "message.php",
			type: "POST",
			dataType: "json",
			data: {mes_ID: mesID},
			success: function(json){				
				$(".messendername").text(json.Messages['sendername']);
				alert('proverka');
			}
		});
	});	
});
$(function(){
	$('#admimmesbutton').click(function(){		
	$.ajax({
			url: "message.php",
			type: "POST",
			dataType: "json",
			data: {adminmestext: $(".adminmestext").val()}
		});	
	});
});
function equipitem(){
	
}
$(function(){		
	for(var i=1;i<2;i++){			
		IDrotate='#rotateloccont'+i;		
		var minrotate = -10;
		var maxrotate = 10;
		var rotaterand=Math.floor(Math.random()* (maxrotate - minrotate + 1)) + minrotate;		
		var rotatecount ='"transform": "rotate('+rotaterand+'deg)"';				
		$(IDrotate).css({rotatecount});	
	}
});
</script>
</head>
<body>

END;
if((!isset($_REQUEST['hash']))and ($_REQUEST['hash']=" "))
{
echo "Требуется регистрация либо авторизация. <br>Для выполнения перейти по <a href='index.php'>ссылке</a>";}
else {
$hash=$_REQUEST['hash'];
$vjbUser=mysql_query("SELECT * FROM user_reg WHERE hash='$hash'");
$Profile= mysql_fetch_assoc($vjbUser);
$user=$Profile[login];
$username=$Profile[user_name];
$UserID=$Profile[User_ID];
$VjbProf=mysql_query("SELECT * FROM user_profile WHERE User_ID='$UserID'");
$UsFeatures= mysql_fetch_assoc($VjbProf);
$HP=$UsFeatures[HP];
$LVL=$UsFeatures[level];
$XP=$UsFeatures[XP];
$attack=$UsFeatures[attack];
$defense=$UsFeatures[defense];
$avoid=$UsFeatures[avoid];
$fortune=$UsFeatures[fortune];
$crit=$UsFeatures[crit];
$resistance=$UsFeatures[resistance];
$vampirism=$UsFeatures[vampirism];
$weakness=$UsFeatures[weakness];
$destruction=$UsFeatures[destruction];
$initiative=$UsFeatures[initiative];
$regeneration=$UsFeatures[regeneration];
$bleeding=$UsFeatures[bleeding];
$speed=$UsFeatures[speed];
}
echo <<<END
	<input id="UserID" type="hidden" value="$UserID">
	<input id="listenerID" type="hidden" value="$UserID">
	<input id="hash" type="hidden" value="$hash">
	<div id="LVLinfo"></div>	
	<div id="XPplus"></div>
END;
echo <<<END
<div id="header">
	<div id="user_pic_contener"><img id='user_pic' src='user.jpg' alt='$user'></div>
	<div id="nickname">$user</div>
	<div id="LVL"></div>
	<div id="But_contener">
		<button class="menu_button" title="Дневник" id="journal_button"><img class="menu_pic" src="journal.jpg"></button>
		<button class="menu_button" title="Снаряжение" id="bag_button"><img class="menu_pic" src="bag.jpg"></button>
		<button class="menu_button" title="Город" id="city_button"><img class="menu_pic" src="city.jpg"></button>
		<button class="menu_button" title="Карта" id="map_button"><img class="menu_pic" src="map.jpg"></button>
	</div>
	<img id='HP_pic' title="количество жизней" src='HP.png'><div title="количество жизней" id="HP_line"><span id="HP"></div>
	<img id='XP_pic' title="количество опыта" src='XP.png'><div title="количество опыта" id="XP_contener"><span id="XP"></div><div title="количество опыта" id="XP_line"></div>
	<img id='activity_pic' title="активность за неделю" src='activity.jpg'><div id="activity_line" title="активность за неделю"><span id="activity"></div>
	<img id='money_pic' title="деньги" src='money.png'><div title="деньги" id="money_line"><span id="money"></div>
	<img id='amber_pic' title="янтарь" src='amber.jpg'><div title="янтарь" id="amber_line"><span id="amber"></div>
	<button id="openrating">Рейтинги</button>
	<a href='index.php'><img id='exit_pic' title="выйти" src='exit.png'></a>
</div>
<div class="main">
	<div class="content_contener" id="journal_cont">
		<div id="profile">
			<div class="profile_page" id="page5"></div>
			<div class="profile_page" id="page4"></div>
			<div class="profile_page" id="page3"></div>
			<div class="profile_page" id="page2"></div>			
			<div class="profile_page" id="page1"></div>
					
			<div class="profile_page divswitch" id="page00">			
				<p class="profile_text">Боевые характеристики:</p>
				<p class="profile_text">Количество игральных кубиков:</p>
				<table class="table_profile" border="1">
					<tr><td><img class="pic_profile" src="attcubepic.jpg"></td><td>Атакующие</td><td id="attcube"></td></tr>
					<tr><td><img class="pic_profile" src="def.jpg"></td><td>Защитные</td><td id="defcube"></td></tr>
				</table>
				<div id="free_skills"></div>
				<p class="profile_text">Основные параметры</p>
				<table class="table_profile" border="1">
					<tr><td><img class="pic_profile" src="att.jpg"></td><td>Атака</td><td id="attack"></td><td class="addskills" ><button class="button_skills" id="attskills">+</button></td></tr>
					<tr><td><img class="pic_profile" src="def.jpg"></td><td>Защита</td><td id="defense"></td><td class="addskills" ><button class="button_skills" id="defskills">+</button></td></tr>
					<tr><td><img class="pic_profile" src='initiative.jpg' title='Инициатива'></td><td>Инициатива</td><td>$initiative</td><td class="addskills"></td></tr>
					<tr><td><img class="pic_profile" src='avoid.jpg' title='Уворот'></td><td>Уворот</td><td>$avoid</td><td class="addskills"></td></tr>
					<tr><td><img class="pic_profile" src='fortune.jpg' title='Удача'></td><td>Удача</td><td>$fortune</td><td class="addskills"></td></tr>
					<tr><td><img class="pic_profile" src='crit.jpg' title='Критический удар'></td><td>Критический удар</td><td>$crit</td><td class="addskills"></td></tr>
					<tr><td><img class="pic_profile" src='resistance.png' title='Стойкость'></td><td>Стойкость</td><td>$resistance</td><td class="addskills"></td></tr>
					<tr><td><img class="pic_profile" src='speed.jpg' title='Скорость передвижения'></td><td>Скорость передвижения</td><td>$speed</td><td class="addskills"></td></tr>
				</table>
				<p class="profile_text">Дополнительные параметры</p>
				<table class="table_profile" border="1">
					<tr><td style="color:red">&#128167</td><td>Вампиризм</td><td>$vampirism</td></tr>
					<tr><td style="color:black">☠</td><td>Ослабление</td><td>$weakness</td></tr>
					<tr><td>💥</td><td>Разрушение</td><td>$destruction</td></tr>				
					<tr><td> ⚕</td><td>Регенерация</td><td>$regeneration</td></tr>
					<tr><td style="color:red">&#128167</td><td>Кровотечение</td><td>$bleeding</td></tr>
				</table>	
			</div>
			<div class="profile_page divswitch" id="page01">
			<div id="message_box">
END;
				$messages=mysql_query("SELECT * FROM messages WHERE addressee_ID='$UserID'");
				while ($Usermessages=mysql_fetch_assoc($messages)){
					$IDSender=$Usermessages[sender_ID];
					$Sender=mysql_query("SELECT * FROM user_reg WHERE User_ID='$IDSender'");
					$checksender=mysql_fetch_assoc($Sender);
					$NickSender=$checksender[login];
					$readsstatus=$Usermessages[readmes];
					$topicmessage=$Usermessages[topic];						
					$messID=$Usermessages[mes_ID];
					$classread='';					
					if ($readsstatus==1) {$classread='noreadhidden';}										
					$datesend = date('d.m.Y',strtotime($Usermessages[date_send]));
					$idmes='readID'.$messID;
				echo "<div class='message_contener' id='$messID'>
						<div class='messagepic' >
							<div class='messagebottom'></div>
							<div class='messagetopnoread'></div>
						</div>
						<div class='messagepicread $classread' id='$idmes'>
							<div class='messagetopread'></div>
						</div>
						<div class='nicksender'>$NickSender</div><div class='datesend'>$datesend</div>
					</div>";
				}
				
echo <<<END
			</div>	
			</div><div class='message_listing divswitch'>
				<div class='messendername'></div>
				
			</div>
			<div class="profile_page divswitch" id="page02">
END;
			$activity =mysql_query("SELECT * FROM user_activity WHERE User_ID='$UserID'");
			$useract = mysql_fetch_assoc($activity);
			$last_week=$useract[last_week];
			$max_day_activity=$useract[max_day_activity];
			$day_activity=$useract[day_activity];
			$week_activity=$useract[week_activity];
			$max_week_activity=$useract[max_week_activity];
			$sum_activity=$useract[sum_activity];		
echo <<<END
			<p class="profile_text">Активность за прошлую неделю </p>
			<div class="activityscore"><img class='activ_pic_profile' src='activity.jpg'>$last_week</div>
			<p class="profile_text">Активность за сегодняшний день </p>
			<div class="activityscore"><img class='activ_pic_profile' src='activity.jpg'>$day_activity</div>
			<p class="profile_text">Активность за эту неделю</p>
			<div class="activityscore"><img class='activ_pic_profile' src='activity.jpg'>$week_activity</div>
			<p class="profile_text">Активность за все время</p>
			<div class="activityscore"><img class='activ_pic_profile' src='activity.jpg'>$sum_activity</div>
			</div>	
			<div class="profile_page divswitch" id="page03">В разработке 2</div>
			<div class="profile_page divswitch" id="page04">В разработке 3</div>
			<div class="profile_page divswitch" id="page05">В разработке 4</div>
			<div class="profile_page divswitch" id="page06">В разработке 5</div>
			<div class="profile_page divswitch" id="page07">победы над мобами
			<table border="1">
END;
				$VjbMobs=mysql_query("SELECT * FROM mobs_bibl");
				while ($mobs= mysql_fetch_assoc($VjbMobs)){
				$countmobs++;
				}
				$countmobs++;
				$VjbFrag=mysql_query("SELECT * FROM user_frag WHERE User_ID='$UserID'");
				$Frag= mysql_fetch_assoc($VjbFrag);
				for ($i=1;$i<$countmobs;$i++) {
					$mobnumber='mob'.$i;
					$VjbMobs=mysql_query("SELECT * FROM mobs_bibl WHERE mob_ID='$i'");
					$mobs= mysql_fetch_assoc($VjbMobs);
					echo "<tr><td><img class='frag_pic' src='$mobs[pic]'</td><td>$Frag[$mobnumber]</td></tr>";
				}
echo <<<END
			</table>
			</div>			
			<div class="profile_page divswitch" id="page08">В разработке 6</div>
			<div id="button_contener">
				<button class="profile_button" id="buttonprof0">Характеристики</button>
				<button class="profile_button" id="buttonprof1">Сообщения</button>
				<button class="profile_button" id="buttonprof2">Активность</button>
				<button class="profile_button" id="buttonprof3">Задания</button>
				<button class="profile_button" id="buttonprof4">Скоро</button>
				<button class="profile_button" id="buttonprof5">Скоро</button>
				<button class="profile_button" id="buttonprof6">Скоро</button>
				<button class="profile_button" id="buttonprof7">Таксидермия</button>
				<button class="profile_button" id="buttonprof8">Профиль</button>
			</div>
		</div>
	</div>
	<div class="content_contener" id="bag_cont">
		<div id="equip">
			<img id="profile_fon" src="bogatjr.jpg">
END;
				$checkequipdress =mysql_query("SELECT * FROM user_equip_dress WHERE User_ID='$UserID'");
				$equipdress = mysql_fetch_assoc($checkequipdress); 				
				if ($equipdress[helmet]<1) {$helmet_pic='';} else {$helmet_pic='item/equip'.$equipdress[helmet].'.jpg';}
				if ($equipdress[necklace]<1) {$necklace_pic='';} else {$necklace_pic='item/equip'.$equipdress[necklace].'.jpg';}
				if ($equipdress[armor]<1) {$armor_pic='';} else {$armor_pic='item/equip'.$equipdress[armor].'.jpg';}
				if ($equipdress[belt]<1) {$belt_pic='';} else {$belt_pic='item/equip'.$equipdress[belt].'.jpg';}
				if ($equipdress[pants]<1) {$pants_pic='';} else {$pants_pic='item/equip'.$equipdress[pants].'.jpg';}
				if ($equipdress[boots]<1) {$boots_pic='';} else {$boots_pic='item/equip'.$equipdress[boots].'.jpg';}
				if ($equipdress[bracelet]<1) {$bracelet_pic='';} else {$bracelet_pic='item/equip'.$equipdress[bracelet].'.jpg';}
				if ($equipdress[weapon]<1) {$weapon_pic='';} else {$weapon_pic='item/equip'.$equipdress[weapon].'.jpg';}
				if ($equipdress[shield]<1) {$shield_pic='';} else {$shield_pic='item/equip'.$equipdress[shield].'.jpg';}
				if ($equipdress[gloves]<1) {$gloves_pic='';} else {$gloves_pic='item/equip'.$equipdress[gloves].'.jpg';}
				if ($equipdress[ring1]<1) {$ring1_pic='';} else {$ring1_pic='item/equip'.$equipdress[ring1].'.jpg';}
				if ($equipdress[ring2]<1) {$ring2_pic='';} else {$ring2_pic='item/equip'.$equipdress[ring2].'.jpg';}
				if ($equipdress[wedding_ring]<1) {$wedding_ring_pic='';} else {$wedding_ring_pic='item/equip'.$equipdress[wedding_ring].'.jpg';}
				
echo <<<END
			<div class="equip_contener helmet">шлем<img class='helmet' id="helmet_pic" src="$helmet_pic"></div>
			<div class="equip_contener necklace">ожерелье<img class='necklace' id="necklace_pic" src="$necklace_pic"></div>
			<div class="equip_contener armor">броня<img class='armor' id="armor_pic" src="$armor_pic"></div>
			<div class="equip_contener belt">пояс<img class='belt' id="belt_pic" src="$belt_pic"></div>
			<div class="equip_contener pants">штаны<img class='pants' id="pants_pic" src="$pants_pic"></div>
			<div class="equip_contener boots">сапоги<img class='boots' id="boots_pic" src="$boots_pic"></div>
			<div class="equip_contener bracelet">браслет<img class='bracelet' id="bracelet_pic" src="$bracelet_pic"></div>
			<div class="equip_contener weapon">оружие<img class='weapon' id="weapon_pic" src="$weapon_pic"></div>
			<div class="equip_contener shield">щит<img class='shield' id="shield_pic" src="$shield_pic"></div>
			<div class="equip_contener gloves">перчатки<img class='gloves' id="gloves_pic" src="$gloves_pic"></div>
			<div class="equip_contener ring1">кольцо<img class='ring1' id="ring1_pic" src="$ring1_pic"></div>
			<div class="equip_contener ring2">кольцо<img class='ring2' id="ring2_pic" src="$ring2_pic"></div>
			<div class="equip_contener wedding_ring">скоро<img class='wedding_ring' id="wedding_ring_pic" src="$wedding_ring_pic"></div>
		</div>
		<div id="cargo_button_contener">
			<button class="cargo_button" id="button_eqiup">Доспехи</button>
			<button class="cargo_button" id="button_resource">Ресурсы</button>
			<button class="cargo_button" id="button_quest">Квестовые</button>
		</div>
		<div class="cargo" id="cargo_eqiup">
END;
	$Equipbibl=mysql_query("SELECT * FROM equipment_bibl");	
	while ($equipcount=mysql_fetch_assoc($Equipbibl)){
		$equipID=$equipcount[Equip_ID];
		$equipPic=$equipcount[equip_pic];
		$equipName=$equipcount[equip_name];	
		$equippurpose=$equipcount[purpose];		
		$HP=$equipcount[HP]; if ($HP>0) {$HP='Жизнь + '.$HP;} else {$HP='';}
		$attack=$equipcount[attack]; if ($attack>0) {$attack='Атака + '.$attack;} else {$attack='';}
		$defense=$equipcount[defense]; if ($defense>0) {$defense='Защита + '.$defense;} else {$defense='';}
		$avoid=$equipcount[avoid]; if ($avoid>0) {$avoid='Уворот + '.$avoid;} else {$avoid='';}
		$fortune=$equipcount[fortune]; if ($fortune>0) {$fortune='Удача + '.$fortune;} else {$fortune='';}
		$crit=$equipcount[crit]; if ($crit>0) {$crit='Критический удар + '.$crit;} else {$crit='';}
		$resistance=$equipcount[resistance]; if ($resistance>0) {$resistance='Стойкость + '.$resistance;} else {$resistance='';}
		$vampirism=$equipcount[vampirism]; if ($vampirism>0) {$vampirism='Вампиризм + '.$vampirism;} else {$vampirism='';}
		$weakness=$equipcount[weakness]; if ($weakness>0) {$weakness='Ослабление + '.$weakness;} else {$weakness='';}
		$destruction=$equipcount[destruction]; if ($destruction>0) {$destruction='Разрушение + '.$destruction;} else {$destruction='';}
		$regeneration=$equipcount[regeneration]; if ($regeneration>0) {$regeneration='Регенерация + '.$regeneration;} else {$regeneration='';}
		$bleeding=$equipcount[bleeding]; if ($bleeding>0) {$bleeding='Кровотечение + '.$bleeding;} else {$bleeding='';}
		$initiative=$equipcount[initiative]; if ($initiative>0) {$initiative='Инициатива + '.$initiative;} else {$initiative='';}
		$speed=$equipcount[speed]; if ($speed>0) {$speed='Скорость + '.$speed;} else {$speed='';}
		$equipproperty=$equipName.$HP.$attack.$defense.$avoid.$fortune.$crit.$resistance.$vampirism.$weakness.$destruction.$regeneration.$bleeding.$initiative.$speed;
		$eID++;		
		$equipuser=mysql_query("SELECT * FROM user_equipment WHERE User_ID='$UserID'");
		$Countequip=mysql_fetch_assoc($equipuser);
		$tableequip='equip'.$eID;		
		$equipmentcounttable=$Countequip[$tableequip];		
		if ($equipmentcounttable<1) {continue;}			
		echo "<div class='cargo_equip' id='$tableequip'><span class='hiddenequipID'>$eID</span><span class='hiddenequippurpose'>$equippurpose</span><img class='equip_pic' 
			title='$equipName\n$HP\n$attack\n$defense\n$avoid\n$fortune\n$crit\n$resistance\n$vampirism\n$weakness\n$destruction\n$regeneration\n$bleeding\n$initiative\n$speed' src='$equipPic'><div class='cargo_count'>$equipmentcounttable</div></div>";
	}	
echo <<<END
		</div>
		<div class="cargo" id="cargo_resource">
END;
	$Resbibl=mysql_query("SELECT * FROM resources_bibl");	
	while ($rescount=mysql_fetch_assoc($Resbibl)){
		$ResID=$rescount[Res_ID];
		$ResPic=$rescount[res_pic];
		$ResName=$rescount[named];
		$rID++;
		$Resuser=mysql_query("SELECT * FROM user_resources WHERE User_ID='$UserID'");
		$CountResource=mysql_fetch_assoc($Resuser);
		$tableres='res'.$rID;
		$resurcecounttable=$CountResource[$tableres];		
		if ($resurcecounttable<1) {continue;}		
		echo "<div class='cargo_item'><img class='res_pic' title='$ResName' src='$ResPic'><div class='cargo_count'>$resurcecounttable</div></div>";
	}			
echo <<<END
		</div>
		<div class="cargo" id="cargo_quest">
			<div class="cargo_item">67<div class="cargo_count">1234</div></div><div class="cargo_item">34</div>
			<div class="cargo_item">34</div><div class="cargo_item">34</div>
			<div class="cargo_item">34</div><div class="cargo_item">34</div>
			<div class="cargo_item">34</div><div class="cargo_item">34</div>
			<div class="cargo_item">34</div><div class="cargo_item">34</div><div class="cargo_item">34</div>
		</div>
	</div>
	<div class="content_contener" id="city_cont">
	<a href="location.php?hash=$hash&loc_ID=9">
	<div class='building_contener'>
		<div class='build_carcas'>
		<div class='signboard'>аукцион</div>
		<div class='build_window'></div>
		<div class='build_door'></div>
		</div></a>
		<div class='build_roof'></div>		
	</div>
	<a href="location.php?hash=$hash&loc_ID=10">
	<div class='building_contener'>
		<div class='build_carcas'>
		<div class='signboard'>магазин</div>
		<div class='build_window'></div>
		<div class='build_door'></div>
		</div></a>
		<div class='build_roof'></div>		
	</div>
END;
	/*if ($UserID==1) {
		echo"<div class='adminmessage'><textarea class='adminmestext'></textarea><button id='admimmesbutton'>отправить</button></div>";
	}*/
echo <<<END
		<div id="loc_contener">
			<span>Пригородные локации<span>
			<div id='signpost'></div>
			
END;
				$vjbLoc=mysql_query("SELECT * FROM loc_bibl WHERE signboard=1");
				while($Location= mysql_fetch_array($vjbLoc)){
				$loc_ID=$Location[loc_ID];
				$loc_name=$Location[loc_name];	
				$loc_pic=$Location[loc_pic];
				$mobcount=$Location[live_mobs];
				$mobID=$Location[mob_ID];
				$checkmobs=mysql_query("SELECT * FROM mobs_bibl WHERE mob_ID='$mobID'");
				$mobcheck=mysql_fetch_array($checkmobs);
				$mobname=$mobcheck[title];
				$mobpic=$mobcheck[pic];
				$rotateloccont++;
				$IDloc_cont='rotateloccont'.$rotateloccont;
echo <<<END
				<a href="location.php?hash=$hash&loc_ID=$loc_ID">
				<div class='gotoloccontener' id='$IDloc_cont'>
					<img class='gotoloc' src='$loc_pic' alt='$loc_name' title='$loc_name'>
					<div class='countmobsinloc' title='живых мобов' >$mobcount</div>
					<img class='mobsinlocpic' src='$mobpic' alt='$mobname' title='$mobname'>
				</div></a>			
END;
			}
echo <<<END
		</div>
	</div>
	<div class="content_contener" id="map_cont">
		<div class='city_wall'>
			<div class='city_wall2'></div>
			<div class='city_wall3'></div>
		</div>
		
	</div>
	<div class="content_contener" id="userrating"><span id="titleactivityraiting">Рейтинг недельной активности</span>
		<div id="activityraiting">
END;
		$checkactivity=mysql_query("SELECT * FROM user_activity ORDER BY last_week DESC");
		while($useractivity= mysql_fetch_array($checkactivity)){
			$actreit++;
			$Useractiv=$useractivity[User_ID];
			$checkuser=mysql_query("SELECT * FROM user_reg WHERE User_ID='$Useractiv'");
			$Userrait= mysql_fetch_assoc($checkuser);
			$checkuserlvl=mysql_query("SELECT * FROM user_profile WHERE User_ID='$Useractiv'");
			$Userraitlvl= mysql_fetch_assoc($checkuserlvl);
			$Username=$Userrait[login];
			$UserLVLrait=$Userraitlvl[level];
			$Scoreactiv=$useractivity[last_week];
			if ($Scoreactiv<1) {continue;}
			echo "<div class='place' title='Позиция'>$actreit</div><div class='LVLRait' title='Уровень'>$UserLVLrait</div><div class='useractiv' title='Ник'><span class='nickrait'>$Username</span></div><div class='score' title='Очки активности'>$Scoreactiv</div>";
		}
echo <<<END
		</div><span id="titleXPrating">Рейтинг по набранному опыту</span>
		<div id="XPrating">
		
END;
	$checkXP=mysql_query("SELECT * FROM user_profile ORDER BY XP DESC");
		while($userXP= mysql_fetch_array($checkXP)){
			$XPreit++;
			$UserXP=$userXP[User_ID];
			$UserLVLrait=$userXP[level];
			$checkuser=mysql_query("SELECT * FROM user_reg WHERE User_ID='$UserXP'");
			$Userrait= mysql_fetch_assoc($checkuser);
			$Username=$Userrait[login];
			$Scoreactiv=$userXP[XP];
			if ($Scoreactiv<1) {break;}
			echo "<div class='place placeblue' title='Позиция'>$XPreit</div><div class='LVLRait LVLRaitblue' title='Уровень'>$UserLVLrait</div><div class='useractiv useractivblue' title='Ник'><span class='nickrait'>$Username</span></div><div class='score scoreblue' title='Очки опыта'>$Scoreactiv</div>";
		}	
echo <<<END
		</div>
		<button title="закрыть" id="closerating">x</button>
	</div>	
</div>
END;
?>