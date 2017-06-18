<?php 

namespace ldahinden\Entity;

class AnswerEntity
{
	private $postid;
	private $username;
	private $text;
	private $datecreated;
	
	public function __construct(string $postid, string $username, string $text, string $datecreated)
	{
		$this->postid = $postid;
		$this->username = $username;
		$this->text = $text;
		$this->datecreated = $datecreated;
	}
	
	public function getPostid()
	{
		return $this->postid;
	}
		
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getText()
	{
		return $this->text;
	}
	
	public function getDatecreated()
	{
		return $this->datecreated;
	}
}