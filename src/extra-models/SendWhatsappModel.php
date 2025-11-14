<?php
/*
This model works with the WhatsApp API to send messages.
You must have the WHATSAPP_HOST, WHATSAPP_TOKEN, and WHATSAPP_NUMBER environment variables set.

@author Victor Béser
*/
class SendWhatsappModel
{

    public static function send($number, $message)
    {
        // Your code here

        if (is_array($number)) {
            foreach ($number as $value) {
                $url = EnvModel::env("WHATSAPP_HOST");
                $data = [
                    'token' => EnvModel::env("WHATSAPP_TOKEN"),
                    'number' => $value,
                    'message' => $message
                ];
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_exec($ch);

                curl_close($ch);
            }
            LogModel::log("Sent:" . implode(",", $number) . " || mensagem: " . $message);
        } else {

            $url = EnvModel::env("WHATSAPP_HOST");
            $data = [
                'token' => EnvModel::env("WHATSAPP_TOKEN"),
                'number' => $number,
                'message' => $message
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_exec($ch);

            curl_close($ch);
            LogModel::log("Sent:" . $number . " || mensagem: " . $message);
        }


    }

    // Brazil Phone Format Example
    public static function formatNumber($number)
    {

        $number = preg_replace('/\D/', '', $number);

        if (strpos($number, '55') !== 0) {
            $number = '55' . $number;
        }

        $number = preg_replace('/^55(\d{2})9(\d{8})$/', '55$1$2', $number);

        $number = $number . "@c.us";

        return $number;
    }

}