<?php

namespace App\Controllers;

use \Core\View;

class Index extends \Core\Controller {

    use Traits\ControllerBase;

    public function indexAction() {
      
        View::renderTemplate("Pages/index.twig");
        
    }
   
    public function faqAction() {
      
        View::renderTemplate("Pages/faq.twig");
        
    }
    public function privacyPolicyAction() {
      
        View::renderTemplate("Pages/privacy-policy.twig");
        
    }

    public function referralPageAction() {
      
        View::renderTemplate("Pages/referral-page.twig");
        
    }
    public function supportAction() {
      
        View::renderTemplate("Pages/support.twig");
        
    }

    public function returnAndRefundPolicyAction() {
      
        View::renderTemplate("Pages/Return-and-Refund-Policy.twig");
        
    }
    public function termsAndConditionsAction() {
      
        View::renderTemplate("Pages/Terms-and-Conditions.twig");
        
    }
}


