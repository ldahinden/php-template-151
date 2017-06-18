<?php 

namespace ldahinden\Service;

class TopicMySqlService implements TopicService
{
	private $pdo;
	
	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}
	
	public function getAllTopics()
	{
		$stmt = $this->pdo->prepare("SELECT name FROM topic");
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public function getPostsForTopic(string $topicName)
	{
		$stmt = $this->pdo->prepare("SELECT id FROM topic WHERE name=?");
		$stmt->execute([$topicName]);
		$topicId = $stmt->fetchObject()->id;
		$stmt = $this->pdo->prepare("SELECT * FROM post WHERE topic_id=?");
		$stmt->execute([$topicId]);
		$allPosts = $stmt->fetchAll();
		$i = 0;
		foreach ($allPosts as $post)
		{
			$post['username'] = $this->getUserName($post['user_id']);
			$allPosts[$i] = $post;
			$i++;
		}
		return $allPosts;
	}
	
	public function getUserName(string $user_id)
	{
		$stmt = $this->pdo->prepare("SELECT username FROM user WHERE id=?");
		$stmt->execute([$user_id]);
		return $stmt->fetchObject()->username;
	}
}