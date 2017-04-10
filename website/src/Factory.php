<?php 
namespace ldahinden;

class Factory
{
	public function getIndexController()
	{
		return new Controller\IndexController($this->getTemplateEngine());
	}
	
	public function getLoginController()
	{
		return new Controller\LoginController(
				$this->getTemplateEngine(),
				$this->getLoginService());
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function getPDO()
	{
		return new \PDO(
				"mysql:host=mariadb;dbname=app;charset=utf8",
				"root",
				"my-secret-pw",
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
				);
	}
	
	public function getLoginService()
	{
		return new Service\LoginMysqlService($this->getPDO());
	}
}