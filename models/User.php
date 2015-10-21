<?php
/**
 * Класс User - модель для работы с пользователями
 */
class User
{
    /**
     * Регистрация нового пользователя
     * @return Integer <p>кол-во добавленных записей в таблице</p>
     */
	public static function register($name, $email, $phone, $password, $address)
	{
		$db = Database::getConnection();
		$result = $db->prepare("INSERT INTO user(name, email, phone, password, address)
		                      VALUES(?,?,?,?,?)") 
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('sssss', $name, $email, $phone, $password, $address) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$affected_rows = $result->affected_rows;
		$result->close();

		return $affected_rows;
	}

    /**
     * Проверка существования email в дазе данных
     * @return Integer <p>кол-во найденых записей в таблице</p>
     */
	public static function checkEmailExists($email)
	{
		$db = Database::getConnection();
		$result = $db->prepare("SELECT COUNT(*) as count
							  FROM user
							  WHERE email = (?)")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('s', $email) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($count);
		$result->fetch();
		$result->close();

		return $count;
	}

    /**
     * Проверка существования пользователя
     * @return Integer <p>кол-во найденых записей в таблице</p>
     */
	public static function checkUserExists($email, $password)
	{
		$db = Database::getConnection();
		$result = $db->prepare("SELECT COUNT(*) as count
							  FROM user
							  WHERE email = (?) AND password = (?)")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('ss', $email, $password) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($count);
		$result->fetch();
		$result->close();

		return $count;
	}

    /**
     * Авторизация пользователя
     */
	public static function Auth($email, $password)
	{
		$db = Database::getConnection();
		$result = $db->prepare("SELECT id
							  FROM user
							  WHERE email = (?) AND password = (?)")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('ss', $email, $password) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id);
		$result->fetch();
		$result->close();

		$_SESSION['user_id'] = $id;
	}

    /**
     * Проверка авторизации пользователя
     * @return Integer <p>Id пользователя</p>
     */
	public static function checklogged()
	{
		if (isset($_SESSION['user_id']))
			return $_SESSION['user_id'];

		header("Location: /user/login/");
	}

    /**
     * Проверка статуса 'гость'
     * @return boolean <p>статус гостя</p>
     */
	public static function isGuest()
	{
		if (isset($_SESSION['user_id']))
			return false;

		return true;
	}

    /**
     * Получение пользователя по id 
     * @return Array <p>массив с данными о пользователе</p>
     */
	public static function getUserById($id)
	{
		$id = intval($id);
		$user = array();

		$db = Database::getConnection();
		$result = $db->prepare("SELECT * FROM user WHERE id = (?)")
		or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);

		$result->bind_param('i', $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
		$result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

		$result->bind_result($id, $name, $email, $password, $address, $phone, $role);

		while ($result->fetch())
		{
			$user['id'] = $id;
			$user['name'] = $name;
			$user['email'] = $email;
			$user['password'] = $password;
			$user['address'] = $address;
			$user['phone'] = $phone;
			$user['role'] = $role;
		}

		$result->close();

		return $user;
	}

    /**
     * Проверка на наличие прав администратора 
     * @return Boolean <p>наличие прав</p>
     */
	public static function isAdmin()
	{
		$userId = User::checkLogged();
        $user = User::getUserById($userId);

        if ($user['role'] == 'admin')
            return true;

        return false;
	}

    /**
     * Изменение информации о пользователе 
     * @return Integer <p>кол-во отредактированных записей в таблице</p>
     */
	public static function changeUserData($id, $name, $email, $password)
	{
		$db = Database::getConnection();
        $result = $db->prepare("UPDATE user 
								SET name = (?), email = (?), password = (?)
								WHERE id = (?)") 
        or die("Не удалось подготовить запросы: (" . $db->errno . ") " . $db->error);
        
        $result->bind_param('sssi', $name, $email, $password, $id) or die("Не удалось привязать параметры: (" . $db->errno . ") " . $db->error);
        $result->execute() or die("Не удалось выполнить запрос: (" . $db->errno . ") " . $db->error);

        $affected_rows = $result->affected_rows;
        $result->close();

        return $affected_rows; 
	}
}