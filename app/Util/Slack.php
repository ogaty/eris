<?php

namespace App\Util;

class Slack {

    public function send($msg = null) {
        if (is_null($msg)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('SLACK_URL'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }

}
