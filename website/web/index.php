<?php

use ldahinden\Session;

error_reporting(E_ALL);

require_once("../vendor/autoload.php");

$conf = parse_ini_file(__DIR__ . "/../config.ini", true);
$factory = new ldahinden\Factory($conf);
$session = $factory->getSession();

switch($_SERVER["REQUEST_URI"]) {
	case "/":
		$factory->getIndexController()->homepage();
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
	case "/register":
		$ctr = $factory->getRegisterController();
		if ($_SERVER['REQUEST_METHOD'] == "GET")
		{
			$ctr->showRegister();
		}
		else if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$ctr->register($_POST);
		}
		break;
	case "/forgotpassword":
		$ctr = $factory->getPasswordController();
		if ($_SERVER['REQUEST_METHOD'] == "GET")
		{
			$ctr->showForgotPassword();
		}
		else if ($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$ctr->sendForgotPasswordEmail($_POST);
		}
		break;
	case "/createpost":
		if ($session->get('username') != "")
		{
			$ctr = $factory->getPostController();
			if ($_SERVER['REQUEST_METHOD'] == "GET")
			{
				$ctr->showCreatePost();
			}
			else if ($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$ctr->createPost($_POST);
			}
		}
		else {
			header("Location: /login");
		}
		break;
	default:
		$matches = [];
		if(preg_match("|^/activate/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{
			$factory->getRegisterController()->activate($matches[1]);
			break;
		}
		else if (preg_match("|^/resetpassword/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{
			$ctr = $factory->getPasswordController();
			if ($_SERVER["REQUEST_METHOD"] == "GET")
			{
				$ctr->showResetPassword($matches[1]);
			}
			else if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$ctr->resetPassword($_POST);
			}
		}
		else if(preg_match("|^/hello/(.+)$|", $_SERVER["REQUEST_URI"], $matches)) 
		{
			$factory->getIndexController()->greet($matches[1]);
			break;
		}
		else if(preg_match("|^/logout/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{
			$factory->getLoginController()->logout($matches[1]);
			break;
		}
		else if(preg_match("|^/topic/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{
			$factory->getTopicController()->showPostsForTopic($matches[1]);
			break;
		}
		else if(preg_match("|^/post/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{
			$factory->getPostController()->showPost($matches[1]);
			break;
		}
		else if (preg_match("|comment/(.+)$|", $_SERVER["REQUEST_URI"], $matches))
		{	
			if ($session->get('username') != "")
			{
				$ctr = $factory->getPostController();
				if ($_SERVER["REQUEST_METHOD"] == "GET")
				{
					$ctr->showCreateAnswer($matches[1]);
					break;
				}
				else if ($_SERVER["REQUEST_METHOD"] == "POST")
				{
					$ctr->createAnswer($_POST);
					break;
				}
			}
			else {
				header("Location: /login");
			}
		}
		echo "Not Found";
}

