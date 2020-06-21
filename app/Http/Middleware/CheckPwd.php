<?php

namespace App\Http\Middleware;

use App\ShortUrl;
use Closure;

class CheckPwd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ShortUrl = ShortUrl::where('code', $request->path())->get()[0];
        if ($ShortUrl->password != null) {
            return redirect()->route('confirm.password', $ShortUrl->code);
        }

        return $next($request);
    }
}
