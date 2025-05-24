<?php

namespace Modules\Notification\Repositories\Dashboard;

use Illuminate\Http\Request;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Notification\Entities\GeneralNotification;
use Modules\User\Entities\FirebaseToken;

class NotificationRepository extends CrudRepository
{
    protected $token;

    public function __construct()
    {
        $this->token = new FirebaseToken;
        parent::__construct(GeneralNotification::class);
    }

    public function getAllFcmTokens()
    {
        return $this->token->pluck('firebase_token','lang')->toArray();
    }

    public function getAllUserTokens($userId)
    {
        return $this->token->where('user_id', $userId)->pluck('firebase_token')->toArray();
    }

    public function setAllUserTokensNull($userId)
    {
        return $this->token->where('user_id', $userId)->update(['user_id'=>null]);
    }

    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
