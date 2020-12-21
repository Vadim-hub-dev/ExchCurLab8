<?php
require "../db.php"; // подключаем файл для соединения с БД

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Авторизоваться" и код начинает выполняться
if(isset($data['do_login']))
{

	// Создаем массив для сбора ошибок
	$errors = array();

	// Проводим поиск пользователей в таблице users
	//$user = R::findOne('users', 'login = ?', array($data['login']));

	$user = mysqli_query($link, "SELECT * FROM users WHERE login = '$data[login]' LIMIT 1");

	if($user)
	{
		$row = mysqli_fetch_array($user);
		// Если логин существует, тогда проверяем пароль
		if(password_verify($data['password'], $row['password']))
		{
			session_start();
			$_SESSION['auth'] = $row['id'];
			// Все верно, пускаем пользователя

			if(isset($data['remember']))
			{
				//Сформируем случайную строку для куки ():
				$salt = '';
				$saltLength = 8; //длина соли
				for($i=0; $i<$saltLength; $i++)
				{
					$salt .= chr(mt_rand(33,126)); //символ из ASCII-table
				}
				$key = $salt; //назовем ее $key

				//Пишем куки (имя куки, значение, время жизни - сейчас+месяц)
				setcookie('login', $row['login'], time()+60*60*24*30); //логин
				setcookie('key', $key, time()+60*60*24*30); //случайная строка

				//Пишем эту же куку в базу данных для данного юзера.
				//Сохраняем значение куки в БД
				$row['cookie'] = $key;
				mysqli_query($link, "UPDATE users SET cookie = '$row[cookie]' WHERE login = '$row[login]'");
			}

			// Редирект на главную страницу
			header('Location: /www/intro.php');

		} else
		{
			$errors[] = 'Пароль неверно введен!';
		}
	} else
	{
		$errors[] = 'Пользователь с таким логином не найден!';
	}

	if(!empty($errors))
	{
		$result = '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Форма авторизации</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta content="text/html; charset=utf-8">
</head>
<body>

<?=$result?>

<main>
<div class="container mt-4">
<div class="row">
	<div class="col">
<h2>Форма авторизации</h2>
<form action="login.php" method="post">
	<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
	<input type="password" class="form-control" name="password" id="pass" placeholder="Введите пароль" required><br>
	<label><input name='remember' type='checkbox'>Запомнить меня</label><br>
	<button class="btn btn-secondary" name="do_login" type="submit">Авторизоваться</button>
</form>
<br>
<p>Если вы еще не зарегистрированы, тогда нажмите <a href="signup.php" data-ajax="1">здесь</a>.</p>
<p>Вернуться на <a href="./intro.php" data-ajax="1">главную</a>.</p>
	</div>
</div>
</div>
</main>

</body>
</html>
