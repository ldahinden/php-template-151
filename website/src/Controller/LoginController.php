<?php

namespace ldahinden\Controller;

use ldahinden\SimpleTemplateEngine;
use ldahinden\Service\LoginService;
use ldahinden\Entity\UserEntity;

class LoginController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @var \LoginService
   */
  private $loginService;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, LoginService $loginService)
  {
     $this->template = $template;
     $this->loginService = $loginService;
  }

  public function showLogin()
  {
  	$_SESSION["token"] = md5(random_bytes(1000));
  	echo $this->template->render("login.html.twig");
  }
  
  public function login(array $data)
  {
  	$user = $this->loginService->getUser($data['username']);
  	if(!array_key_exists('username', $data) OR !array_key_exists('password', $data))
  	{
  		$this->showLogin();
  		return;
  	}
  	if($user->getActivated() AND password_verify($data['password'], $user->getPassword())){
  		$_SESSION["username"] = $user->getUsername();
  		header("Location: /");
  	}else{
  		echo $this->template->render("login.html.twig", ["username" => $data["username"], "errorMessage" => "Username or Password are not correct or your account has not been activated yet."]);  		
  	}  		
  	
  }
  
  public function logout($token)
  {
  	if ($token == $_SESSION["token"])
  	{
	  	unset($_SESSION["username"]);
	  	header("Location: /");
  	}
  }
}
