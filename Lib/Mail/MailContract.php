<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib\Mail;

interface MailContract
{
    /**
     * Initialize the sendgrid driver class
     *
     * @param array $configArray Array of configuration
     */
    public function __construct($configArray);

    /**
     * Get error code & name of the last request
     *
     * @return array
     */
    public function getLastError();

    /**
     * Send email
     *
     * @param string $to      Receiver
     * @param string $subject Title of the email
     * @param string|array $content When it is an array, data is compulsory, attachment is optional
     * @param string $from    Sender, default is set in config
     * @param string $replyTo Reply-to address, use the one set in config when it is null
     * @return boolean        Return whether the request is successful
     */
    public function send($to, $subject, $content, $from = null, $replyTo = null);

    /**
     * Render a template and use it as email content
     *
     * @param string $to      Receiver
     * @param string $subject Title of the email
     * @param string $template Name of template to be rendered
     * @param array  $parameter Parameter passed to the template renderer
     * @param string $extraContent Extra content to be included such as attachments
     * @param string $from    Sender, default is set in config
     * @param string $replyTo Reply-to address, use the one set in config when it is null
     * @return boolean        Return whether the request is successful
     */
    public function sendTemplate($to, $subject,
                                 $template, $parameter = array(), $extraContent = null,
                                 $from = null, $replyTo = null);
}