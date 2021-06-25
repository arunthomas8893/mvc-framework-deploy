<?php


namespace App;

Class Routes {

    private static $routes = [
        //"products"=>["controller"=>"Product","action"=>"getAllProducts"],
        //"product/{id:.*?}"=>["controller"=>"Product","action"=>"getproductdetails"],
        
    ];

    public static function getRoutes() {
        return static::$routes;
    }

}
