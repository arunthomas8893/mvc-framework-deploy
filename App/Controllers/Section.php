<?php

namespace App\Controllers;

use \Core\View;

class Section extends \Core\Controller {

    use Traits\ControllerBase;
    
    public function menAction() {
      
        View::renderTemplate("Pages/section/men.twig");
        
    }
    public function womenAction() {
      
        View::renderTemplate("Pages/section/women.twig");
        
    }
    public function kidsAction() {
      
        View::renderTemplate("Pages/section/kids.twig");
        
    }
  
    
}