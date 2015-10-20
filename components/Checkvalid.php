<?php
/**
 * Класс для осуществления валидации
 */
class CheckValid {

    /**
     * проверка логина
     * @return boolean 
     */
    public static function validLogin($login)
    {
        if (self::isContainQuotes($login)) 
            return false;

        if (preg_match("/^\d*$/", $login)) 
            return false;

        return self::validString($login, Config::MIN_LANGTH_NAME, Config::MAX_LANGTH_NAME);
    }
    
    /**
     * проверка ID
     * @return boolean 
     */
    public static function validID($id)
    {
        if (!$this->isIntNumber($id))
            return false;

        if ($id <= 0) 
            return false;

        return true;
    }
    
    /**
     * проверка числа
     * @return boolean 
     */
    public static function isIntNumber($number)
    {
        if(!is_int($number) && !is_string($number))
            return false;

        if(!preg_match("/^-?(([1-9][0-9]*|0))$/",$number))
            return false;

        return true;
    }
    
    /**
     * проверка числа на паложительность
     * @return boolean 
     */
    public static function isNoNegativeInteger($number)
    {
        if (!$this->isIntNumber($number)) 
            return false;

        if ($number < 0) 
            return false;

        return true;
    }
    
    /**
     * проверка строки на наличие только букв и цифр
     * @return boolean 
     */
    public static function isOnlyLettersAndDigits($string)
    {
        if (!is_int($string) && (!is_string($string)))
            return false;

        if (!preg_match("/[a-zа-я0-9]*/i", $string))
            return false;

        return true;
    }
    
    /**
     * проверка строки
     * @return boolean 
     */
    private function validString ($string, $min_length, $max_length)
    {
        if(!is_string($string))
            return false;

        if(strlen($string) <= $min_length)
            return false;

        if(strlen($string) > $max_length)
            return false;

        return true;
    }
    
    /**
     * проверка строки на отсутствие кавычек
     * @return boolean 
     */
    public static function isContainQuotes($string)
    {
        $array = array("\"", "'", "`", "&quot;", "&apos;");
        
        foreach($array as $key => $value){
            if (strpos($string, $value) !== false) return true;
        }

        return false;
    }

    /**
     * проверка email
     * @return boolean 
     */
    public static function validEmail($email)
    {
        if (self::isContainQuotes($email)) 
            return false;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;

        return true;
    }

    /**
     * проверка пароля
     * @return boolean 
     */
    public static function validPassword($password)
    {
        if (self::isContainQuotes($password)) 
            return false;

        if (strlen($password) < Config::MIN_LANGTH_PASS)
            return false;

        return true;
    }
}