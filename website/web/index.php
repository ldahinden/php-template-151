<?php

use ldahinden\Service\LoginMysqlService;

error_reporting(E_ALL);

session_start();

require_once("../vendor/autoload.php");
$factory = new ldahinden\Factory();
$tmpl = $factory->getTemplateEngine();
$pdo = $factory->getPDO();

$loginService = $factory->getLoginService();

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		(new ldahinden\Controller\IndexController($tmpl))->homepage();
		break;
	case "/test/upload":
		if(file_put_contents(__DIR__ . "/../../upload/test.txt", "Mein erster Upload")) {
			echo "It worked";
		} else {
			echo "Error happened";
		}
		break;
	case "/testroute":
		echo "Test";
		break;
	case "/login":
		$ctr = $factory->getLoginController();
		if ($_SERVER['REQUEST_METHOD'] == "GET")
		{
			$ctr->showLogin();
		}
		else if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$ctr->login($_POST);
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			(new ihrname\Controller\IndexController($tmpl))->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

