<?php

namespace App\Controllers;

use \Core\View;

class Authentication extends \Core\Controller {

    use Traits\ControllerBase;

    public function sellerLoginAction() {
      
        View::renderTemplate("Pages/Authentication/seller-login.twig");
    }
    
    public function forgetPasswordAction() {
      
        View::renderTemplate("Pages/Authentication/forgetPassword.twig");
    }
    
}
