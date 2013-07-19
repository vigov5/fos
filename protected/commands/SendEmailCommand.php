<?php

/**
 * @author Nguyen Anh Tien
 */
class SendEmailCommand extends CConsoleCommand
{

    public function run($args)
    {
        list($subject, $address, $name, $content) = $args;
        $name = 'Mr./Ms. ' . $name;
        $message = new YiiMailMessage;
        $message->view = 'email_template';
        $message->setSubject($subject);
        $message->setTo($address);
        $message->setFrom('dontreply@framgia.com');
        $message->setBody(
            array(
                'content' => $content,
                'name' => $name,
                'subject' => $subject,
            ),
            'text/html'
        );
        Yii::app()->mail->send($message);
    }

}

?>