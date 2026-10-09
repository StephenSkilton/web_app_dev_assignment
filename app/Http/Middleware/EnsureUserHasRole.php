<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Usage in routes: ->middleware('role:admin')
     * or for more than one allowed role: ->middleware('role:admin,customer')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles, true)) {
            abort(403, 'You do not have access to this page.');
        }

        return $next($request);
    }
}
