<?php
namespace App\Models\Common;

use App\Models\Common\Values;

class Validator {
    static $validationErrorCode='4eed55ValidSam';
    private $pasword_length = 8;
    public $test;
    public function validate(array $array):bool {
        $bool = true;
        foreach ($array as $variable => $condition) {            
            $condArray = explode('-', $condition);
            foreach ($condArray as $condString) {                
                $paramsArray = explode(',', $condString);
                if ($paramsArray[0] == 'int') {
                    $min = $paramsArray[1];
                    $max = $paramsArray[2];                    
                    $bool = $this->Int($variable, $min, $max);
                } elseif ($paramsArray[0] == 'string') {
                    $max = '';
                    $min = '';
                    $min = $paramsArray[1];
                    $max = $paramsArray[2];                    
                    $bool = $this->String($variable, $min, $max);
                } else {                    
                    $bool = $this->checkVariable($paramsArray[0], $variable);                    
                }                             
            }
        }
        return true;
    }
    private function checkVariable($condition, $variable) {
        if ($condition = 'required') {
            return $this->Required($variable);
        } elseif ($condition = 'email') {
            return $this->Int($variable);
        } elseif ($condition = 'password') {
            return $this->String($variable, $this->pasword_length);
        } elseif ($condition = 'array') {
            return $this->CheckArray($variable);
        }
    }
    private function CheckArray($variable) {
        if (is_array($variable)) {
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not an array', Values::$resCode_validationError);
        }
    }
    private function Required($variable) {
        if ($variable != '') {
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not set', Values::$resCode_validationError);
        }
    }
    private function Int($variable, $min = '', $max = '') {
        if (is_int($variable)) {
            if ($min != '') {
                if ($variable < (int) $min) {
                    throw new \Exception('Value '.print_r($variable, true).' is less than '.$min, Values::$resCode_validationError);
                }
            }
            if ($max != '') {
                if ($variable > (int) $max) {
                    throw new \Exception('Value '.print_r($variable, true).' is greater than '.$max, Values::$resCode_validationError);
                }
            }
            return true;
        }else{
            throw new \Exception('Value '.print_r($variable, true).' is not an integer', Values::$resCode_validationError);
        }
    }
    private function Float($variable, $min = '', $max = '') {
        if (is_float($variable)) {
            if ($min != '') {
                if ($variable < (int) $min) {
                    throw new \Exception('Value '.print_r($variable, true).' is less than '.$min, Values::$resCode_validationError);
                }
            }
            if ($max != '') {
                if ($variable > (int) $min) {
                    throw new \Exception('Value '.print_r($variable, true).' is greater than '.$max, Values::$resCode_validationError);
                }
            }
            return true;
        } else {
           throw new \Exception('Value '.print_r($variable, true).' is not float ', Values::$resCode_validationError);
        }
    }
    private function Number($variable, $min = '', $max = '') {
        if (is_numeric($variable)) {
            if ($min != '') {
                if ($variable < (int) $min) {
                    throw new \Exception('Value '.print_r($variable, true).' is less than '.$min, Values::$resCode_validationError);
                }
            }
            if ($max != '') {
                if ($variable > (int) $min) {
                    throw new \Exception('Value '.print_r($variable, true).' is greater than '.$max, Values::$resCode_validationError);
                }
            }
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not a number ', Values::$resCode_validationError);
        }
    }
    private function String($variable, $min = '', $max = '') {
        if (is_string($variable)) {
            if ($min != '') {
                if (strlen($variable) < (int) $min) {
                   throw new \Exception('Length of value '.print_r($variable, true).' is less than '.$min, Values::$resCode_validationError);
                }
            }
            if ($max != '') {
                if (strlen($variable) > (int) $max) {
                    throw new \Exception(' Length of value '.print_r($variable, true).' is greater than '.$max, Values::$resCode_validationError);
                }
            }
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not a string ', Values::$resCode_validationError);
        }
    }
    private function Bool($variable) {
        if (is_bool($variable)) {
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not a boolean ', Values::$resCode_validationError);
        }
    }
    private function Email($variable) {
        if (!filter_var($variable, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Value '.print_r($variable, true).' is not a valid email address ', Values::$resCode_validationError);
        } else {
            return true;
        }
    }
    private function CheckDate($date) {
        $out = str_replace("/", "-", $date);
        $d = explode("-", $out);
        if (checkdate($d[1], $d[0], $d[2])) {
            return true;
        } else {
            throw new \Exception('Value '.print_r($variable, true).' is not a valid date ', Values::$resCode_validationError);
        }
    }
    private function mobileNumber($number, $min = 1111111111, $max = 9999999999) {
        if (filter_var($number, FILTER_VALIDATE_INT, array("options" => array("min_range" =>
                        $min, "max_range" => $max))) === false) {
            throw new \Exception('Value '.print_r($variable, true).' is not a valid mobile number ', Values::$resCode_validationError);
        } else {
            return true;
        }
    }
    private function checkIfInt($variable) {
        if (filter_var($variable, FILTER_VALIDATE_INT) === 0 || !filter_var($variable, FILTER_VALIDATE_INT) === false) {
            return true;
        } else {
            return false;
        }
    }
}
