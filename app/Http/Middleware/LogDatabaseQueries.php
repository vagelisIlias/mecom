<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class LogDatabaseQueries
{
    public function handle($request, Closure $next)
    {
        DB::listen(function ($query) 
        {
            logger($query->sql, $query->bindings);
        });

        return $next($request);
    }
}
