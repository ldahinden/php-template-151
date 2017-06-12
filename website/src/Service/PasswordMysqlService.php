<?php 

namespace ldahinden\Service;

class PasswordMysqlService implements PasswordService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function tryCreateNewPasswordReset($email, $resetToken)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM user WHERE email=?");
		$stmt->execute([$email]);
		if ($stmt->rowCount() > 0)
		{
			$userId = $stmt->fetchObject()->id;
			try 
			{
				$this->pdo->beginTransaction();
				$stmt = $this->pdo->prepare("SELECT * FROM password_reset WHERE user_id=?");
				$stmt->execute([$userId]);
				if ($stmt->rowCount() > 0)
				{
					$stmt = $this->pdo->prepare("DELETE FROM password_reset WHERE user_id=?");
					$stmt->execute([$userId]);
				}
				$stmt = $this->pdo->prepare("INSERT INTO password_reset (user_id, reset_code, reset_time) VALUES (?, ?, ?);");
				$stmt->execute([$userId, $resetToken, date("Y-m-d H:i:s")]);
				$this->pdo->commit();
				return true;
			}
			catch (\PDOException $ex)
			{
				$this->pdo->rollBack();
			}
		}
		return false;
	}
	
	public function tryResetPassword($resetToken, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM password_reset WHERE reset_code=?");
		$stmt->execute([$resetToken]);
		$row = $stmt->fetchObject();
		if ((time() - strtotime($row->reset_time)) < 1800)
		{
			try {
				$this->pdo->beginTransaction();
				$stmt = $this->pdo->prepare("UPDATE user SET password=? WHERE id=?");
				$stmt->execute([$password, $row->user_id]);
				$stmt = $this->pdo->prepare("DELETE FROM password_reset WHERE id=?");
				$stmt->execute([$row->id]);
				$this->pdo->commit();
				return true;
			}
			catch (\PDOException $ex)
			{
				$this->pdo->rollBack();
			}
		}
		return false;
	}
}