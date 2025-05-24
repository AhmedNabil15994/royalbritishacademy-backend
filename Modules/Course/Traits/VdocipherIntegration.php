<?php

namespace Modules\Course\Traits;

use Error;
use Illuminate\Support\Facades\Http;

trait VdocipherIntegration
{
    public function ObtainCredentials($title)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos?title=" . $title,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Apisecret " . env('VDOCIPHER_KEY')
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 0, 'message' => "cURL Error #:" . $err, 'data' => []]);
        } else {
            $data = json_decode($response);

            return response()->json(['status' => 1, 'message' => 'success', 'data' => $data ?: null]);
        }
    }

    public function upload($credential, $file)
    {

        $curl = curl_init();
        $uploadCredentials = json_decode($credential->client_payload);

        $mime = $file->getMimeType();
        $info = pathinfo($file);
        $name = $info['basename'];
        $file = new \CURLFile($file, $mime, $name);
        $ch = curl_init($uploadCredentials->uploadLink);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'policy' => $uploadCredentials->policy,
            'key' => $uploadCredentials->key,
            'x-amz-signature' => $uploadCredentials->{'x-amz-signature'},
            'x-amz-algorithm' => $uploadCredentials->{'x-amz-algorithm'},
            'x-amz-date' => $uploadCredentials->{'x-amz-date'},
            'x-amz-credential' => $uploadCredentials->{'x-amz-credential'},
            'success_action_status' => 201,
            'success_action_redirect' => '',
            'file' => $file,
            'contentType' => 'multipart/form-data',
        ]);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // get response from the server
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($ch);

        if (!$err && $httpcode === 201) {

            // upload is successful
            // update database
            return ['status' => 1, 'message' => 'success'];
        } else {
            // write to error logs
            return "upload failed due to " . (($err) ? $err : $response);
        }
    }

    public static function getVideoStatus($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos/" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret " . env('VDOCIPHER_KEY'),
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 0, 'message' => "cURL Error #:" . $err, 'data' => []]);
        } else {
            $data = json_decode($response);
            return response()->json(['status' => 1, 'message' => 'success', 'data' => $data ? $data : null]);
        }
    }

    public function delete($ids)
    {
        $curl = curl_init();
        $ids = (array) $ids;
        $ids = implode(',', $ids);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos?videos=" . $ids,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret " . env('VDOCIPHER_KEY'),
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 0, 'message' => "cURL Error #:" . $err, 'data' => []]);
        } else {
            $data = json_decode($response);
            return response()->json(['status' => 1, 'message' => 'success', 'data' => $data ? $data : null]);
        }
    }

    public function getOtp($video_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos/" . $video_id . "/otp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                "ttl" => 300,
            ]),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret " . env('VDOCIPHER_KEY'),
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 0, 'message' => "cURL Error #:" . $err, 'data' => []]);
        } else {
            $data = json_decode($response);
            return response()->json(['status' => 1, 'message' => 'success', 'data' => $data ? $data : null]);
        }
    }

    public function getVideos($id = false)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos" . ($id != false ? "?q=" . $id : ""),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret " . env('VDOCIPHER_KEY'),
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return response()->json(['status' => 0, 'message' => "cURL Error #:" . $err, 'data' => []]);
        } else {
            $data = json_decode($response);
            return response()->json(['status' => 1, 'message' => 'success', 'data' => $data && !empty($data->rows) ? $data->rows : []]);
        }
    }
}
