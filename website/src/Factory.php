<?php 
namespace ldahinden;

use ldahinden\Session;
use ldahinden\Controller\PasswordController;

class Factory
{
	private $config;
	private $session;
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	public function getIndexController()
	{
		return new Controller\IndexController($this->getTwigEngine());
	}
	
	public function getLoginController()
	{
		return new Controller\LoginController(
				$this->getTwigEngine(),
				$this->getLoginService(),
				$this->getSession());
	}
	
	public function getRegisterController()
	{
		return new Controller\RegisterController(
				$this->getTwigEngine(),
				$this->getRegisterService(),
				$this->getMailer());
	}
	
	public function getPasswordController()
	{
		return new Controller\PasswordController(
				$this->getTwigEngine(),
				$this->getPasswordService(),
				$this->getMailer());
	}
	
	public function getTopicController()
	{
		return new Controller\TopicController(
				$this->getTwigEngine(),
				$this->getTopicService());
	}
	
	public function getPostController()
	{
		return new Controller\PostController(
				$this->getTwigEngine(),
				$this->getPostService(),
				$this->getSession());
	}
	
	public function getTemplateEngine()
	{
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function getTwigEngine()
	{
		$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../templates/");
		$twig = new \Twig_Environment($loader);
		$twig->addGlobal("_SESSION", $this->getSession());
		$twig->addGlobal("topicService", $this->getTopicService());
		return $twig;
	}
	
	public function getMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance($this->config["mailer"]["host"], $this->config["mailer"]["port"], $this->config["mailer"]["security"])
				->setUsername($this->config["mailer"]["username"])
				->setPassword($this->config["mailer"]["password"])
				);
	}
	
	public function getPDO()
	{
		return new \PDO(
				"mysql:host=" . $this->config["database"]["host"] . ";dbname=app;charset=utf8",
				$this->config["database"]["user"],
				$this->config["database"]["password"],
				[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
				);
	}
	
	public function getLoginService()
	{
		return new Service\LoginMysqlService($this->getPDO());
	}
	
	public function getRegisterService()
	{
		return new Service\RegisterMysqlService($this->getPDO());
	}
	
	public function getPasswordService()
	{
		return new Service\PasswordMysqlService($this->getPDO());
	}
	
	public function getTopicService()
	{
		return  new Service\TopicMySqlService($this->getPDO());
	}
	
	public function getPostService()
	{
		return new Service\PostMysqlService($this->getPDO());
	}
	
	public function getSession()
	{
		if (!$this->session)
		{
			$this->session = new \ldahinden\Session();
		}
		return $this->session;
	}
}