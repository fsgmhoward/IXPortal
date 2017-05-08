<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib\Mail;

use Lib\Template;
use SendGrid;

class SendgridDriver implements MailContract
{
    protected $instance;
    protected $configArray;
    protected $error = array(
        '400' => 'BAD REQUEST',
        '401' => 'UNAUTHORIZED',
        '403' => 'FORBIDDEN',
        '404' => 'NOT FOUND',
        '405' => 'METHOD NOT ALLOWED',
        '413' => 'PAYLOAD TOO LARGE',
        '429' => 'TOO MANY REQUESTS',
        '500' => 'SERVER ERROR',
        '503' => 'SERVICE NOT AVAILABLE'
    );
    protected $lastError;

    public function __construct($configArray)
    {
        $this->configArray = $configArray;
        $this->instance = new SendGrid($configArray['key']);
    }

    public function getLastError()
    {
        return array(
            'code' => $this->lastError,
            'name' => $this->error[strval($this->lastError)]
        );
    }

    public function send($to, $subject, $content, $from = null, $replyTo = null)
    {
        $from = new SendGrid\Email(null, $from ?: $this->configArray['from']);
        $to = new SendGrid\Email(null, $to);
        if (is_string($content)) {
            $content = array('type' => 'text/plain', 'data' => $content);
        }
        $content = new SendGrid\Content($content['type'], $content['data']);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        if ($replyTo || $this->configArray['reply_to']) {
            $mail->setReplyTo(new SendGrid\ReplyTo($replyTo ?: $this->configArray['reply_to']));
        }
        if (isset($content['attachment'])) {
            foreach ($content['attachment'] as $id => $attachmentArray) {
                // Attachment should be BASE64 Encoded before invoke send()
                $attachment = new SendGrid\Attachment();
                $attachment->setContent($attachmentArray['content']);
                $attachment->setFilename($attachmentArray['filename']);
                $attachment->setType($attachmentArray['type']);
                $attachment->setDisposition(isset($attachmentArray['disposition']) ? $attachmentArray['disposition'] : "attachment");
                $attachment->setContentID('IXFW-Mail-SG-Attachment-'.$id);
                $mail->addAttachment($attachment);
            }
        }
        $response = $this->instance->client->mail()->send()->post($mail);
        if (strpos(strval($response->statusCode()), '20') == 0) {
            // Successfully sent!
            return true;
        } else {
            $this->lastError = $response->statusCode();
            return false;
        }
    }

    public function sendTemplate($to, $subject,
                                 $template, $parameter = array(), $extraContent = null,
                                 $from = null, $replyTo = null) {
        if ($extraContent) {
            $content = $extraContent;
        } else {
            $content = array();
        }
        $content['type'] = 'text/html';
        $content['data'] = Template::load($template, $parameter, true);
        return $this->send($to, $subject, $content, $from, $replyTo);
    }
}