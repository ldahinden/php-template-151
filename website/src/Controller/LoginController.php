<?php

namespace ldahinden\Controller;

use ldahinden\SimpleTemplateEngine;
use ldahinden\Service\LoginService;

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
  	echo $this->template->render("login.html.twig", ['token' => $_SESSION['token']]);
  }
  
  public function login(array $data)
  {
  	if(!array_key_exists('email', $data) OR !array_key_exists('password', $data) OR !array_key_exists('token', $data))
  	{
  		$this->showLogin();
  		return;
  	}
  	
  	if ($data["token"] == $_SESSION["token"])
  	{
	  	if($this->loginService->authenticate($data["email"], $data["password"])){
	  		$_SESSION["email"] = $data["email"];
	  		header("Location: /");
	  	}else{
	  		echo $this->template->render("login.html.twig", ["email" => $data["email"]]);  		
	  	}  		
  	}
  	else {
  		$this->showLogin();
  	}
  }
  
  public function logout()
  {
  	session_destroy();
  	echo $this->template->render("index.html.twig");
  }
  
}
