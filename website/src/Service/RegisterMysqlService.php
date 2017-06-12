<?php 

namespace ldahinden\Service;

class RegisterMysqlService implements RegisterService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function registerUser($username, $email, $password, $activationstring)
	{
		$stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, activated, activationstring) VALUES (?, ?, ?, 0, ?)");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $email);
		$stmt->bindValue(3, $password);
		$stmt->bindValue(4, $activationstring);
		$stmt->execute();
	}
	
	public function userExists($username, $email)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE username=? OR email=?");
		$stmt->bindValue(1, $username);
		$stmt->bindValue(2, $email);
		$stmt->execute();
	
		return $stmt->rowCount() == 0;
	}
	
	public function activateUser($activationString)
	{
		$stmt = $this->pdo->prepare("UPDATE user SET activated=1 WHERE activationstring=?");
		$stmt->execute([$activationString]);
	}
}

