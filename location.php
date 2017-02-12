<?
include("db.php");
require_once("battlefunc.php");
$hash=$_REQUEST['hash'];
$loc_ID=$_REQUEST['loc_ID'];
$vjbUser=mysql_query("SELECT * FROM user_reg WHERE hash='$hash'");
$Profile= mysql_fetch_assoc($vjbUser);
$user=$Profile[login];
$userID=$Profile[User_ID];
$vjbLoc=mysql_query("SELECT * FROM loc_bibl WHERE loc_ID='$loc_ID'");
$Location= mysql_fetch_assoc($vjbLoc);
$loc_name=$Location[loc_name];
$loc_pic=$Location[loc_pic];
$loc_work=$Location[work];
$shop=$Location[shop];
$mobs_reg=mobs_regen();
echo <<<END
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Style.css" />
	<title>$loc_name</title>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script type='text/javascript' src='userlistener.js'></script>
	<script>
	//начало работы
$(function(){
$('.work_contener').bind('click', function(){
	var id = $(this).attr('id');	
	var checkselector ='#'+id+' .workspecialty';
	var workspecialty = $(checkselector).text();
	var checkselector ='#'+id+' .workresID';
	var workresID = $(checkselector).text();		
	var checkselector ='#'+id+' .worktime span';
	var worktime = $(checkselector).text();
	var checkselector ='#'+id+' .workcountres span';	
	var workcountres = $(checkselector).text();	
	var checkselector ='#'+id+' .workname';
	var workname = $(checkselector).text();
	workstart(workspecialty,workresID,worktime,workcountres,workname);
});
});
function workstart(workspecialty,workresID,worktime,workcountres,workname){				
	$.ajax({
		url: "resandloot.php",
		type: "POST",
		dataType: "json",
		data: {User_ID: $('#UserID').text(),locID:$('#locID').val(),workID:$('#workID').val(),workspecialty: workspecialty,workresID: workresID,worktime: worktime,workcountres: workcountres}
	});
	$('.work_contener').css("display", "none");	
	$('.employment_fon').css("display", "block");
	$('.employment_contener').css("display", "block");
	$('#workname').text(workname);
	workfunc(worktime,workcountres);
}
function workfunc(worktime,countres){		
	var seconds = widthmax= worktime*60;	
	var	widthcount = 0;
	var timeinterval = setInterval(function(){
		//досрочное завершение работы
		$(function(){
			$('#button_stop_work').click(function(){
			clearInterval(timeinterval);
			$("#worktime_line").css("width",0);
			$('.wtime').text('00:00:00');
				$.ajax({
					url: "resandloot.php",
					type: "POST",
					dataType: "json",
					data: {User_ID: $('#UserID').text(),stopwork: '1'}
				});
			$('.work_contener').css("display", "block");	
			$('.employment_fon').css("display", "none");
			$('.employment_contener').css("display", "none");	
			});	
		});			
		widthcount++;
		var workline = widthcount*300/widthmax;
		$("#worktime_line").css("width",workline);	
		seconds--;
		var sec= Math.floor(seconds%60);
		if (sec<10) {sec='0'+sec;}
		var min= Math.floor(seconds/60);
		if (min>60) {min= Math.floor(min%60);}
		if (min<10) {min='0'+min;}
		var hour =Math.floor(seconds/3600);
		if (hour<10) {hour='0'+hour;}
		var wtime = hour+':'+min+':'+sec;
		$('.wtime').text(wtime);	
		if(seconds<=-1){
			$('.employment_contener').css("display", "none");
			$('.end_work_cont').css("display", "block");
			$('.end_work_count_res span').text(countres);
			$.ajax({
				url: "resandloot.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $('#UserID').text(),workcomplite: 1}
			});
		clearInterval(timeinterval);
		}	
	},1000);
}
$(function(){
$('#button_end_work').click(function(){	
	$('.work_contener').css("display", "block");
	$('.employment_fon').css("display", "none");
	$('.end_work_cont').css("display", "none");
	$("#worktime_line").css("width",0);
	$('.wtime').text('00:00:00');
});
});
$(function(){
$('.shop_box').click(function(){	
	var money = $('.shop_contaner').attr('id');	
	var idcount = '#'+$(this).attr('id')+' #count_shop';
	var count_equip = $(idcount).text();
	if (count_equip<1) {
	alert('Товар закончился');
	} else {
		if (money<10) {
		alert('Недостаточно средств');
		} else {
			var id = $(this).attr('id');			
			$.ajax({
				url: "equipchange.php",
				type: "POST",
				dataType: "json",
				data: {User_ID: $('#UserID').text(),Shop_ID: id}
			});
			money=money-10;
			count_equip=count_equip-1;
			$('.shop_contaner').attr({'id': money});
			$(idcount).text(count_equip);		
		} 
	}
});
});
</script>
</head>
<body>
END;
echo <<<END
<div class='location_box'>
	<div class='loc_name'>$loc_name</div><div id='UserID'>$userID</div><input id="listenerID" type="hidden" value="$UserID">
	<input id="locID" type="hidden" value="$loc_ID"><input id="workID" type="hidden" value="$loc_work">	
	<div class='loc_exit'><a href="profile.php?hash=$hash">Вернуться в профиль</a><br></div>
	<div id="location_contaner"><img id='loc_pic' src='$loc_pic' >
