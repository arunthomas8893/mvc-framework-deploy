<?php

namespace App\Controllers;

use \Core\View;

class Product extends \Core\Controller {

    use Traits\ControllerBase;

    public function productPageAction() {
      
        View::renderTemplate("Pages/product/product-page.twig");
        
    }
  
    
}