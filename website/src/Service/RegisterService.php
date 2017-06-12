<?php 

namespace ldahinden\Service;

interface RegisterService
{
	public function userExists($username, $email);
	public function registerUser($username, $email, $password, $activationstring);
	public function activateUser($activationString);
}
