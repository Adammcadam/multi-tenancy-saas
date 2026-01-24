<?php

namespace App\Http\Middleware;

use App\Services\OrganisationContext;
use Closure;
use Illuminate\Http\Request;

class EnsureActiveOrganisation
{
    public function handle(Request $request, Closure $next)
    {
        if (! app(OrganisationContext::class)->current()) {
            abort(403, 'No active organisation selected.');
        }

        return $next($request);
    }
}