END;
	$locmobs=$Location[live_mobs];
	$mob_ID=$Location[mob_ID];
	$vjbMob=mysql_query("SELECT * FROM mobs_bibl WHERE mob_ID='$mob_ID'");
	$Mobs= mysql_fetch_assoc($vjbMob);
	$mob_pic=$Mobs[pic];
	$mob_name=$Mobs[title];
	$x=15; $y=40;
	for ($i=0; $i<$locmobs; $i++){
		if ($i>0) {$x=$x+65; } if ($x>460) { $x=15; $y=$y+65;}
		echo "<div class='mobs_div' style=' left:$x; bottom:$y'>
			<a href='battle.php?hash=$hash&mob_ID=$mob_ID&loc_ID=$loc_ID'>
			<img class='mobs_pic' src='$mob_pic' alt='$mob_name' title='$mob_name'></a>
		</div>";
	}
	echo "</div>";
	if ($shop>0) {
		$checkmoney=mysql_query("SELECT * FROM user_money WHERE User_ID='$userID'");	
		$usermoney=mysql_fetch_assoc($checkmoney);
		$checkUserMoney=$usermoney[money];		
		echo "<div class='shop_contaner' id='$checkUserMoney'>";
		$checkshop=mysql_query("SELECT * FROM magazin");
		while ($shops=mysql_fetch_assoc($checkshop)){
			$Shopnumber++;
			$ShopID='ID'.$Shopnumber;
			$EquipID=$shops[Equip_ID];			
			$EquipCount=$shops[count_item];
			$EquipPrice=$shops[price];
			$Equipbibl=mysql_query("SELECT * FROM equipment_bibl WHERE Equip_ID='$EquipID'");	
			$Equips=mysql_fetch_assoc($Equipbibl);
			$Equip_pic=$Equips[equip_pic];
			$Equip_name=$Equips[equip_name];
			echo "<div class='shop_box' id='$EquipID'>
				<img id='equip_shop' src='$Equip_pic' title='$Equip_name'>
				<div id='count_shop' title='Количество'>$EquipCount</div><span id='shop_count_text'>шт.</span>
				<div id='price_shop' title='Стоимость'>$EquipPrice</div>
				<button class='button_shop' id='$ShopID'>Купить</button>
				</div>";
		}
		echo "</div>";
	}
	if ($loc_work>0) {
		for($factor=0;$factor<3;$factor++){
			if ($factor==0) {$countw=1; $workfactor='workcountID'.$countw;}
			if ($factor==1) {$countw=4; $workfactor='workcountID'.$countw;}
			if ($factor==2) {$countw=16; $workfactor='workcountID'.$countw;}
			$checkwork=mysql_query("SELECT * FROM works_bibl WHERE work_ID='$loc_work'");
			$works= mysql_fetch_assoc($checkwork);
			$workname=$works[name];
			$worktime=$works[work_time]*$countw;
			$workresourceID=$works[work_resource];
			$workspecialty=$works[work_specialty];
			$workcount=$works[count_res]*$countw;
			$checkworkresource=mysql_query("SELECT * FROM resources_bibl WHERE Res_ID='$workresourceID'");
			$resourcework= mysql_fetch_assoc($checkworkresource);
			$workrespic=$resourcework[res_pic];
			echo "<div class='work_contener' id='$workfactor'>
				<div class='workname'>$workname</div>
				<div class='workresID'>$workresourceID</div>
				<div class='workspecialty'>$workspecialty</div>
				<div class='worktime'><span>$worktime</span> минут</div>
				<div class='workcountres'>x<span>$workcount</span></div>
				<div class='workresource'><img class='workrespic' src='$workrespic'></div>
			</div>";
		}
	}
	$Checkdeep=mysql_query("SELECT * FROM loc_bibl WHERE loc_ID='$loc_ID'");
	$Locationdeep= mysql_fetch_array($Checkdeep);
	$deep=$Locationdeep[deep];
	if ($deep>0) {
	$vjbLoc=mysql_query("SELECT * FROM loc_bibl WHERE loc_ID='$deep'");
	$Location= mysql_fetch_array($vjbLoc);
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
	<a href="location.php?hash=$hash&loc_ID=$deep">
	<div class='gotoloccontener deeploc' id='$IDloc_cont'><div id='title_deep'>Пойти дальше</div>
	<img class='gotoloc' src='$loc_pic' alt='$loc_name' title='$loc_name'>
	<div class='countmobsinloc' title='живых мобов' >$mobcount</div>
	<img class='mobsinlocpic' src='$mobpic' alt='$mobname' title='$mobname'>
	</div></a>			
END;
}
echo <<<end
	<div class='employment_fon'></div>
	<div class='employment_contener'>
		<span>Вы начали работу:</span>
		<span id='workname'></span>
		<div id='worktime_cont'><div id='worktime_line'></div><div class='wtime'>00:00:00</div></div>
		<button id='button_stop_work'>Отменить работу</button>		
	</div>
	<div class='end_work_cont'>
		<span>Выполнив работу, Вы получаете:</span>
		<div class='end_work_count_res'><span></span><img class='end_work_pic_res workrespic' src='$workrespic'></div>
		<button id='button_end_work'>Завершить</button>
	</div>
</div>
end;
?>