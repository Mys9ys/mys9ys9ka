<?
include("db.php");
require_once("battlefunc.php");
$hash=$_REQUEST['hash'];
$mob_ID=$_REQUEST['mob_ID'];
$loc_ID=$_REQUEST['loc_ID'];
$vjbUser=mysql_query("SELECT * FROM user_reg WHERE hash='$hash'");
$Profile= mysql_fetch_assoc($vjbUser);
$UserID=$Profile[User_ID]; 
$vjbMob=mysql_query("SELECT * FROM mobs_bibl WHERE mob_ID='$mob_ID'");
$Mobs= mysql_fetch_assoc($vjbMob);
$mob_pic=$Mobs[pic];
echo <<<END
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Style.css" />
	<title>Новый мир</title>
</head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>	
$(document).ready(function() {  	
   $.ajax({
    url: "ajaxuser.php",
    type: "POST",
    dataType: "json",
    data: ("User_ID="+$("#UserID").val()),
    success: function(json){	
    $("#WarNick1").text(json.Warrior['login']);		
	$("#WarLVL1").text(json.Warrior['level']);
	$("#initiativewar1").text(json.Warrior['initiative']);	
	$("#attackwar1").text(json.Warrior['attack']);
	$("#defensewar1").text(json.Warrior['defense']);
	$("#avoidwar1").text(json.Warrior['avoid']);
	$("#fortunewar1").text(json.Warrior['fortune']);
	$("#critwar1").text(json.Warrior['crit']);
	$("#resistancewar1").text(json.Warrior['resistance']);	
	$("#attcube1").text(json.Warrior['cube_att']);
	$("#defcube1").text(json.Warrior['cube_def']);
	$("#HP1count").text(json.Warrior['HP']);
    }
}); 
	$.ajax({
    url: "ajaxmob.php",
    type: "POST",
    dataType: "json",
    data: ("mob_ID="+$("#MobID").val()),
    success: function(json){
    $("#WarNick2").text(json.Mob['title']);	
	$("#WarLVL2").text(json.Mob['level']);	
	$("#initiativewar2").text(json.Mob['initiative']);
	$("#attackwar2").text(json.Mob['attack']);
	$("#defensewar2").text(json.Mob['defense']);
	$("#avoidwar2").text(json.Mob['avoid']);
	$("#fortunewar2").text(json.Mob['fortune']);
	$("#critwar2").text(json.Mob['crit']);
	$("#resistancewar2").text(json.Mob['resistance']);		
	$("#war2pic").attr('src',json.Mob['pic']);	
	$("#attcube2").text(json.Mob['cube_att']);
	$("#defcube2").text(json.Mob['cube_def']);
	$("#HP2count").text(json.Mob['HP']);
	$("#XPcount").text(json.Mob['win_XP']);
	$("#loot_ID1").text(json.Mob['loot_ID1']);
	$("#odds1").text(json.Mob['odds1']);
	$("#loot_ID2").text(json.Mob['loot_ID2']);
	$("#odds2").text(json.Mob['odds2']);
	$("#loot_ID3").text(json.Mob['loot_ID3']);
	$("#odds3").text(json.Mob['odds3']);
    }
});  
});
intervalBattle();
	var int;
	//запуск битвы
	function battle(){
		var HP1battle=$("#HP1count").text();
		var HP2battle=$("#HP2count").text();
		$("#HP1battle").text(HP1battle);
		$("#HP2battle").text(HP2battle);
		var initiativewar1=$("#initiativewar1").text();
		var initiativewar2=$("#initiativewar2").text();
			//проверка инициативы
		if (initiativewar1>initiativewar2) {
			udar(1);		
		}	else {
		if (initiativewar1<initiativewar2) {
			udar(2);		
		} else { 		
		var randinitiative =randcount(2,0);		
		if (randinitiative==0) {udar(1); }
		if (randinitiative==1) {udar(2); }
			}
		}
	} 
	//таймаут после загрузки данных из аякс
	function intervalBattle(){
		setTimeout("battle()", 1500);
};
	function udar(attaker){
	$('.cube_contener div').remove();	
	if (attaker==1) { defender=2;}
	if (attaker==2) { defender=1;}
	var concatattaker='#attcube'+attaker;
	var concatdefender='#defcube'+defender;	
	var attcube = $(concatattaker).text();
	var defcube= $(concatdefender).text();
	var suma=0;
	var conteneratt ='#attcube'+attaker+'pic';	
	$(conteneratt).append('<div class="cube"><img class="cubepic" src="attcubepic.jpg"></div>');
			//атакующие кубики (генерация)
	for (j=0;j<attcube;j++)
	{
		var randcube=cube();
		var point='';
		for (i=0; i<randcube; i++){ 
		point=point+"<div class='point' id='cube"+randcube+i+"'></div>";		 
		var prov="cube"+randcube+i;		
		}			
		suma=suma+randcube;
		randcube="<div class='cube'>"+point+"</div>";
		var conteneratt ='#attcube'+attaker+'pic';	
		$(conteneratt).append(randcube);
	}
	var poweratt ='#attackwar'+attaker;
	var attskills=$(poweratt).text();
	sumaskills=suma+Math.floor(attskills);
	var attfraza= '#fraza'+attaker;
	var frazaa ='атака с силой:'+suma+'+'+Math.floor(attskills);
	$(attfraza).text(frazaa);	
		var sumd=0;
		var contenerdef ='#defcube'+defender+'pic';	
		$(contenerdef).append('<div class="cube"><img class="cubepic" src="def.jpg"></div>');
			//защитные кубики (генерация)
	for (d=0;d<defcube;d++)
	{
		var randcube=cube();
		var point='';
		for (i=0; i<randcube; i++){ 
		point=point+"<div class='point' id='cube"+randcube+i+"'></div>";		 
		var prov="cube"+randcube+i;		
		}	
		sumd=sumd+randcube;		
		randcube="<div class='cube'>"+point+"</div>";		
		$(contenerdef).append(randcube);
	}
	var powerdef ='#defensewar'+defender;
	var defskills=$(powerdef).text();
	sumdskills=sumd+Math.floor(defskills);
	var deffraza= '#fraza'+defender;
	var frazad ='защита с силой:'+sumd+'+'+Math.floor(defskills);
	$(deffraza).text(frazad);
	//$("#proverka").append(concatdefender,defcube);
	//вычисление урона
	var uron = sumaskills-sumdskills;
	var warrior1 = '#WarNick'+attaker;
	var nick1= $(warrior1).text();
	var warrior2 = '#WarNick'+defender;
	var nick2= $(warrior2).text();
	if (uron<0) { uron=0;}
	var cotenerdefHP ='#HP'+defender+'battle';
	var defHP=$(cotenerdefHP).text();
	//завершение боя
	if (uron>=defHP) { 
		uron=defHP; 
		$("#battlelog").append(nick1,' победил ',nick2,' нанеся ',uron,' урона \\n');
		defHP=defHP-uron;
		$(cotenerdefHP).text(defHP);
		var HPline= '#HP'+defender+'line';
		$(HPline).width(0);
		var userHP= $("#HP1battle").text();		
		if (userHP==0) {
			$('#exitbattle').append('<div class="battlemessage"> Увы, Вы проиграли...</div>');
			// добавление количества битв
			$.ajax({
				url: "ajaxuser.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $("#UserID").val(),BattleLose: '1'}
			});			
		}		
		if (userHP>0) {
			$('#exitbattle').append('<div class="battlemessage">Вы выйграли!!!<br></div>');
			var XPwin=$("#XPcount").text();
			
			$('#exitbattle').append('<div class="battlemessage2">получаете '+XPwin+' опыта</div>');
			//добавление лута
			var loot_ID1=$("#loot_ID1").text();
			var odds1=$("#odds1").text();
			var odds1rand=randcount(100,1);
			if (odds1rand<=odds1) { 
				var UserID=$("#UserID").val();
				var loot_ID=$("#loot_ID1").text();
				checkloot(UserID,loot_ID);
				$('.battlemessage3').append('<span class="lootmessage">выпало 1: </span><img class="battleloot" src="resource/loot'+loot_ID+'.jpg">');			
				}
			var loot_ID2=$("#loot_ID2").text();
			var odds2=$("#odds2").text();
			var odds2rand=randcount(100,1);
			if (odds2rand<=odds2) { 
				var UserID=$("#UserID").val();
				var loot_ID=$("#loot_ID2").text();
				checkloot(UserID,loot_ID);
				$('.battlemessage3').append('<span class="lootmessage">выпало 1: </span><img class="battleloot" src="resource/loot'+loot_ID+'.jpg">');
				}
			var loot_ID3=$("#loot_ID3").text();
			var odds3=$("#odds3").text();
			var odds3rand=randcount(100,1);
			if (odds3rand<=odds3) { var Loot3=1;}			
			// добавление опыта и количества битв
			$.ajax({
				url: "ajaxuser.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $("#UserID").val(),XP: XPwin}
				});
			//убийство моба и его исключение со страницы локации и запись фрага в таблицу фрагов
			$.ajax({
				url: "ajaxmob.php",
				type: "POST",
				dataType: "json",
				data: {loc_ID: $("#LocationID").text(),User_ID: $("#UserID").val(),mob_ID: $("#MobID").val()}
				});							
			}
		$('#exitbattle').css({"display":"block"});
		$('#notendbattleexit').css({"display":"none"});
		return;}	
	defHP=defHP-uron;
	$(cotenerdefHP).text(defHP);
	var contenerdefHPmax ='#HP'+defender+'count';
	var defHPmax=$(contenerdefHPmax).text();
	var HPprocent =Math.floor((defHP/defHPmax)*172);
	var HPline= '#HP'+defender+'line';	
	$(HPline).width(HPprocent);
	$("#battlelog").append(nick1,' нанес ',uron,' урона ',nick2,'\\n');
	if (attaker==1) { attaker=2; } else {
	if (attaker==2) { attaker=1; } }	
	var interval = setTimeout( function() {udar(attaker)}, 2000);
	$("#proverka").append(attaker,'hp',HPline,greenline);
	}
	function cube(){
		var countcube=randcount(6,1);		
		return countcube;		
	}
	function randcount(param1,param2) {
	var rcount=Math.floor((Math.random()*param1)+param2);
	return rcount;
	}	
	function checkloot(UserID,loot_ID) {
		$.ajax({
			url: "resandloot.php",
			type: "POST",
			dataType: "json",
			data: {User_ID: UserID,resID: loot_ID}
			});
	}
