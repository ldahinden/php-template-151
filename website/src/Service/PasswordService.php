<?php 

namespace ldahinden\Service;

interface PasswordService
{
	public function tryCreateNewPasswordReset($email, $resetToken);
	public function tryResetPassword($resetToken, $password);
}