<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CheckPermissions
{
    public function handle($request, Closure $next, string $permissions)
    {
        $list     = explode('|', $permissions);
        $isGuest  = Auth::guest();
        $isAccess = false;
        foreach ($list as $value) {
            if (!$isGuest && Gate::allows('policy', $value)) {
                $isAccess = true;
            }
        }
        if ($isAccess === false) {
            abort(403);
        }

        return $next($request);
    }
}