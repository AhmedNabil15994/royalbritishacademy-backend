<?php

namespace Modules\Core\Traits\Api\Cache;

class HomeModelsCacheHandler
{
    public function refreshHomeCache($mdoel)
    {
        static::created(function ($model) {
            WebhookCall::create()
                ->url('https://app.toucart.com/tenancy-webhook')
                ->payload([
                    'event' => 'TENANT_CREATED',
                    'queue' => $model->accountType->slug,
                    'tenant_id' => $model->id,
                ])
                ->useSecret(config('webhook-server.signature_secret'))
                ->dispatch();
        });

        static::updated(function ($model) {
            if ($model->wasChanged('domain', 'subdomain')) {
                WebhookCall::create()
                    ->url('https://app.toucart.com/tenancy-webhook')
                    ->payload([
                        'event' => 'TENANT_DOMAIN_UPDATED',
                        'queue' => $model->accountType->slug,
                        'tenant_id' => $model->id,
                    ])
                    ->useSecret(config('webhook-server.signature_secret'))
                    ->dispatch();
            }
        });

        static::deleted(function () {
            
        });
    }
}