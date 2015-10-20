<?php
/**
 * Контроллер CabinetController
 * Личный кабинет пользователя
 */
class CabinetController
{
    /**
     * Action для страницы "Личный кабинет"
     */  
	public function actionIndex()
	{
		User::checklogged();
		$user = User::getUserById($_SESSION['user_id']);
		$title = 'Личный кабинет';

		include_once ROOT.'/views/cabinet/index.php';

		return true;
	}

    /**
     * Action для страницы "Редактировать данные профиля"
     */  
	public function actionEdit()
	{
		User::checklogged();
		$user = User::getUserById($_SESSION['user_id']);
		$title = 'Редактировать данные профиля';

		$changeUserDataSuccess = false;

		if(isset($_POST['submit']))
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			
			$errors = self::checkChangeUserDataForm($name, $email, $password, $password2);

			if (empty($errors))
				$changeUserDataSuccess = User::changeUserData($user['id'], $name, $email, $password);
		}

		include_once ROOT.'/views/cabinet/edit.php';

		return true;		
	}

    /**
     * Action для страницы "Просмотр заказов"
     */  
	public function actionHistory()
	{
		$user_id = User::checklogged();
		$orders = Order::getOrdersList($user_id);
		$title = 'Просмотр заказов';

		include_once ROOT.'/views/cabinet/history.php';

		return true;	
	}

    /**
     * Action для страницы "Просмотр заказа"
     */  
    public function actionView($id)
    {
        $order = Order::getOrderById($id);
        $title = 'Заказ №'.$order['id'];

        $productsQuantity = json_decode($order['products'], true);
        $products = Product::getProductsByIds(array_keys($productsQuantity));

        require_once(ROOT . '/views/cabinet/view.php');
        return true;
    }

    /**
     * проверка данных с формы редактирования данных профиля
     * @return array <p>список ошибок</p> 
     */
	private static function checkChangeUserDataForm($name, $email, $password, $password2)
	{
		$errors = array();

		if (!CheckValid::validLogin($name))
			$errors[] = "Длинна поля Имя должна быть в диапазоне от ".Config::MIN_LANGTH_NAME." до ".Config::MAX_LANGTH_NAME.". Так же не допускаются кавычки.";

		if (!CheckValid::validEmail($email))
			$errors[] = "Не верный Email";

		if (!CheckValid::validPassword($password))
			$errors[] = "Пароль должен быть не короче ".Config::MIN_LANGTH_PASS." символов.";
	
		$user = User::getUserById($_SESSION['user_id']);

		if($user['email'] != $email)
			if (User::checkEmailExists($email))
				$errors[] = "Пользователь с таким Email уже существует.";

		if ($password != $password2)
			$errors[] = "Пароли не совпадают.";

		return $errors;
	}
}