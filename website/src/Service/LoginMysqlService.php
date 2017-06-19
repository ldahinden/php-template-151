<?php

namespace ldahinden\Service;

use ldahinden\Entity\UserEntity;

class LoginMysqlService implements LoginService 
{
	/**
	 * @var \PDO
	 */
	private $pdo;
	
	/**
	 * @param ihrname\SimpleTemplateEngine
	 */
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function getUser($username)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? OR username=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $username);
		$stmt->execute();
		$obj = $stmt->fetchObject();
		if ($obj) {
			$user = new UserEntity($obj->username, $obj->email, $obj->password, $obj->activated, $obj->activationstring);
			return $user;
		}
		else {
			return $obj;
		}
	}
}