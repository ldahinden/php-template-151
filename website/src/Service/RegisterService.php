<?php 

namespace ldahinden\Service;

use ldahinden\Entity\UserEntity;

interface RegisterService
{
	public function userExists($username, $email);
	public function registerUser(UserEntity $user);
	public function activateUser($activationString);
}
