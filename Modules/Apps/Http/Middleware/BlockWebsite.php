<?php

namespace Modules\Apps\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class BlockWebsite extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        abort(404);
    }
}
