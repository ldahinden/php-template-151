<?php 

namespace ldahinden\Service;

use ldahinden\Entity\PostEntity;
use ldahinden\Entity\UserEntity;
use ldahinden\Entity\AnswerEntity;

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
		$stmt->execute([$this->getTopicId($post->getTopicname()), $this->getUserId($post->getUsername()), $post->getTitle(), $post->getText(), $post->getDatecreated()]);
	}
	
	public function getPost(string $postId)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM post WHERE id=?;");
		$stmt->execute([$postId]);
		$obj = $stmt->fetchObject();
		return new PostEntity($this->getTopicName($obj->topic_id), $this->getUserName($obj->user_id), $obj->title, $obj->text, $obj->datecreated);
	}
	
	public function createAnswer(AnswerEntity $answer)
	{
		$stmt = $this->pdo->prepare("INSERT INTO answer (post_id, user_id, text, datecreated) VALUES (?, ?, ?, ?);");
		$stmt->execute([$answer->getPostid(), $this->getUserId($answer->getUsername()), $answer->getText(), $answer->getDatecreated()]);
	}
	
	public function getAnswersForPost(string $postId)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM answer WHERE post_id=?;");
		$stmt->execute([$postId]);
		$allObj = $stmt->fetchAll();
		$i = 0;
		foreach ($allObj as $obj)
		{
			$obj['username'] = $this->getUserName($obj['user_id']);
			$allObj[$i] = $obj;
			$i++;
		}
		return $allObj;
	}
		
	public function getUserId(string $username)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM user WHERE username=?;");
		$stmt->execute([$username]);
		return $stmt->fetchObject()->id;
	}
	
	public function getUserName(string $user_id)
	{
		$stmt = $this->pdo->prepare("SELECT username FROM user WHERE id=?");
		$stmt->execute([$user_id]);
		return $stmt->fetchObject()->username;
	}
	
	public function getTopicId(string $topicname)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM topic WHERE name=?;");
		$stmt->execute([$topicname]);
		return $stmt->fetchObject()->id;
	}
	
	public function getTopicName(string $topic_id)
	{
		$stmt = $this->pdo->prepare("SELECT name FROM topic WHERE id=?");
		$stmt->execute([$topic_id]);
		return $stmt->fetchObject()->name;
	}
}