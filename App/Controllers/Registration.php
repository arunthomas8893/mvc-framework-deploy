<?php

namespace App\Controllers;

use \Core\View;

class Registration extends \Core\Controller {

    use Traits\ControllerBase;

    public function registration1Action() {
      
        View::renderTemplate("Pages/Registration/registration1.twig");
    }
    public function registration2Action() {
      
        View::renderTemplate("Pages/Registration/registration2.twig");
    }
    public function registration3Action() {
      
        View::renderTemplate("Pages/Registration/registration3.twig");
    }
}