</script>
<body> 
<div id="battle_contener">
	<div id="Warrior1">
		<div id="WarNick1"></div>
		<div id="WarLVL1"></div>		
		<input id="UserID" type="hidden" value="$UserID">
		<img id="war1pic" src='user.jpg'>
		<img class="statpic1" id="initiativepic" src='initiative.jpg' title='Инициатива'><div class="stat1" id="initiativewar1" title='Инициатива'></div>
		<img class="statpic1" id="attackpic" src='att.jpg' title='Атака'><div class="stat1" id="attackwar1" title='Атака'></div>
		<img class="statpic1" id="defensepic" src='def.jpg' title='Защита'><div class="stat1" id="defensewar1" title='Защита'></div>
		<img class="statpic1" id="avoidpic" src='avoid.jpg' title='Уворот'><div class="stat1" id="avoidwar1" title='Уворот'></div>
		<img class="statpic1" id="fortunepic" src='fortune.jpg' title='Удача'><div class="stat1" id="fortunewar1" title='Удача'></div>
		<img class="statpic1" id="critpic" src='crit.jpg' title='Критический удар'><div class="stat1" id="critwar1" title='Критический удар'></div>
		<img class="statpic1" id="resistancepic" src='resistance.png' title='Стойкость'><div class="stat1" id="resistancewar1" title='Стойкость'></div>		
		<img id='HP_picBattle1' src='HP.png'><div class="HP" id="HP1"><span id="HP1battle"></span>/<span id="HP1count"></span></div><div id="HP1line"></div>
		<div class="cube_contener" id="attcube1pic"><span id="attcube1"></span></div><span class="fraza" id="fraza1"></span>
		<div class="baf_contener" id="baf1"></div>	
		<div class="cube_contener" id="defcube1pic"><span id="defcube1"></span></div>		
	</div>
	<a href="location.php?hash=$hash&loc_ID=$loc_ID"><button id='notendbattleexit'>Выйти из боя досрочно</button></a>
	<textarea id="battlelog"></textarea>
	<div id="lvlupmessage"></div>
	<div id="Warrior2">
		<div id="WarNick2"></div>
		<div id="WarLVL2"></div>
		<input id="MobID" type="hidden" value="$mob_ID">
		<img id="war2pic" src=''>
		<img class="statpic2" id="initiativepic" src='initiative.jpg' title='Инициатива'><div class="stat2" id="initiativewar2" title='Инициатива'></div>
		<img class="statpic2" id="attackpic" src='att.jpg' title='Атака'><div class="stat2" id="attackwar2" title='Атака'></div>
		<img class="statpic2" id="defensepic" src='def.jpg' title='Защита'><div class="stat2" id="defensewar2" title='Защита'></div>
		<img class="statpic2" id="avoidpic" src='avoid.jpg' title='Уворот'><div class="stat2" id="avoidwar2" title='Уворот'></div>
		<img class="statpic2" id="fortunepic" src='fortune.jpg' title='Удача'><div class="stat2" id="fortunewar2" title='Удача'></div>
		<img class="statpic2" id="critpic" src='crit.jpg' title='Критический удар'><div class="stat2" id="critwar2" title='Критический удар'></div>
		<img class="statpic2" id="resistancepic" src='resistance.png' title='Стойкость'><div class="stat2" id="resistancewar2" title='Стойкость'></div>	
		<img id='HP_picBattle2' src='HP.png'><div class="HP" id="HP2"><span id="HP2battle"></span>/<span id="HP2count"></span></div><div id="HP2line"></div>
		<div class="cube_contener" id="attcube2pic"><span id="attcube2"></span></div><span class="fraza" id="fraza2"></span>
		<div class="baf_contener" id="baf2"></div>
		<div class="cube_contener" id="defcube2pic"><span id="defcube2"></span></div>
		<div id="XPcount"></div>
		<div id="LocationID">$loc_ID</div>
		<div class='loothidden' id="loot_ID1"></div><div class='loothidden' id="odds1"></div>
		<div class='loothidden' id="loot_ID2"></div><div class='loothidden' id="odds2"></div>
		<div class='loothidden' id="loot_ID3"></div><div class='loothidden' id="odds3"></div>
	</div>
	<div id="exitbattle"><div class="battlemessage3"></div><a class="button" id="button1" href="location.php?hash=$hash&loc_ID=$loc_ID">Вернуться</a>
		<a class="button" id="button2" href="profile.php?hash=$hash">В профиль</a>
	</div>
</div>


END;
//<div id='proverka' style="border: 3px outset purple; height:25px;">25</div>



