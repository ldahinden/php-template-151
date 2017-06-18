<?php 

namespace ldahinden\Controller;

use ldahinden\Service\PostMysqlService;
use ldahinden\Session;
use ldahinden\Entity\PostEntity;

class PostController
{
	private $template;
	private $postService;
	private $session;
	
	public function __construct(\Twig_Environment $template, PostMysqlService $postService, Session $session)
	{
		$this->template = $template;
		$this->postService = $postService;
		$this->session = $session;
	}
	
	public function showCreatePost()
	{
		echo $this->template->render("createPost.html.twig");
	}
	
	public function createPost(array $data)
	{
		if (!array_key_exists('topic', $data) OR !array_key_exists('title', $data) OR !array_key_exists('text', $data) OR !array_key_exists('token', $data))
		{
			echo $this->showCreatePost();
			return;
		}
		
		if (empty($data["title"]) OR empty($data["text"]))
		{
			echo $this->template->render("createPost.html.twig", ["title" => $data['title'], "text" => $data['text']]);
			return;
		}
		if ($this->session->compareToken($data["token"]))
		{
			$post = new PostEntity($data['topic'], $this->session->get("username"), $data['title'], $data['text']);
			$this->postService->createPost($post);
			echo $this->template->render("createpostConfirmation.html.twig");
		}
	}
	
	public function showPost(string $postid)
	{
		
	}
}