<?php
/**
 * Класс Category - модель для работы с категориями
 */
class Category
{
    /**
     * Получение списка всех категорий
     * @return Array <p>список категорий</p>
     */
	public static function getCategoriesList($is_admin = false)
	{
		$db = Database::getConnection();
		$categoryList = array();

		$get_all = $is_admin == true ? '' : 'WHERE status = 1';
		$result = $db->query("SELECT *
							  FROM category
							  $get_all
							  ORDER BY sort_order ASC");

		while ($row = $result->fetch_assoc())
			$categoryList[]= $row;

		$result->close();

		return $categoryList;
	}

    /**
     * Возвращает текстое пояснение статуса для категории :<br/>
     * <i>0 - Скрыта, 1 - Отображается</i>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Отображается';
                break;
            case '0':
                return 'Скрыта';
                break;
        }
    }

    /**
     * Добавляет новую категорию
     * @return integer <p>кол-во добавленых записей в таблицу</p>
     */
    public static function createCategory($name, $sortOrder, $status)
    {
		$db = Database::getConnection();
        $result = $db->prepare("INSERT INTO category(name, sort_order, status) 
                                VALUES (?, ?, ?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('sii', $name, $sortOrder, $status) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
    }

    /**
     * Удаляет категорию с заданным id
     * @return integer <p>кол-во удалённых записей из таблицы</p>
     */
    public static function deleteCategoryById($id)
    {
        $db = Database::getConnection();
        $result = $db->prepare("DELETE FROM category WHERE id = (?)")
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);

        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
    }

    /**
     * Возвращает категорию с указанным id
     * @return array <p>Массив с информацией о категории</p>
     */
    public static function getCategoryById($id)
    {
		$id = intval($id);
		$category = array();

        $db = Database::getConnection();
        $result = $db->prepare("SELECT * FROM category WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);

        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);


        $result->bind_result($id, $name, $sort_order, $status);

        while ($result->fetch())
        {
            $category['id'] = $id;
            $category['name'] = $name;
            $category['sort_order'] = $sort_order;
            $category['status'] = $status;
        }
			
		$result->close();

		return $category;
	}

    /**
     * Редактирование категории с заданным id
     * @return Integer <p>кол-во отредактированных записей в таблице</p>
     */
    public static function updateCategoryById($id, $name, $sortOrder, $status)
    {
		$db = Database::getConnection();
        $result = $db->prepare("UPDATE category
                                SET name = (?), 
                                    sort_order = (?), 
                                    status = (?)
                                WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

        $result->bind_param('siii', $name, $sortOrder, $status, $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);

        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);


        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows;
    }

}