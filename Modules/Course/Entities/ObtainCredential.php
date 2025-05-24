<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;

class ObtainCredential extends Model
{
    protected $table = 'obtain_credentials';
    protected $fillable = [ 'client_payload' , 'api_video_id','status'];
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_link', 'api_video_id');
    }
}
