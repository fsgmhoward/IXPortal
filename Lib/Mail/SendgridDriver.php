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

    protected function isSuccess($response)
    {
        if (strpos(strval($code = $response->statusCode()), '20') === 0) {
            return true;
        } else {
            $this->lastError = $code;
            return false;
        }
    }

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
        return $this->isSuccess($response);
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

    public function subscribe($email, $lastName, $firstName = null, $listId = null)
    {
        $newRecipient = array(
            array(
                'email' => $email,
                'last_name' => $lastName
            )
        );
        if ($firstName) {
            $newRecipient[0]['first_name'] = $firstName;
        }
        $listId = $listId ?: $this->configArray['list_id'];
        $response = $this->instance->client->contactdb()->recipients()->post($newRecipient);
        if ($this->isSuccess($response)) {
            $recipientId = json_decode($response->body())->persisted_recipients[0];
        } else {
            return false;
        }
        $response = $this->instance->client->contactdb()->lists()->_($listId)->recipients()->_($recipientId)->post();
        return $this->isSuccess($response);
    }

    public function unsubscribe($email, $listId = null) {
        $response = $this->instance->client->contactdb()->recipients()->search()->get(null, array("email" => $email));
        if ($this->isSuccess($response)) {
            if (($recipients = json_decode($response->body())->recipients)) {
                $recipientId = $recipients[0]->id;
            } else {
                $this->lastError = 404;
                return false;
            }
        } else {
            return false;
        }
        $listId = $listId ?: $this->configArray['list_id'];
        $response = $this->instance->client->contactdb()->lists()->_($listId)->recipients()->_($recipientId)
            ->delete(null, array('recipient_id' => $recipientId, 'list_id' => $listId));
        return $this->isSuccess($response);
    }
}