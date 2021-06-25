<?php
namespace App\Models\Common;
Class FormClass{

    protected $check;

    private function postToObjectMapper($obj) {
        foreach ($_POST as $var => $value) {
            $obj->$var = trim($value);
        }
    }

    protected function initializeFormElements($formClassObject) {
        foreach ($formClassObject as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = '';
            }
        }
        $this->postToObjectMapper($formClassObject);
    }

    public function validate() {
        $val = new Validator();
        return $val->validate($this->check);
    }

}
