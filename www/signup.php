<?php
require "../db.php";
require "../libs/rb-mysql.php"; // подключаем файл для соединения с БД
R::setup( 'mysql:host=localhost;dbname=register','root', 'root' );
session_start();

// Создаем переменную для сбора данных от пользователя по методу POST
$data = $_POST;

// Пользователь нажимает на кнопку "Зарегистрировать" и код начинает выполняться
if(isset($data['do_signup']))
{

        // Регистрируем
        // Создаем массив для сбора ошибок
	$errors = array();

	// Проводим проверки
        // trim — удаляет пробелы (или другие символы) из начала и конца строки
	if(trim($data['login']) == '')
	{

		$errors[] = "Введите логин!";
	}

	if(trim($data['email']) == '')
	{

		$errors[] = "Введите Email";
	}


	if(trim($data['name']) == '')
	{

		$errors[] = "Введите Имя";
	}

	if(trim($data['family']) == '')
	{

		$errors[] = "Введите фамилию";
	}

	if($data['password'] == '')
	{

		$errors[] = "Введите пароль";
	}

	if($data['password_2'] != $data['password'])
	{

		$errors[] = "Повторный пароль введен не верно!";
	}
         // функция mb_strlen - получает длину строки
        // Если логин будет меньше 5 символов и больше 50, то выйдет ошибка
	if(mb_strlen($data['login']) < 5 || mb_strlen($data['login']) > 50)
	{

	    $errors[] = "Недопустимая длина логина";

    }

    if (mb_strlen($data['name']) < 2 || mb_strlen($data['name']) > 30)
	{

	    $errors[] = "Недопустимая длина имени";

    }

    if (mb_strlen($data['family']) < 5 || mb_strlen($data['family']) > 30)
	{

	    $errors[] = "Недопустимая длина фамилии";

    }

    if (mb_strlen($data['password']) < 2 || mb_strlen($data['password']) > 10)
	{

	    $errors[] = "Недопустимая длина пароля (от 2 до 10 символов)";

    }

    // проверка на правильность написания Email
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $data['email'])) //смотрим чтоб логин соотвествовал некому шаблону : login@mail.ru
	{

	    $errors[] = 'Неверно введен е-mail';

    }

	// Проверка на уникальность логина
	if(R::count('users', "login = ?", array($data['login'])) > 0) //если количество пользователей с таким логином больше 0, то уже зарегестрирован такой логин
	{

		$errors[] = "Пользователь с таким логином существует!";
	}

	// Проверка на уникальность email

	if(R::count('users', "email = ?", array($data['email'])) > 0) //аналогично с логином
	{

		$errors[] = "Пользователь с таким Email существует!";
	}


	if(empty($errors))
	{

		// Все проверено, регистрируем
		// Создаем таблицу users в БД
		$user = R::dispense('users');

                // добавляем в таблицу записи
		$user->login = $data['login'];
		$user->email = $data['email'];
		$user->name = $data['name'];
		$user->family = $data['family'];

		// Хешируем пароль
		$user->password = password_hash($data['password'], PASSWORD_DEFAULT);

		// Сохраняем таблицу
		R::store($user);
        $result = '<div style="color: green; ">Вы успешно зарегистрированы! Можно <a href="login.php">авторизоваться</a>.</div><hr>';

	} else
	{
                // array_shift() извлекает первое значение массива array и возвращает его, сокращая размер array на один элемент.
		$result = '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
	}
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Форма регистрации</title>
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
			<h2>Форма регистрации</h2>
			<form action="signup.php" method="post">
				<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин" required><br>
				<input type="email" class="form-control" name="email" id="email" placeholder="Введите Email" required><br>
				<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя" required><br>
				<input type="text" class="form-control" name="family" id="family" placeholder="Введите фамилию" required><br>
				<input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль" required><br>
				<input type="password" class="form-control" name="password_2" id="password_2" placeholder="Повторите пароль" required><br>
				<button type="submit" class="btn btn-success" name="do_signup">Зарегистрировать</button>
			</form>
			<br>
			<p>Если вы зарегистрированы, тогда нажмите <a href="login.php">здесь</a>.</p>
			<p>Вернуться на <a href="/www/intro.php" data-ajax="1">главную</a>.</p>
				</div>
			</div>
		</div>
</main>
</body>
</html>
