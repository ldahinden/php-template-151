<?php 

namespace ldahinden\Service;

use ldahinden\Entity\PostEntity;

interface PostService
{
	public function createPost(PostEntity $post);
	public function getPost(string $postId);
}