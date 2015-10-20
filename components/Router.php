<?php
/**
 * Класс для работы с маршрутами
 */
class Router
{
	private $routes;

	public function __construct()
	{
		$routerPath = ROOT.'/config/routers.php';
		$this->routes = include $routerPath;
	}

    /**
     * Получение адреса страницы
     * @return string
     */
	private function getURI()
	{
		if(!empty($_SERVER['REQUEST_URI']))	
			return trim($_SERVER['REQUEST_URI'], '/');
	}

    /**
     * Подключение контроллеров
     */
	public function run()
	{
		$uri = $this->getURI();

		foreach ($this->routes as $r_uri => $r_path) {

			if (preg_match("~$r_uri~", $uri)) {

				$internalRoute = preg_replace("~$r_uri~", $r_path, $uri);

				$path_arr = explode('/', $internalRoute);
				$controller = ucfirst((array_shift($path_arr)."Controller"));
				$action = "action".array_shift($path_arr);
				$params = $path_arr;

				$controllerFile = ROOT.'/controllers/'.$controller.'.php';

				if(file_exists($controllerFile))
					require_once $controllerFile;

				$conlrollerObj = new $controller;
				$result = call_user_func_array(array($conlrollerObj, $action), $params);

				if ($result != null) {
					break;
				}
			}
		}
	}
}