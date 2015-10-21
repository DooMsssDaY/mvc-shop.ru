<?php
/**
 * Контроллер AdminCategoryController
 * Управление категориями товаров в админпанели
 */
class AdminCategoryController extends AdminBase
{
    /**
     * Action для страницы "Управление категориями"
     */
    public function actionIndex()
    {
        $categoriesList = Category::getCategoriesList(true);
        $title = 'Управление категориями';

        require_once(ROOT . '/views/admin/admin_category/index.php');
        return true;
    }

    /**
     * Action для страницы "Добавить категорию"
     */
    public function actionCreate()
    {
        $title = 'Добавить категорию';

        if (isset($_POST['submit']))
        {
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            $errors = self::checkCreateCategory($name, $sortOrder);

            if (empty($errors))
            {
                Category::createCategory($name, $sortOrder, $status);
                header("Location: /admin/category");
            }
        }
        require_once(ROOT . '/views/admin/admin_category/create.php');
        return true;
    }
    /**
     * Action для страницы "Редактировать категорию"
     */
    public function actionUpdate($id)
    {
        $category = Category::getCategoryById($id);
        $title = 'Редактировать категорию';

        if (isset($_POST['submit']))
        {
            $name = $_POST['name'];
            $sortOrder = $_POST['sort_order'];
            $status = $_POST['status'];

            Category::updateCategoryById($id, $name, $sortOrder, $status);
            header("Location: /admin/category");
        }

        require_once(ROOT . '/views/admin/admin_category/update.php');
        return true;
    }
    /**
     * Action для страницы "Удалить категорию"
     */
    public function actionDelete($id)
    {
        $title = 'Удалить категорию';
        
        if (isset($_POST['submit']))
        {
            Category::deleteCategoryById($id);
            header("Location: /admin/category");
        }

        require_once(ROOT . '/views/admin/admin_category/delete.php');
        return true;
    }

    /**
     * проверка данных с формы добавления категории
     * @return array <p>список ошибок</p> 
     */
    private static function checkCreateCategory($name, $sortOrder)
    {
        $errors = array();

        if ($name == '')
            $errors[] = "Введите название категории";

        if (!CheckValid::isIntNumber($sortOrder))
            $errors[] = "Не корректно указан порядковый номер";

        return $errors;
    }
}