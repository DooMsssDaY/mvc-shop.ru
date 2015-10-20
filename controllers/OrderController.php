<?php
/**
 * Контроллер OrderController
 * управление заказами
 */
class OrderController
{
    /**
     * Action для страницы "Оформить заказ"
     */
	public function actionIndex()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		$title = 'Оформить заказ';

		$name = '';
		$email = '';
		$phone = '';
		$address = '';
		$message = '';
		$successOrder = false;

		if (Cart::itemsCount() == 0)
			header("Location: /");

		$totalItems = Cart::itemsCount();
		$products = Product::getProductsByIds(array_keys(Cart::getProductsFromCart()));
		$totalPrice = Cart::getTotalPrice($products);

		if (isset($_POST['submit']))
		{
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
			$message = $_POST['message'];

			$errors = self::checkOrderForm($name, $email, $phone, $address);

			if (empty($errors))
			{
				$user_id = (!User::isGuest()) ? User::checklogged() : false;
				$products = json_encode(Cart::getProductsFromCart());

				$successOrder = Order::saveOrder($name, $email, $phone, $address, $message, $user_id, $products);

				if ($successOrder )
				{
					$message = "Новый заказ на сайте ".Config::SITE_NAME."!<br/> Пройдите по ссылке что бы посмотреть заказ http://www.mvc-shop.ru/admin/orders";
					$successSend = mail(Config::ADMIN_MAIL, 'Новый заказ!', $message);

					Cart::clear();
				}
			}
		}
		else
		{	
			if (!User::isGuest())
			{
				$user = User::getUserById($_SESSION['user_id']);
				$name = $user['name'];
				$email = $user['email'];
				$phone = $user['phone'];
				$address = $user['address'];
			}
		}

		require_once(ROOT.'/views/site/order.php');
		return true;
	}

    /**
     * проверка данных с формы оформления заказа
     * @return array <p>список ошибок</p> 
     */
	private static function checkOrderForm($name, $email, $phone, $address)
	{
		$errors = array();

		if (!CheckValid::validLogin($name))
			$errors[] = "Длинна поля Имя должна быть в диапазоне от ".Config::MIN_LANGTH_NAME." до ".Config::MAX_LANGTH_NAME.". Так же не допускаются кавычки.";

		if (!CheckValid::validEmail($email))
			$errors[] = "Не верный Email";

		if (CheckValid::isContainQuotes($address))
			$errors[] = "В адресе содержаться недопустимые символы";

		if (!CheckValid::isIntNumber($phone) || strlen($phone) < 5 || strlen($phone) > 12)
			$errors[] = "Не верный номер телефона";

		return $errors;
	}
}