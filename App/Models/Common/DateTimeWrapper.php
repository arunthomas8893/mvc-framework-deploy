<?php
namespace App\Models\Common;
class DateTimeWrapper {

    static function newDate() {
        $now = new \DateTime(null, new \DateTimeZone('Asia/Calcutta'));
        $date = $now->format('Y-m-d H:i:s');
        return $date;
    }
    static function newDateTime(){
        $now= new \DateTime(null, new \DateTimeZone('Asia/Calcutta'));
        $date = $now->format('YYYY-mm-ddTHH:MM:ss');
        return $date;
    }       
    static function newDateInIndianFormat() {
        $now = new \DateTime(null, new \DateTimeZone('Asia/Calcutta'));
        $date = $now->format('d-m-Y H:i:s');
        return $date;
    }

    static function newDateOnly() {
        $now = new \DateTime(null, new \DateTimeZone('Asia/Calcutta'));
        $date = $now->format('Y-m-d');
        return $date;
    }

    public function ChangeDate($dt) {
        $dte = str_replace('-', '/', $dt);
        $date = date('d/m/Y H:i:s', strtotime($dte));
        return $date;
    }

    public function ChangeDateOnlyToSqlFormat($date) {
        //$now = new DateTime($date);
        //$date = $now->format('d/m/Y');
        $dt = DateTime::createFromFormat('d/m/Y', $date);
        return $dt->format('Y-m-d');
    }

    public function ChangeDateOnlyToIndianFormat($date) {
        $dt = date_create_from_format('Y-m-d', $date);
        return date_format($dt, 'd/m/Y');
    }
    public function ChangeDateTimeToIndianFormat($date) {
        $dt = date_create_from_format('Y-m-d H:i:s', $date);
        return date_format($dt, 'd/m/Y H:i:s');
    }
    public function ChangeDateTimeToIndianDateFormat($date) {
        $dt = date_create_from_format('Y-m-d H:i:s', $date);
        return date_format($dt, 'd/m/Y');
    }
    public function GetDateDiff($dt) {
        $date = date_create_from_format('d/m/Y', $dt);
        $dte = date_format($date, 'Y/m/d');
        $endDate = date("Y/m/d", strtotime(date("Y-m-d", strtotime($dte)) . "  + 1 year"));
        $startDate = date("Y/m/d", strtotime(date("d.m.Y")));
        $date2 = new DateTime($startDate);
        $date1 = new DateTime($endDate);
        $interval = $date1->diff($date2);
        $dateDiff = $interval->days;
        return $dateDiff;
    }
    /*
    public function GetAge($date) {
        $dt = date_create_from_format('d/m/Y', $date);
        $dte = date_format($dt, 'Y-m-d');
        return date_diff(date_create($dte), date_create('today'))->y;
    }
    */
    function datediff( $returnType, $from, $to, $relative=false){

       if( is_string( $from)) $from = date_create( $from);
       if( is_string( $to)) $to = date_create( $to);

       $diff = date_diff( $from, $to, ! $relative);
       
       switch( $returnType){
           case "y": 
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h": 
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i": 
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s": 
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
          }
       if( $diff->invert)
               return -1 * $total;
       else    return $total;
   }

}

?>
