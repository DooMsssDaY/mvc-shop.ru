<?php
/**
 * Контроллер AdminController
 * Админпанель
 */
class AdminController extends AdminBase
{
    /**
     * Action для страницы "Админпанель"
     */
	public function actionIndex()
	{	
		$title = 'Админпанель';
			
		require_once (ROOT.'/views/admin/index.php');
		return true;
	}
}