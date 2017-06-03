<?php

error_reporting(E_ALL);
session_start();

require_once("../vendor/autoload.php");

$conf = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new ldahinden\Factory($conf);



switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
		/*$factory->getMailer()->send(
				Swift_Message::newInstance("Subject")
				->setFrom(["gibz.module.151@gmail.com" => "Your Name"])
				->setTo(["luca.dahinden@gmx.ch" => "Foos Name"])
				->setBody("lul")
				);*/
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
	case "/logout":
		$ctr = $factory->getLoginController();
		$ctr->logout();
	default:
		$matches = [];
		if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) {
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		echo "Not Found";
}

