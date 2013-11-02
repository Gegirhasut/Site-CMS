<?php
class Application
{
	public static function run()
	{
		require_once('classes/Router.php');
		require_once('classes/Error.php');
		require_once('classes/Config.php');
		
		session_start();
		Router::parse();
		
		require_once(Router::getControllerPath());
		
		$controller = new ReflectionClass(Router::getControllerClassName());
		$c = $controller->newInstance();
		$c->setTemplatePath(Router::getViewPath());
		
		if (!empty($_POST)) {
			
			// HTTP_REFERER
			
			$c->post();
		} 
		$c->display();
	}
}