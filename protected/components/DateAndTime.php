<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

class DateAndTime
{
    public static function returnTime($timestamp, $format = null) {
        if ($timestamp == null) {
            return 'No time given';
        }
        if ($format == null) {
            $format = 'd/m/Y';
        }
        return date($format, $timestamp);
    }
}
?>
