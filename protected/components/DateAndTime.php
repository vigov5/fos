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
                $result = 'about a few seconds ago';
                break;
            case ($second < 60 * 2):
                $result = 'about one minute ago';
                break;
            case ($second < 60 * 50):
                $result = 'about '.(integer)($second / 60).' minutes ago';
                break;
            case ($second < 60 * 60 * 2):
                $result = 'about one hour ago';
                break;
            case ($second < 60 * 60 * 24):
                $result = 'about '.(integer)($second / (60 * 60)).' hours ago';
                break;
            default:
                $result = 'at '.date('d/m/Y', strtotime($time));
                break;
        }
        return $result;
	}
}
?>
