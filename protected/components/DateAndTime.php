<?php
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

    /**
	 * @author Pham Tri Thai
     * @return human time readable
	 */
	public static function humanReadableTime($time) {
        $second = time() - strtotime($time);
        $result = '';
        switch (true) {
            case ($second < 10):
                $result = 'a few second ago';
                break;
            case ($second < 60 * 2):
                $result = 'one minute ago';
                break;
            case ($second < 60 * 50):
                $result = (integer)($second / 60).' minute ago';
                break;
            case ($second < 60 * 60 * 2):
                $result = 'one hour ago';
                break;
            case ($second < 60 * 60 * 24):
                $result = (integer)($second / (60 * 60)).' hour ago';
                break;
            default:
                $result = date('d/m/Y', strtotime($time));
                break;
        }
        return $result;
	}
}
?>
