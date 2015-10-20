<?php
// роуты
return array(	
				// товары
				'product/([0-9]+)' => 'product/view/$1',

				// каталог
				'catalog' => 'catalog/index',

				// категории
				'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2',
				'category/([0-9]+)' => 'catalog/category/$1',
				
				// пользователь
				'user/register' => 'user/register',
				'user/login' => 'user/login',
				'user/logout' => 'user/logout',

				// кабинет пользователя
				'cabinet/edit' => 'cabinet/edit',
				'cabinet/history/view/([0-9]+)' => 'cabinet/view/$1',
				'cabinet/history' => 'cabinet/history',
				'cabinet' => 'cabinet/index',

				// карзина
				'cart/deleteItem/([0-9]+)' => 'cart/deleteItem/$1',
				'cart/add/([0-9]+)' => 'cart/add/$1', 
				'cart' => 'cart/index', 

				// заказы
				'order' => 'order/index', 

				// админпанель - управление товарами
				'admin/product/create' => 'adminProduct/create',
				'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
				'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
				'admin/product' => 'adminProduct/index',

				// админпанель - управление категориями
				'admin/category/create' => 'adminCategory/create',
				'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
				'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
				'admin/category' => 'adminCategory/index',

				// админпанель - управление заказами
				'admin/historyOrder/update/([0-9]+)' => 'adminHistoryOrder/update/$1',
				'admin/historyOrder/delete/([0-9]+)' => 'adminHistoryOrder/delete/$1',
				'admin/historyOrder/view/([0-9]+)' => 'adminHistoryOrder/view/$1',
				'admin/historyOrder/changeStatus/([0-9]+)' => 'adminHistoryOrder/changeStatus/$1',
				'admin/historyOrder' => 'adminHistoryOrder/index',

				// админпанель
				'admin' => 'admin/index',
				
				// Главное меню
				'contact' => 'site/contact', // actionContact in SiteController
				'about' => 'site/about', // actionContact in SiteController
				'' => 'site/index', // actionIndex in SiteController	
			);