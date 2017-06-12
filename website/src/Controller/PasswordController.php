<?php 

namespace ldahinden\Controller;

use ldahinden\Service\PasswordService;

class PasswordController
{
	private $template;
	private $passwordService;
	private $mailer;
	
	public function __construct(\Twig_Environment $template, PasswordService $passwordService, \Swift_Mailer $mailer)
	{
		$this->template = $template;
		$this->passwordService = $passwordService;
		$this->mailer = $mailer;
	}
	
	public function showForgotPassword()
	{
		echo $this->template->render("forgotpassword.html.twig");
	}
	
	public function sendForgotPasswordEmail($data)
	{
		$resetToken = md5(random_bytes(1000));
		if ($this->passwordService->tryCreateNewPasswordReset($data["email"], $resetToken))
		{
			$this->mailer->send(\Swift_Message::newInstance("Reset Password")
					->setFrom(['noreply@theforum.com'])
					->setTo([$data["email"]])
					->setBody(
							'<html>' .
							' <head></head>' .
							' <body>' .
							' <p></p>' .
							'<a href="https://'
							. $_SERVER["HTTP_HOST"] .
							'/resetpassword/' . $resetToken . '">Reset Password</a>'.
							' </body>' .
							'</html>',
							'text/html')
					);
			echo $this->template->render("resetPasswordLinkSentConfirmation.html.twig");
		}
		else 
		{
			echo $this->template->render("forgotpassword.html.twig", ["errorMessage" => "User not found"]);
		}
	}
	
	public function showResetPassword($resetToken)
	{
		echo $this->template->render("resetPassword.html.twig", ["resetToken" => $resetToken]);
	}
	
	public function resetPassword($data)
	{
		if (!array_key_exists('password', $data) OR !array_key_exists('confirmPassword', $data))
		{
			echo $this->template->render("resetPassword.html.twig");
			return;
		}
		if ($data['password'] == $data['confirmPassword'])
		{
			
			if ($this->passwordService->tryResetPassword($data['resetToken'], password_hash($data['password'], PASSWORD_DEFAULT)))
			{
				echo $this->template->render("resetPasswordConfirmation.html.twig");
			}
			else 
			{
				echo $this->template->render("resetPassword.html.twig", ["errorMessage" => "Your reset link has expired"]);
			}
		}
		else 
		{
			echo $this->template->render("resetPassword.html.twig", ["resetToken" => $data['resetToken'], "errorMessage" => "The passwords do not match"]);
		}
	}
}