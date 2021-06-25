<?php

namespace App\Controllers\Traits;

use App\Models\Common\JWTWrapper;

trait ControllerAdmin {

    public function before() {
        $jwt = new JWTWrapper();
        if (isset($this->route_params['namespace'])) {
            if ($this->route_params['namespace'] == 'Admin') {
                if ($this->route_params['controller'] != 'authentication') {
                    if (!$jwt->authorizeAdmin()) {
                        header('Location:/admin/authentication/login');
                    }
                } else {
                    if ($this->route_params['action'] == 'changePassword' || $this->route_params['action'] == 'resetPassword') {
                        if (!$jwt->authorizeAdmin()) {
                            header('Location:/admin/authentication/login');
                        }
                    }
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function after() {

    }

    public function checkInPrivilages($privilage) {
        $jwt = new JWTWrapper();
        $payload = $jwt->getPayload();
        $privilages = $payload['privilages'];
        $privilages = explode(',', $privilages);
        if (\in_array($privilage, $privilages)) {
            return true;
        } else {
            if ($payload['type'] != 'Admin') {
                throw new \Exception(' User dont have ' . $privilage . ' privilage ', Values::$resCode_notAuthenticated);
            } else {
                return true;
            }
        }
    }

    public function getSections() {
        $jwt = new JWTWrapper();
        $payload = $jwt->getPayload();
        return $payload['sections'];
    }

    public function checkInSections($section) {
        $jwt = new JWTWrapper();
        $payload = $jwt->getPayload();
        $sections = $payload['sections'];
        $sections = explode(',', $sections);
        if (\in_array($section, $sections)) {
            return true;
        } else {
            if ($payload['type'] != 'Admin') {
                throw new \Exception(' User cant access ' . $section . ' section ', Values::$resCode_notAuthenticated);
            } else {
                return true;
            }
        }
    }

    public function checkForAdmin() {
        $jwt = new JWTWrapper();
        $payload = $jwt->getPayload();
        if ($payload['type'] != 'Admin') {
            throw new \Exception(' User is not an admin ', Values::$resCode_notAuthenticated);
        } else {
            return true;
        }
    }
    public static function getCommonDataForView(){
        return null;
    }

}
