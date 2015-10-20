<?php
/**
 * Класс Product - модель для работы с товарами
 */
class Product
{
	const SHOW_BY_DEFAULT = 6;

    /**
     * Получение последних поступивших товаров
     * @return Array <p>последних товаров</p>
     */
	public static function getLatestProducts($count = self::SHOW_BY_DEFAULT)
	{
		$count = intval($count);
		$productslist = array();

		$db = Database::getConnection();
		$result = $db->prepare("SELECT id, name, price, is_new 
							  	FROM product
							 	WHERE status = '1'
							  	ORDER BY id DESC
							 	LIMIT ?")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('i', $count) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id, $name, $price, $is_new);

		$i=0;
		while ($result->fetch())
		{
			$productslist[$i]['id'] = $id;
			$productslist[$i]['name'] = $name;
			$productslist[$i]['price'] = $price;
			$productslist[$i]['is_new'] = $is_new;

			$i++;
		}

		$result->close();

		return $productslist;
	}

    /**
     * Получение товаров по id категории
     * @return Array <p>товаров категории</p>
     */
	public static function getProductsListByCategory($catId = false, $page)
	{
		$catId = intval($catId);
		$page = intval($page);
		$productslist = array();

		$offset = (self::SHOW_BY_DEFAULT*$page) - self::SHOW_BY_DEFAULT;

		$db = Database::getConnection();
		$result = $db->prepare("SELECT id, name, price, is_new 
							  FROM product
							  WHERE status = '1' AND category_id = ?
							  ORDER BY id DESC
							  LIMIT ".self::SHOW_BY_DEFAULT.
							  " OFFSET ?")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('ii', $catId, $offset) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id, $name, $price, $is_new);

		$i=0;
		while ($result->fetch())
		{
			$productslist[$i]['id'] = $id;
			$productslist[$i]['name'] = $name;
			$productslist[$i]['price'] = $price;
			$productslist[$i]['is_new'] = $is_new;

			$i++;
		}

		$result->close();

		return $productslist;
	}

