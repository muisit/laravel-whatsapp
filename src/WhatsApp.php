<?php

namespace NotificationChannels\WhatsApp;

use Exception;
use NotificationChannels\WhatsApp\Exceptions\CouldNotSendNotification;

class WhatsApp
{
    /**
     * WhatsApp constructor.
     */
    public function __construct()
    {
    }

    /**
     * Send the Message.
     * @param Message $message
     * @return
     * @throws CouldNotSendNotification
     */
    public function send(Message $message)
    {
        try {
            $token = config('services.whatsapp.token');
            $phoneId = config('services.whatsapp.phoneid');
            $cloudapi = config('services.whatsapp.cloudapi', 'https://graph.facebook.com/v22.0');

            $message = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => $message->recipient,
                "type" => "text",
                "text" => [
                    "preview_url" => true,
                    "body" => $message->body
                ]
            ];

            $c = curl_init();
            $urlencodeddata = json_encode($message);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTREDIR, 7); // follow all redirects
            curl_setopt($c, CURLOPT_POSTFIELDS, $urlencodeddata);
            $headers['Authorization'] = "Bearer $token";
            $headers['Accept'] = 'application/json, text/javascript, */*; q=0.01';
            $headers["Content-Type"] = "application/json";
            curl_setopt($c, CURLOPT_HTTPHEADER, $headerarray);
            curl_setopt($this->_session, CURLOPT_URL, $cloudapi . '/messages');
            curl_setopt($this->_session, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($c);

            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            $error = curl_error($c);

            if ($status !== 200 || $error != CURL_OK) {
                throw CouldNotSendNotification::serviceRespondedWithAnError("Invalid return value $status/$error");
            }
            if (is_string($output)) {
                $output = json_decode($output);
            }
            return $output;
        }
        catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
