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
		return $stmt->fetchAll();
	}
}