<?php

namespace App\Models\DBTables;

use App\Models\Common as Common;

class User extends Common\TableClass {

    static $t_name = 'tbo_user';
    static $c_slno = 'slno';
    static $c_id = 'id';
     static $c_gid = 'gid';
    static $c_mobile = 'mobile';
    static $c_password = 'password';
    static $c_type = 'type';
    static $c_privilages = "privilages";
    static $c_sections = "sections";
    static $c_token = 'token';
    static $c_otp = 'otp';
    static $c_email = 'email';
    static $c_mDate = 'mDate';
    static $c_cDate = 'cDate';
    static $c_st = 'st';
    static $c_remarks = 'remarks';
    static $c_details = 'details';
    static $c_profilePic = "profilePic";
    public $slno,$gid, $id, $mobile, $email, $details, $password, $type, $otp, $profilePic, $token, $cDate, $mDate, $st, $privilages, $sections, $remarks;

    public function __construct() {
        $ClassName = get_called_class();
        $this->initialize($ClassName, $this);
        foreach ($this as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = Common\Values::$nullStringForTableClass;
            }
        }
    }

    public function getUserTypesArray() {
        return [
            "customer" => 1,
            "customerRegistrationPartOne" => 2,
            "staff" => 3,
            "staffRegistrationPartOne" => 6,
            "admin" => 7
        ];
    }

    public function getUserType($type) {
        $userType = $this->getUserTypesArray();
        return $userType[$type];
    }

    public function getUserStatusArray() {
        return [
            "active" => 1,
            "suspended" => -1,
            "deactivated" => 0,
        ];
    }

    public function getUserStatus($status) {
        $userStatus = $this->getUserStatusArray();
        return $userStatus[$status];
    }

    public function getUserStatusName($status) {
        $statusArray = $this->getUserStatusArray();
        if (array_search(str_replace(" ", "-", $status), $statusArray)) {
            $status = array_search($status, $statusArray);
            return str_replace("-", " ", $status);
        } else {
            return false;
        }
    }

}
