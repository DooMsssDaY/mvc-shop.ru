<?php
/**
 * Контроллер UserController
 * управление пользователями
 */
class UserController
{
    /**
     * Action для страницы "регистрация пользователя"
     */
	public function actionRegister()
	{
		$title = 'регистрация пользователя';
		$name = '';
		$email = '';
		$phone = '';
		$password = '';
		$address = '';
		$regSuccess = false;

		if(isset($_POST['submit']))
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$password = $_POST['password'];
			$address = $_POST['address'];
			
			$errors = self::checkRegForm($name, $email, $phone, $password, $address);

			if (empty($errors))
				$regSuccess = User::register($name, $email, $phone, $password, $address);
		}

		require_once(ROOT.'/views/user/register.php');

		return true;
	}

    /**
     * проверка данных с формы регистрации пользователя
     * @return array <p>список ошибок</p> 
     */
	private static function checkRegForm($name, $email, $phone, $password, $address)
	{
		$errors = array();

		if (!CheckValid::validLogin($name))
			$errors[] = "Длинна поля Имя должна быть в диапазоне от ".Config::MIN_LANGTH_NAME." до ".Config::MAX_LANGTH_NAME.". Так же не допускаются кавычки.";

		if (!CheckValid::validEmail($email))
			$errors[] = "Не верный Email";

		if (!CheckValid::validPassword($password))
			$errors[] = "Пароль должен быть не короче ".Config::MIN_LANGTH_PASS." символов.";

		if (User::checkEmailExists($email))
			$errors[] = "Пользователь с таким Email уже существует.";

		if (CheckValid::isContainQuotes($address))
			$errors[] = "В адресе содержаться недопустимые символы";

		if (!CheckValid::isIntNumber($phone) || strlen($phone) < 5 || strlen($phone) > 12)
			$errors[] = "Не верный номер телефона";

		return $errors;
	}

    /**
     * Action для страницы "авторизация пользователя"
     */
	public function actionLogin()
	{	
		$title = 'авторизация пользователя';
		$email = '';
		$password = '';

		if(isset($_POST['submit']))
		{
			$email = $_POST['email'];
			$password = $_POST['password'];

			$errors = self::checkLoginForm($email, $password);

			if (empty($errors))
			{
				User::Auth($email, $password);
				header("Location: /cabinet/");
			}
		}

		require_once(ROOT.'/views/user/login.php');
		return true;
	}

    /**
     * проверка данных с формы авторизации пользователя
     * @return array <p>список ошибок</p> 
     */
	private static function checkLoginForm($email, $password)
	{
		$errors = array();

		if (!CheckValid::validEmail($email))
			$errors[] = "Не верный Email";

		if (!CheckValid::validPassword($password))
			$errors[] = "Пароль должен быть не короче ".Config::MIN_LANGTH_PASS." символов.";

		if (empty($errors) && !User::checkUserExists($email, $password)) {
			$errors[] = "Пользователь с такой комбинацией email и пароля не существует.";
		}

		return $errors;
	}


	public function actionLogout()
	{
		unset($_SESSION['user_id']);
		header("Location: /");
	}
}