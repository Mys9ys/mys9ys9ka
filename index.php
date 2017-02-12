<?
echo <<<END
<html>
<head>
	<link rel="stylesheet" type="text/css" href="Style.css" />	
	<title>Возрождение Гипербореи</title>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script> 
$(function(){
    $('.join').click(function(){
		$('.reg').css("display", "none");
         $('#login').css("display", "block");
        return false;
    });
}); 
$(function(){
    $('.regstr').click(function(){
         $('.reg').css("display", "block");
		 $('#login').css("display", "none");
        return false;
    });
}); 
</script> 
END;
$code=$_REQUEST['code'];
if($code==1){
echo "такая почта уже используется!";}
if($code==2){
echo "такой пользователь уже существует!";}
if($code==3){
echo "Неверный псевдоним либо пароль";}
echo <<<END
</head>
<body>
<div id="hello_message"><marquee>Добро пожаловать в он-лайн игру "Возрождение Гипербореи!!!" (Beta-test)</marquee></div>
<div id="hello"><img id ="logpic" src="logpic.jpg">
<button id="doorway" class="join">Войти</button><button id="registration" class="regstr">Впервые в игре</button>
<div id="login">
	<form action="login.php" name="test" method="POST">	
	Псевдоним<br>
	<input type="text" name="user"/><br>
	Пароль<br>
	<input type="password" name="password"/><br>
	<input type="submit" value="Войти"/></form>
</div>
	
<div id="reg" class="reg">
	<form action="registration.php" name="test" method="POST">		
	Псевдоним (латинскими буквами)<br>
	<input type="text" name="user"/><br>	
	Пароль<br>
	<input type="password" name="password"/><br>
	Ваше имя<br>
	<input type="text" name="user_name"/><br>
	Пол<br>
	<input type="radio" name="gender" value="male" checked> Мужской<br>
	<input type="radio" name="gender" value="female" > Женский<br>
	Дата рождения (для получения бонусов в это время)<br>
	<input type="date" name="birthday"><br>
	Почта для напоминания пароля<br>
	<input type="email" name="email"><br>	
	<input type="submit" value="зарегистироваться"/></form>
</div>
</div>
<br> версия 6.3<br>
Что нового:<br>
- Прошла некоторая руссификация<br>
- Заработал магазин экипировки <br>
- Можно углубиться в лес и выхватить там не хилых...))))<br>

</body>
</html>
END;
?>