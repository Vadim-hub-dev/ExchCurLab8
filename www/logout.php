<?php

session_start();
require "../db.php"; // подключаем файл для соединения с БД

mysqli_close($link);

// Производим выход пользователя
if (!empty($_SESSION['auth']) and $_SESSION['auth'])
{
	 session_destroy(); //разрушаем сессию для пользователя

	 //Удаляем куки авторизации путем установления времени их жизни на текущий момент:
	 setcookie('login', '', time()); //удаляем логин
	 setcookie('key', '', time()); //удаляем ключ
}

// Редирект на главную страницу
header('Location: /www/intro.php');

 ?>
