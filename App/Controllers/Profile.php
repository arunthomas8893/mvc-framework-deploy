<?php

namespace App\Controllers;

use \Core\View;

class Profile extends \Core\Controller {

    use Traits\ControllerBase;
    
    public function profileAction() {
      
        View::renderTemplate("Pages/profile/profile.twig");
        
    }
    
    
}