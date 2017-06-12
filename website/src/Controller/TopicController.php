<?php 

namespace ldahinden\Controller;

use ldahinden\Service\TopicService;

class TopicController
{
	private $template;
	private $topicService;
	
	public function __construct(\Twig_Environment $template, TopicService $topicService)
	{
		$this->template = $template;
		$this->topicService = $topicService;
	}
	
	public function showPostsForTopic(string $topicName)
	{
		echo $this->template->render("topic.html.twig", ['posts' => $this->topicService->getPostsForTopic($topicName), 'topicname' => $topicName]);
	}
}