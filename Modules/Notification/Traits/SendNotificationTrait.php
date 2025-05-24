<?php

namespace Modules\Notification\Traits;

use Modules\User\Entities\FirebaseToken;

trait SendNotificationTrait
{
    public function send($data, $tokens = null)
    {
        if (is_array($tokens)) {
            $tokens = array_values(array_unique($tokens));
        } else {
            $tokens = array($tokens);
        }

        $ios = FirebaseToken::whereIn('firebase_token', $tokens)
            ->select('firebase_token')
            ->where('device_type', '2')
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        $android = FirebaseToken::whereIn('firebase_token', $tokens)
            ->where('device_type', '1')
            ->groupBy('firebase_token')
            ->pluck('firebase_token');

        if ($ios) {
            $regIdIOS = array_chunk(json_decode($ios), 999);
            foreach ($regIdIOS as $tokens) {
                $msg[] = $this->PushIOS($data, $tokens);
            }
        }

        if ($android) {
            $regIdAndroid = array_chunk(json_decode($android), 999);
            foreach ($regIdAndroid as $tokens) {
                $this->PushANDROID($data, $tokens);
            }
        }
    }
    public function sendTranslatedMessageToUser($data, $tokens)
    {
        $ios = $tokens->where('device_type', 'ios')->groupBy('lang');
        $androidTokens = $tokens->where('device_type', 'android')->groupBy('lang');
        if ($arIos = data_get($ios, 'en', collect())->pluck('firebase_token')) {
            $this->PushIOS($data['ar'], $arIos);
        }
        if ($enIos = data_get($ios, 'ar', collect())->pluck('firebase_token')) {
            $this->PushIOS($data['en'], $enIos);
        }
        if ($arAndroid = data_get($androidTokens, 'en', collect())->pluck('firebase_token')) {
            $this->PushANDROID($data['ar'], $arAndroid);
        }
        if ($enAndroid = data_get($androidTokens, 'ar', collect())->pluck('firebase_token')) {
            $this->PushANDROID($data['en'], $enAndroid);
        }
    }

    public function PushIOS($data, $tokens)
    {
        $notification = [
            'title' => $data['title'],
            'body' => $data['body'],
            'sound' => 'default',
            'priority' => 'high',
            'badge' => '0',
        ];

        $data = [
            "type" => $data['type'],
            "id" => $data['id'],
        ];

        $fields_ios = [
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $data,
        ];

        return $this->Push($fields_ios);
    }

    public function PushANDROID($data, $tokens)
    {
        $fcmObject = [
            'registration_ids' => $tokens,
            'priority' => 'high',
            'notification' => [
                'title' => $data['title'],
                'body' => $data['body'],
                "icon" => "launcher_icon",
            ],
            'data' => [
                "id" => $data['id'] ?? null,
                "type" => $data['type'] ?? '',
                'title' => $data['title'],
                'body' => $data['body'],
                "click_action" => "SWIFT_NOTIFICATION_CLICK",
            ],
        ];

        return $this->Push($fcmObject);
    }

    public function Push($fields)
    {
        try {
            $url = 'https://fcm.googleapis.com/fcm/send';

            $server_key = env('FCM_KEY');

            $headers = array(
                'Content-Type:application/json',
                'Authorization:key=' . $server_key,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === false) {
                info(curl_error($ch));
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            info($result);
            return $result;
        } catch (\Throwable$th) {
            //throw $th;
        }
    }
}
