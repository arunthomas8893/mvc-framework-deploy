<?php

namespace Core;

use App\Models\Common\JWTWrapper;
use App\Models\Common\Values;

abstract class Controller {

    protected $route_params = [];
    protected $postArray = "";
    protected $filesArray = "";
    protected $getArray = "";
    protected $post = "";
    protected $get = "";
    protected $files = "";
    public static $ajaxRequest = false;
    public static $commonDataForView = false;
    

    public function setRouteParams($params){
        $this->route_params = $params;
    }
    public function __construct() {

    }
    
    public function getRoutParam($param){
        return $this->route_params[$param];
    }

    abstract function before();

    abstract function after();
    

    public function __call($name, $args) {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            $this->before();
            call_user_func_array([$this, $method], $args);
            $this->after();
        } else {
            throw new \Exception("$method", Values::$resCode_notFound);
        }
    }

    public function validateForm() {
        if ($this->postArray != "") {
            $this->post = $this->validatePostData();
        }
        if ($this->getArray != "") {
            $this->get = $this->validateGetData();
        }
        if ($this->filesArray != "") {
            $this->files = $this->validateFilesData();
        }
    }

    private function validatePostData() {
        $variableConditionArray = array();
        $postData = [];
        foreach ($this->postArray as $varName => $condition) {
            if ($condition == "") {
                if (isset($_POST[$varName])) {
                    $postData[$varName] = trim(htmlspecialchars($_POST[$varName]));
                }
            } else {
                if (isset($_POST[$varName])) {
                    $variableConditionArray[$_POST[$varName]] = $condition;
                    $postData[$varName] = trim(htmlspecialchars($_POST[$varName]));
                } else {
                    throw new \Exception("POST value " . print_r($varName, true) . ' is not set', Values::$resCode_validationError);
                }
            }
        }
        $valid = new \App\Models\Common\Validator();
        if ($valid->validate($variableConditionArray)) {
            return $postData;
        }
    }

    private function validateGetData() {
        $variableConditionArray = array();
        $getData = [];
        foreach ($this->getArray as $varName => $condition) {
            if ($condition == "") {
                if (isset($_GET[$varName])) {
                    $getData[$varName] = trim(htmlspecialchars($_GET[$varName]));
                }
            } else {
                if (isset($_GET[$varName])) {
                    $variableConditionArray[$_GET[$varName]] = $condition;
                    $getData[$varName] = trim(htmlspecialchars($_GET[$varName]));
                } else {
                    throw new \Exception("GET value " . print_r($varName, true) . ' is not set', Values::$resCode_validationError);
                }
            }
        }
        $valid = new \App\Models\Common\Validator();
        if ($valid->validate($variableConditionArray)) {
            return $getData;
        }
    }

    private function validateFilesData() {

        $filesData = [];
        foreach ($this->filesArray as $varName => $condition) {
            if ($condition == "") {
                if (isset($_FILES[$varName])) {
                    $filesData[$varName] = $_FILES[$varName];
                }
            } else {
                if (isset($_FILES[$varName])) {
                    $filesData[$varName] = $_FILES[$varName];
                } else {
                    throw new \Exception("File " . print_r($varName, true) . ' is not uploaded', Values::$resCode_validationError);
                }
            }
        }
        return $filesData;
    }

    public static function generateResponseJson($response, $data = '', $message = ''): string {
        return \json_encode(
                [
                    'response' => $response,
                    'data' => $data,
                    'message' => $message
                ]
        );
    }

}
