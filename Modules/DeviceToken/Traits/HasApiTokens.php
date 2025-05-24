<?php

namespace Modules\DeviceToken\Traits;

use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

trait HasApiTokens
{
    use SanctumHasApiTokens;


    public function sendMobileNotify($tokens, $googleAPIKeyType = 'main_app')
    {
        $locale = app()->getLocale();
        if (count($tokens) > 0) {
            $data = [
                'title' => __('login'),
                'body' => __('Your Account logged in in other device'),
                'type' => 'other_device_login',
                'id' => null,
            ];
            $this->send($data, $tokens, $googleAPIKeyType);
        }
        return true;
    }
    /**
     * @param $request
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public function createToken($request, $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'os' => $request->os ?? 'desktop',
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    /**
     * @param $request
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public function updateOrCreateToken($request, $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->where('name', $name)->first();

        if ($token) {

            $token->update([
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'abilities' => $abilities,
                'firebase_token' => $request->firebase_token ?? $token->firebase_token,
            ]);

        } else {

            $token = $this->tokens()->create([
                'name' => $name,
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'abilities' => $abilities,
                'os' => $request->os ?? 'ios',
                'firebase_token' => $request->firebase_token ?? null,
            ]);
        }

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function getLastLoginAttribute()
    {
        $response['label'] = '<i class="fa fa-circle text-red" style="color: red"></i>';
        $response['time'] = __('devicetoken::dashboard.devices.message.not_defined');
        $last_device = $this->tokens()->whereNotNull('last_used_at')->orderBy('last_used_at')->first();
        return $last_device ? $last_device->last_used : (object)$response;
    }
}
