<?php

namespace Core;

use App\Models\Common as Common;
use \App\Models\Common\JWTWrapper;

class Model {

    static $ConnectionObject;

    public function __construct() {
        if (static::$ConnectionObject == '') {
            static::$ConnectionObject = (new Common\DBConnection())->getConnection();
        }
    }

}
