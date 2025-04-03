<?php

namespace NotificationChannels\WhatsApp;

class Message
{
    // Message structure here
    public $body;
    public $recipient;

    public static function create($body = '')
    {
        return new static($body);
    }

    public function __construct($body = '')
    {
        if (! empty($body)) {
            $this->body = trim($body);
        }
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }
}
