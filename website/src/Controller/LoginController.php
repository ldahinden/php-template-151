<?php

namespace ldahinden\Controller;

use ldahinden\SimpleTemplateEngine;
use ldahinden\Service\LoginService;
use ldahinden\Session;

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
  
  private $session;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template, LoginService $loginService, Session $session)
  {
     $this->template = $template;
     $this->loginService = $loginService;
     $this->session = $session;
  }

  public function showLogin()
  {
  	$this->session->generateToken();
  	echo $this->template->render("login.html.twig");
  }
  
  public function login(array $data)
  {
  	if(!array_key_exists('username', $data) OR !array_key_exists('password', $data))
  	{
  		$this->showLogin();
  		return;
  	}
  	$user = $this->loginService->getUser($data['username']);
  	if($user->getActivated() AND password_verify($data['password'], $user->getPassword())){
  		$this->session->set("username", $user->getUsername());
  		header("Location: /");
  	}else{
  		echo $this->template->render("login.html.twig", ["username" => $data["username"], "errorMessage" => "Username or Password are not correct or your account has not been activated yet."]);  		
  	}  		
  	
  }
  
  public function logout($token)
  {
  	if ($this->session->compareToken($token))
  	{
	  	$this->session->unset();
	  	header("Location: /");
  	}
  }
}
