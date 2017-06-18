<?php 

namespace ldahinden\Service;

use ldahinden\Entity\PostEntity;
use ldahinden\Entity\UserEntity;

class PostMysqlService implements PostService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function createPost(PostEntity $post)
	{
		$stmt = $this->pdo->prepare("INSERT INTO post (topic_id, user_id, title, text, datecreated) VALUES (?, ?, ?, ?, ?);");
		$stmt->execute([$this->getTopicId($post->getTopicname()), $this->getUserId($post->getUsername()), $post->getTitle(), $post->getText(), date("Y-m-d H:i:s")]);
	}
	
	public function getPost(string $postId)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM post WHERE id=?;");
		$stmt->execute([$postId]);
		$obj = $stmt->fetchObject();
		return new PostEntity($topicname, $username, $title, $text)
	}
		
	public function getUserId(string $username)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM user WHERE username=?;");
		$stmt->execute([$username]);
		return $stmt->fetchObject()->id;
	}
	
	public function getTopicId(string $topicname)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM topic WHERE name=?;");
		$stmt->execute([$topicname]);
		return $stmt->fetchObject()->id;
	}
}