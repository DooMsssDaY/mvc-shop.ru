<?php
/**
 * Класс Order - модель для работы с заказами
 */
class Order
{
    /**
     * Сохранение заказа
     * @return Integer <p>Кол-во добавленных записей в таблицу</p>
     */
  	public static function saveOrder($name, $email, $phone, $address, $message, $user_id, $products)
  	{
    		$db = Database::getConnection();
        $result = $db->prepare("INSERT INTO product_order(user_name, user_phone, email, address, user_comment, user_id, products)
                                VALUES(?,?,?,?,?,?,?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('sssssis', $name, $phone, $email, $address, $message, $user_id, $products) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
  	}

    /**
     * Возвращает список заказов
     * @return Array <p>Список заказов</p>
     */
    public static function getOrdersList($user_id = false)
    {
        $user = '';

        if ($user_id != 0)
            $user .= "WHERE user_id = $user_id";

		    $db = Database::getConnection();
        $result = $db->query("SELECT *
        					  FROM product_order
                              $user
        					  ORDER BY id DESC");
        
        $ordersList = array();

        while ($row = $result->fetch_assoc())
            $ordersList[] = $row;

        return $ordersList;
    }

    /**
     * Возвращает текстое пояснение статуса для заказа :<br/>
     * <i>1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт</i>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
        }
    }

    /**
     * Возвращает цвет статуса для заказа :<br/>
     * <i>1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт</i>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getStatusColor($status)
    {
        switch ($status) {
            case '1':
                return '#FFD70F';
                break;
            case '2':
                return '#fff';
                break;
            case '3':
                return '#F0F0E9';
                break;
            case '4':
                return '#D0FF00';
                break;
        }
    }

    /**
     * Получение заказа по id
     * @return Array <p>массив с заказом</p>
     */
  	public static function getOrderById($id)
  	{
  			$id = intval($id);
  			$order = array();

        $db = Database::getConnection();
        $result = $db->prepare("SELECT * FROM product_order WHERE id = (?)")
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $result->bind_result($id, $user_name, $user_phone, $email, $address, $user_comment, $user_id, $date, $products, $status);

        while ($result->fetch())
        {
            $order['id'] = $id;
            $order['user_name'] = $user_name;
            $order['user_phone'] = $user_phone;
            $order['email'] = $email;
            $order['address'] = $address;
            $order['user_comment'] = $user_comment;
            $order['user_id'] = $user_id;
            $order['date'] = $date;
            $order['products'] = $products;
            $order['status'] = $status;
        }
        
        $result->close();

        return $order;
  	}

    /**
     * Удаляет заказ с указанным id
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function deleteOrderById($id)
    {
        $db = Database::getConnection();
        $result = $db->prepare("DELETE FROM product_order WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
    }

    /**
     * Изменение статуса заказа
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function changeStatus($id, $status)
    {
    		$db = Database::getConnection();
        $result = $db->prepare("UPDATE product_order
                                SET status = (?)
                                WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);
        
        $result->bind_param('ii', $status, $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;  
	  }
}