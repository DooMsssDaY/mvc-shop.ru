<?php
/**
 * Контроллер CartController
 * управление карзиной пользователя
 */
class CartController
{
    /**
     * Action для страницы "Карзина"
     */
	public function actionIndex()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		$title = 'Карзина';

		$productsInCart = false;
		$productsInCart = Cart::getProductsFromCart();

		if ($productsInCart)
		{
			$products = Product::getProductsByIds(array_keys($productsInCart));
			$totalPrice = Cart::getTotalPrice($products);
		}

		require_once(ROOT.'/views/site/cart.php');
		return true;
	}

    /**
     * Action для удаления товара из карзины
     */
	public function actionDeleteItem($id)
	{
		if(isset($_SESSION['cart'][$id]))
			unset($_SESSION['cart'][$id]);

		header("Location: /cart/");
	}

   /**
     * Action для добавления товара в карзину
     */
	public function actionAdd($id)
	{
		echo Cart::addProductToCart($id);
		return true;
	}
}