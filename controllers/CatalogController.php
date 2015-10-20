<?php
/**
 * Контроллер CatalogController
 * управление категориями товаров
 */
class CatalogController
{
    /**
     * Action для страницы "Все товары"
     */ 
	public function actionIndex()
	{
		$categories = array();
		$categories = Category::getCategoriesList();
		$title = 'Все товары';

		$latestProd = array();
		$latestProd = Product::getLatestProducts(12);

		require_once(ROOT.'/views/catalog/index.php');

		return true;
	}

    /**
     * Action для страницы "Товары в категории"
     */ 
	public function actionCategory($catId, $page = 1)
	{
		$categories = array();
		$categories = Category::getCategoriesList();

		foreach ($categories as $category)
			if ($category['id'] == $catId)
				$title = $category['name'];

		$latestProd = array();
		$latestProd = Product::getProductsListByCategory($catId, $page);

		$total = Product::getTotalProductsInCategory($catId);

		$pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

		require_once(ROOT.'/views/catalog/category.php');

		return true;
	}
}