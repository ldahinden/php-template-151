<?php

error_reporting(E_ALL);

require_once("../vendor/autoload.php");
$tmpl = new ldahinden\SimpleTemplateEngine(__DIR__ . "/../templates/");

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
		$ctr = new ldahinden\Controller\LoginController($tmpl);
		if ($_SERVER['REQUEST_METHOD'] == "GET")
		{
			$ctr->showLogin();
		}
		else if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$ctr->login();
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

