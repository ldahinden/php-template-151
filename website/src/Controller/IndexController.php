<?php

namespace ldahinden\Controller;

use ldahinden\SimpleTemplateEngine;

class IndexController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(\Twig_Environment $template)
  {
     $this->template = $template;
  }

  public function homepage() {
    echo $this->template->render("index.html.twig", ["user" => (array_key_exists("username", $_SESSION)) ? $_SESSION["username"] : ""]);
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.twig", ["name" => $name]);
  }
}
