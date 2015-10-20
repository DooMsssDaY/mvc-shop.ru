<?php
/**
 * Контроллер ProductController
 * управление товарами
 */
class ProductController
{
    /**
     * Action для страницы "просмотр товара"
     */
	public function actionView($id)
	{
		$categories = array();
		$categories = Category::getCategoriesList();

		$product = array();
		$product = Product::getProductById($id);
		$title = $product['name'];

		require_once(ROOT.'/views/product/view.php');
		return true;
	}
}