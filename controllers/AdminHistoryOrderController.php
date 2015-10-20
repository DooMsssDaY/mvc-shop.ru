<?php
/**
 * Контроллер AdminHistoryOrderController
 * Управление заказами в админпанели
 */
class AdminHistoryOrderController extends AdminBase
{
    /**
     * Action для страницы "Управление заказами"
     */
    public function actionIndex()
    {
        $ordersList = Order::getOrdersList();
        $title = 'Управление заказами';

        require_once(ROOT . '/views/admin/admin_historyOrder/index.php');
        return true;
    }

    /**
     * Action для страницы "Удалить заказ"
     */
    public function actionDelete($id)
    {
        $title = 'Удалить заказ';

        if (isset($_POST['submit']))
        {
            Order::deleteOrderById($id);
            header("Location: /admin/historyOrder");
        }

        require_once(ROOT . '/views/admin/admin_historyOrder/delete.php');
        return true;
    }

    /**
     * Action для страницы "Детали заказа"
     */
    public function actionView($id)
    {
        $order = Order::getOrderById($id);
        $title = 'Детали заказа '.$id;

        $productsQuantity = json_decode($order['products'], true);
        $products = Product::getProductsByIds(array_keys($productsQuantity));

        require_once(ROOT . '/views/admin/admin_historyOrder/view.php');
        return true;
    }

    /**
     * Action для асинхронного изменения статуса заказа
     */
    public function actionChangeStatus($id)
    {
    	$status = $_POST['status'];

    	if (Order::changeStatus($id, $status))
   			echo "Статус изменён.";
   		else
   			echo "Ошибка. Статус не изменён.";

    	return true;
    }
}