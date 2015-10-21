<?php
/**
 * Класс Cart - модель для работы с карзиной
 */
class Cart
{
    /**
     * Добавление товара в карзину
     * @return integer <p>кол-во товара в карзине</p>
     */
	public static function addProductToCart($id)
	{
		$productsInCart = array();

		if (isset($_SESSION['cart']))
			$productsInCart  = $_SESSION['cart'];

		if (array_key_exists($id, $productsInCart))
			$productsInCart[$id]++;
		else
			$productsInCart[$id] = 1;
		
		$_SESSION['cart'] = $productsInCart;

		return self::itemsCount();
	}

    /**
     * Подсчёт товаров в карзине
     * @return integer <p>кол-во товара в карзине</p>
     */
	public static function itemsCount()
	{
		$count = 0;

		if (isset($_SESSION['cart']))
			foreach ($_SESSION['cart'] as $id => $value)
				$count += $value;

		return $count;
	}

    /**
     * Получение товаров из карзины
     * @return array <p>товары в карзине</p>
     */
	public static function getProductsFromCart()
	{
		if (isset($_SESSION['cart']))
			return $_SESSION['cart'];

		return false;
	}

    /**
     * Получение общей стоимости карзины
     * @return double <p>стоимость карзины</p>
     */
	public static function getTotalPrice($products)
	{
		$totalPrice = 0;
		$productsInCart = self::getProductsFromCart();

		if ($productsInCart)
			foreach ($products as $items)
				$totalPrice += $items['price'] * $productsInCart[$items['id']];

		return $totalPrice;
	}

    /**
     * Очистка карзины
     */
	public static function clear()
	{
		if (isset($_SESSION['cart']))
			unset($_SESSION['cart']);
	}
}