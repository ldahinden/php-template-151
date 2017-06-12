<?php 

namespace ldahinden\DataMapper;

class User
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
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getActivated()
	{
		return $this->activated;
	}
	
	public function getActivationstring()
	{
		return $this->activationstring;
	}
}
