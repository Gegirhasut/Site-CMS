<?php
class Router
{
	private static $url;
	private static $urlParts;
	private static $modelPath;
	private static $viewPath;
	private static $controllerPath;
	private static $className = "Main";
	private static $controllerFolder = "Controllers";
	private static $modelFolder = "Models";
	
	private static $parameters;
	private static $controllerParam;
	
	public static function getUrlPart($index)
	{
		if (count(self::$urlParts) <= $index)
			return null;
		return self::$urlParts[$index];
	}
	
	public static function getParams($name = null)
	{
		if ($name == null) {
			return self::$parameters;	
		}
		return isset(self::$parameters[$name]) ? self::$parameters[$name] : null;
	}
	
	public static function parse()
	{
		self::_parseRequestUri();
		self::_setPaths();
		
		self::$modelPath = str_replace(
			self::$controllerFolder, 
			self::$modelFolder, 
			self::$controllerPath
		);
		self::$modelPath = str_replace(
			"_c", 
			"_m", 
			self::$modelPath
		);
		
		// print_r(self::$controllerPath);
	}
	
	public static function getControllerPath()
	{
		return self::$controllerPath;
	}
	
	public static function getViewPath()
	{
		return self::$viewPath;
	}
	
	public static function getControllerClassName()
	{
		return self::$className . "_c";
	}
	
	public static function getModelClassName()
	{
		return self::$className . "_m";
	}
	
	public static function getModelPath()
	{
		return self::$modelPath;
	}
	
	public static function getModelFolder()
	{
		return "classes/" . self::$modelFolder;
	}
	
	private static function _parseRequestUri()
	{
		if (strpos($_SERVER['REQUEST_URI'], '?') === false) {
			self::$url = $_SERVER['REQUEST_URI'];
		} else {
			//print_r($_SERVER['REQUEST_URI']);
			list(self::$url, self::$parameters) = explode("?", $_SERVER['REQUEST_URI']);
			self::$parameters = explode ("&", self::$parameters);
			$new_params = array();
			foreach(self::$parameters as $key => $value)
			{
				list($key, $value) = explode ("=", $value);
				$new_params[$key] = $value;
			}
			self::$parameters = $new_params; 
		}
		
		self::$urlParts = explode('/', rtrim(self::$url, '/'));
	}
	
	private static function _setPaths()
	{
		$route = implode ('/', self::$urlParts);
		if ($route == '') {
			$route = '/';
		}

		$file = dirname(__FILE__) . "/" . self::$controllerFolder . $route . "/" . self::$className . "_c.php";
		if (file_exists($file)) {
			self::$viewPath = ltrim($route . "/Main.tpl", "/");
			self::$controllerPath = $file;
			return;
		}

		for ($i = 1; $i < sizeof(self::$urlParts); $i++) {
			$route = rtrim($route, self::$urlParts[sizeof(self::$urlParts) - $i]);
			$route = rtrim($route, '/');
			$file = dirname(__FILE__) . "/" . self::$controllerFolder . $route . "/" . self::$className . "_c.php";
			if (file_exists($file)) {
				self::$viewPath = ltrim($route . "/Main.tpl", "/");
				self::$controllerPath = $file;
				self::$controllerParam = self::$urlParts[sizeof(self::$urlParts) - $i];
				return;
			}
		}
		
		self::$controllerPath = dirname(__FILE__) . "/" . self::$controllerFolder . "/error404_c.php";
		self::$className = "error404";
	} 
}