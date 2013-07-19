<?php

/**
 * @author Nguyen Anh Tien
 */
class MailSender
{

    public static function sendMail($subject, $address, $name, $content)
    { 
        $yiic_path = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'yiic';
        $params = "\"{$subject}\" \"{$address}\" \"{$name}\" \"{$content}\"";
        $exec_cmd = "{$yiic_path} sendemail {$params} > /dev/null 2>&1 &";
        echo $exec_cmd;
    }

}

?>