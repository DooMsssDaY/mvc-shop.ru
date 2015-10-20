<?php
/**
 * Контроллер SiteController
 * управление страницами главного меню
 */
class SiteController
{
    /**
     * Action для страницы "Главная"
     */
	public function actionIndex()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		$title = 'Главная';

		$latestProd = array();
		$latestProd = Product::getLatestProducts(6);

		$recommendedProducts = array();
		$recommendedProducts = Product::getRecommendedProducts(6);

		require_once(ROOT.'/views/site/index.php');
		return true;
	}

    /**
     * Action для страницы "Контакты"
     */
	public function actionContact()
	{	
		$title = 'Контакты';
		$name = '';
		$email ='';
		$subject = '';
		$message = '';
		$successSend = false;

		if(isset($_POST['submit']))
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];

			$errors = self::checkContactForm($name, $email, $subject, $message);

			if (empty($errors))
			{
				$message = "Сообщение от {$name}({$email}).<br/><br/>".$message;
				$successSend = mail(Config::ADMIN_MAIL, $subject, $message);
			}
		}

		require_once(ROOT.'/views/site/contact.php');
		return true;
	}

    /**
     * Action для страницы "О проекте"
     */
	public function actionAbout()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		$title = 'О проекте';

		require_once(ROOT.'/views/site/about.php');
		return true;
	}

    /**
     * проверка данных с формы отправления письма
     * @return array <p>список ошибок</p> 
     */
	private static function checkContactForm($name, $email, $subject, $message)
	{
		$errors = array();

		if (!CheckValid::validLogin($name))
			$errors[] = "Длинна поля Имя должна быть в диапазоне от ".Config::MIN_LANGTH_NAME." до ".Config::MAX_LANGTH_NAME.". Так же не допускаются кавычки.";

		if (!CheckValid::validEmail($email))
			$errors[] = "Не верный Email";

		return $errors;
	}
}