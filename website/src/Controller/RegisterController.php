<?php 

namespace ldahinden\Controller;

use ldahinden\Service\RegisterService;

class RegisterController
{
	/**
	 * @var ihrname\SimpleTemplateEngine Template engines to render output
	 */
	private $template;
	
	/**
	 * @var \RegisterService
	 */
	private $registerService;
		
	private $mailer;
	
	/**
	 * @param ihrname\SimpleTemplateEngine
	 */
	public function __construct(\Twig_Environment $template, RegisterService $registerService, \Swift_Mailer $mailer)
	{
		$this->template = $template;
		$this->registerService = $registerService;
		$this->mailer= $mailer;
	}
	

	public function showRegister()
	{
		echo $this->template->render("register.html.twig");
	}
	
	public function register(array $data)
	{
		if (!array_key_exists('username', $data) OR !array_key_exists('email', $data) OR !array_key_exists('password', $data) OR !array_key_exists('confirmPassword', $data))
		{
			$this->showRegister();
			return;
		}
		 
		if (empty($data["username"]) OR empty($data["email"]) OR empty($data["password"]))
		{
			echo $this->template->render("register.html.twig", ["username" => $data['username'], "email" => $data['email']]);
			return;
		}
		 
		if (!$this->registerService->userExists($data["username"], $data["email"]))
		{
			echo $this->template->render("register.html.twig", ["errorMessage" => "Username or Email exists already"]);
			return;
		}
		 
		if ($data["password"] == $data["confirmPassword"])
		{
			$activationstring = md5(random_bytes(1000));
			$this->registerService->registerUser($data["username"], $data["email"], password_hash($data["password"], PASSWORD_DEFAULT), $activationstring);
			$this->mailer->send(
					\Swift_Message::newInstance("User Activation")
					->setFrom(['noreply@theforum.com'])
					->setTo([$data["email"]])
					->setBody(
							'<html>' .
							' <head></head>' .
							' <body>' .
							' <p>Hi ' . $data["username"] . '</p><p>You have successfully registered at The Forum. To finish your registration Click on the activation link below to activate
  					your account.</p>' .
							'<a href="https://'
							. $_SERVER["HTTP_HOST"] .
							'/activate/' . $activationstring . '">Activate</a>'.
							' </body>' .
							'</html>',
							'text/html')
					);
			echo $this->template->render("registerConfirmation.html.twig");
		}
		else {
			echo $this->template->render("register.html.twig", ["email" => $data["email"], "username" => $data["username"], "errorMessage" => "Passwords do not match"]);
		}
	}
	
	public function activate($activationString)
	{
		$this->registerService->activateUser($activationString);
		echo $this->template->render("activationConfirmation.html.twig");
	}
}

