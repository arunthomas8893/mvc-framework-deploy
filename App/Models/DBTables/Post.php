<?php

namespace App\Models\DBTables;

use App\Models\Common as Common;

class Post extends Common\TableClass {

    static $t_name = 'tbo_post';
    static $c_slno = 'slno';
    static $c_id = 'id';
    static $c_user = 'user';
    static $c_cat = 'cat';
    static $c_subCat = 'subCat';
    static $c_title = 'title';
    static $c_price = 'price';
    static $c_pics = 'pics';
    static $c_details = 'details';
    static $c_description = 'description';
    static $c_location = 'location';
    static $c_lat = 'lat';
    static $c_lng = 'lng';
    static $c_tags = 'tags';
    static $c_type = 'type';
    static $c_cDate = 'cDate';
    static $c_st = 'st';
    static $c_mDate = 'mDate';
    static $c_remarks = 'remarks';
    static $c_views = 'views';
    public $slno, $id, $user, $cat, $subCat, $title, $price, $pics, $details,$description, $location,$lat,$lng, $tags, $type, $views, $cDate, $st, $mDate, $remarks;

    public function __construct() {
        $ClassName = get_called_class();
        $this->initialize($ClassName, $this);
        foreach ($this as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = Common\Values::$nullStringForTableClass;
            }
        }
    }

    public function getPostStatusArray() {
        return [
            "active" => 1,
            "confirmation-pending" => 2,
            "completed" => 0,
            "suspended" => -3,
            "deleted-user" => -1,
            "deleted-admin" => -2
        ];
    }

    public function getPostStatus($status) {
        $userType = $this->getPostStatusArray();
        return $userType[$status];
    }

    public function getPostStatusName($status) {
        $statusArray = $this->getPostStatusArray();
        if (array_search(str_replace(" ", "-", $status), $statusArray)) {
            $status = array_search($status, $statusArray);
            return str_replace("-", " ", $status);
        } else {
            return false;
        }
    }

}
