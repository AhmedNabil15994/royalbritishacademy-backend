<?php

namespace Modules\Trainer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChatWithTrainerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    }
}
