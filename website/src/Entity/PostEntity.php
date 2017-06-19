<?php 

namespace ldahinden\Entity;

class PostEntity
{
	private $id;
	private $topicname;
	private $username;
	private $title;
	private $text;
	private $datecreated;
	
	public function __construct(string $topicname, string $username, string $title, string $text, string $datecreated)
	{
		$this->topicname = $topicname;
		$this->username = $username;
		$this->title = $title;
		$this->text = $text;
		$this->datecreated = $datecreated;
	}
	
	public function setId(string $id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTopicname()
	{
		return $this->topicname;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getTitle()
	{
		return $this->title;
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