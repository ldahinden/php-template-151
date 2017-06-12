<?php 

namespace ldahinden\Entity;

class UserEntity
{
	private $username;
	
	private $email;
	
	private $password;
	
	private $activated;
	
	private $activationstring;
	
	public function __construct(string $username, string $email, string $password, bool $activated, string $activationstring)
	{
		$this->username = $username;
		$this->email = $email;
		$this->password = $password;
		$this->activated = $activated;
		$this->activationstring = $activationstring;
	}
	
	public function fromState(array $state) : \User
	{
		return new self(
				$state['username'],
				$state['email'],
				$state['password'],
				$state['activated'],
				$state['activationstring']
				);
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function getActivated()
	{
		return $this->activated;
	}
	
	public function setActivated($activated)
	{
		$this->activated = $activated;
	}
	
	public function getActivationstring()
	{
		return $this->activationstring;
	}
	
	public function setActivationstring($activationstring)
	{
		$this->activationstring = $activationstring;
	}
}
