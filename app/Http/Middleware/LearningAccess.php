<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LearningAccess
{
    public function handle(Request $request, Closure $next, ?string $role = null)
    {
        abort_unless($request->user() && $request->user()->status === 'Active', 403, 'Your account is inactive. Contact the administrator.');
        abort_unless(in_array($request->user()->role, ['admin', 'student'], true), 403);
        abort_if($role && $request->user()->role !== $role, 403);

        return $next($request);
    }
}
