<?php 

namespace ldahinden\Service;

interface TopicService
{
	public function getAllTopics();
	public function getPostsForTopic(string $topicName);
}
