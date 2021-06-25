<?php

namespace App\Controllers\Traits;

use App\Models\Common\JWTWrapper;

trait ControllerBase {
    
    function before() {
    }
    
    function after() {        
    }
    public function __construct() { 
         static::$commonDataForView = static::getCommonDataForView();
    }
  
    private static function getCommonDataForView(){
        $jwt = new JWTWrapper();
        $user =[ "nill"];
        if ($jwt->checkUser()) {
            $user['id'] = $jwt->getPayload()['id'];
            $user['name'] = $jwt->getPayload()['name'];
            $user['mobile'] = $jwt->getPayload()['mobile'];
            $user['email'] = $jwt->getPayload()['email'];
            return [
                'user' => $user
            ];
        }else{
            return [
                "user" =>  "nill"
                ];
        }
    }  
   
}
