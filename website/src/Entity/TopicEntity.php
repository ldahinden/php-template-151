<?php 

namespace ldahinden\Entity;

class TopicEntity
{
	private $name;
	
	private $posts;
	
	public function __construct(string $name, array $posts)
	{
		$this->name = $name;
		$this->posts = $posts;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function  getPost()
	{
		return $this->posts;
	}
}