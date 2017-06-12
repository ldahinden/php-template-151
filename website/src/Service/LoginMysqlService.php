<?php

namespace ldahinden\Service;

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
	
	public function authenticate($username, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=? OR username=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $username);
		$stmt->execute();
		$user = $stmt->fetchObject();
		if ($user->activated)
		{
			return password_verify($password, $user->password);
		}
		else 
		{
			return false;
		}
	}
}