    /**
     * Получение товара по id категории
     * @return Array <p>товар</p>
     */
	public static function getProductById($id)
	{
		$id = intval($id);
		$product = array();

		$db = Database::getConnection();
		$result = $db->prepare("SELECT * 
							  FROM product
							  WHERE id = ?")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id, $name, $category_id, $code, $price, $availability, $brand, $description, $is_new, $is_recommended, $status);

		while ($result->fetch())
		{
			$product['id'] = $id;
			$product['name'] = $name;
			$product['category_id'] = $category_id;
			$product['code'] = $code;
			$product['price'] = $price;
			$product['availability'] = $availability;
			$product['brand'] = $brand;
			$product['description'] = $description;
			$product['is_new'] = $is_new;
			$product['is_recommended'] = $is_recommended;
			$product['status'] = $status;
		}

		$result->close();

		return $product;
	}

    /**
     * Получение кол-ва всех товаров по id категории
     * @return Integer <p>кол-во товаров в категории</p>
     */
	public static function getTotalProductsInCategory($catId)
	{
		$catId = intval($catId);

		$db = Database::getConnection();
		$result = $db->prepare("SELECT COUNT(*) as count
							  	FROM product
							  	WHERE status = '1' AND category_id = ?")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('i', $catId) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($count);
		$result->fetch();
		$result->close();

		return $count;
	}

    /**
     * Получение товаров по id
     * @return Array <p>товаров</p>
     */
	public static function getProductsByIds($ProductIDs)
	{
		$ProductIDs = implode(',', $ProductIDs);
		$productslist = array();

		$db = Database::getConnection();
		$result = $db->prepare("SELECT *
							  	FROM product
							  	WHERE id IN($ProductIDs)")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);
		$result->bind_result($id, $name, $category_id, $code, $price, $availability, $brand, $description, $is_new, $is_recommended, $status);

		$i=0;
		while ($result->fetch())
		{
			$productslist[$i]['id'] = $id;
			$productslist[$i]['name'] = $name;
			$productslist[$i]['category_id'] = $category_id;
			$productslist[$i]['code'] = $code;
			$productslist[$i]['price'] = $price;
			$productslist[$i]['availability'] = $availability;
			$productslist[$i]['brand'] = $brand;
			$productslist[$i]['description'] = $description;
			$productslist[$i]['is_new'] = $is_new;
			$productslist[$i]['is_recommended'] = $is_recommended;
			$productslist[$i]['status'] = $status;

			$i++;
		}

		$result->close();

		return $productslist;
	}

    /**
     * Получение рекоментодаванных товаров
     * @return Array <p>рекоментодаванных товаров</p>
     */
	public static function getRecommendedProducts($amount = self::SHOW_BY_DEFAULT)
	{
		$amount = intval($amount);
		$recProductslist = array();

		$db = Database::getConnection();
		$result = $db->prepare("SELECT *
							  	FROM product
							  	WHERE status = '1' AND is_recommended = '1'
							  	ORDER BY id DESC
							  	LIMIT ?")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('i', $amount) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id, $name, $category_id, $code, $price, $availability, $brand, $description, $is_new, $is_recommended, $status);

		$i=0;
		while ($result->fetch())
		{
			$recProductslist[$i]['id'] = $id;
			$recProductslist[$i]['name'] = $name;
			$recProductslist[$i]['category_id'] = $category_id;
			$recProductslist[$i]['code'] = $code;
			$recProductslist[$i]['price'] = $price;
			$recProductslist[$i]['availability'] = $availability;
			$recProductslist[$i]['brand'] = $brand;
			$recProductslist[$i]['description'] = $description;
			$recProductslist[$i]['is_new'] = $is_new;
			$recProductslist[$i]['is_recommended'] = $is_recommended;
			$recProductslist[$i]['status'] = $status;

			$i++;
		}

		$result->close();

		return $recProductslist;
	}

    /**
     * Получение всех товаров
     * @return Array <p>всех товаров</p>
     */
    public static function getProductsList()
    {
        $db = Database::getConnection();
        $result = $db->query('SELECT *
        					  FROM product
        					  ORDER BY id ASC');

        $productsList = array();

        while ($row = $result->fetch_assoc())
            $productsList[] = $row;

        return $productsList;
    }

    /**
     * Удаляет товар с указанным id
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function deleteProductById($id)
    {
        $db = Database::getConnection();
        $result = $db->prepare("DELETE FROM product WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
    }

    /**
     * Добавляет новый товар
     * @return boolean <p>результат попытки записи в БД</p>
     */
    public static function createProduct($options)
    {
		$name = $options['name'];
		$code = $options['code'];
		$price = $options['price'];
		$category_id = $options['category_id'];
		$brand = $options['brand'];
		$availability = $options['availability'];
		$description = $options['description'];
		$is_new = $options['is_new'];
		$is_recommended = $options['is_recommended'];
		$status =$options['status'];

		$db = Database::getConnection();
        $result = $db->prepare("INSERT INTO product (name, code, price, category_id, brand, availability, description, is_new, is_recommended, status)
							  VALUES (?,?,?,?,?,?,?,?,?,?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);
        
        $result->bind_param('sidisisiii', $name, $code, $price, $category_id, $brand, $availability, $description, $is_new, $is_recommended, $status) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows; 
    }

    /**
     * Редактирует товар с заданным id
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateProductById($id, $options)
    {
    	$id = intval($id);
		$name = $options['name'];
		$code = $options['code'];
		$price = $options['price'];
		$category_id = $options['category_id'];
		$brand = $options['brand'];
		$availability = $options['availability'];
		$description = $options['description'];
		$is_new = $options['is_new'];
		$is_recommended = $options['is_recommended'];
		$status =$options['status'];

		$db = Database::getConnection();
		$result = $db->prepare("UPDATE product
								  SET name = (?), 
								  	  code = (?), 
							  		  price = (?), 
							  		  category_id = (?), 
							  		  brand = (?), 
							  		  availability = (?), 
							  		  description = (?), 
							  		  is_new = (?), 
							  		  is_recommended = (?), 
							  		  status  = (?)
							  	WHERE id = (?)")
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);
        
        $result->bind_param('sidisisiiii', $name, $code, $price, $category_id, $brand, $availability, $description, $is_new, $is_recommended, $status, $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows; 
    }

    /**
     * Получение изображения товара
     * @return String <p>путь к изображению</p>
     */
    public static function getImageProduct($id)
    {
        $noImage = 'no_image.jpg';
        $path = Config::UPLOAD_PATH;
        $pathToProductImage = $path.$id.'.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage))
            return $pathToProductImage;
        
        return $path . $noImage;
    }
}