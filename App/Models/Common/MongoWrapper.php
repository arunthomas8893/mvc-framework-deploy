<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Common;

use App\Models\Common\DateTimeWrapper;

/**
 * Description of MongoConnection
 *
 * @author lazycoder
 */
class MongoWrapper {

    private $db = null;

    public function __construct() {
        $client = new \MongoDB\Client();
        $this->db = $client->blooms;
    }

    public function getCollection($collectionName = "") {

        $db = $this->db;
        if ($collectionName === "") {
            return $db->questions;
        } else {
            return $db->{$collectionName};
        }
    }

    public function selectCollection($class, $subject) {
        $collectionName = $this->createCollectionName($class, $subject);
        $db = $this->db;
        return $db->{$collectionName};
    }

    private function createCollectionName($class, $subject) {
        return "questions_" . $class . "_" . $subject;
    }

    public function getMongoDateTime() {
        // $date = DateTimeWrapper::newDateTime();
        return new \MongoDB\BSON\UTCDateTime(time() * 1000);
    }

    public function getFormattedDate($date) {
        $timestamp = $date->__toString(); //ISO DATE Return form mongo database
        $utcdatetime = new \MongoDB\BSON\UTCDateTime($timestamp);
        $datetime = $utcdatetime->toDateTime();
        $time = $datetime->format(DATE_RSS);
        $dateInUTC = $time;
        $time = strtotime($dateInUTC . ' UTC');
        $dateInLocal = date("d-m-Y H:i:s", $time);
        return $dateInLocal;
    }

}
