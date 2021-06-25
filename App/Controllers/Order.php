<?php

namespace App\Controllers;

use \Core\View;

class Order extends \Core\Controller {

    use Traits\ControllerBase;
    
    public function cartAction() {
      
        View::renderTemplate("Pages/order/cart.twig");
        
    }
    public function shippingAction() {
      
        View::renderTemplate("Pages/order/shipping.twig");
        
    }
    public function paymentAction() {
      
        View::renderTemplate("Pages/order/payment.twig");
        
    }
    public function referralLinkAction() {
      
        View::renderTemplate("Pages/order/referral-link.twig");
        
    }
    
    
}