<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CheckVendorStatus
{   
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        // For the checkVendorStatus Policy added here AuthServiceProvider::class
        if (! Gate::allows('checkVendorStatus')) {
            return redirect('/')
                ->with([
                    'message' => 'Your Vendor Account is not Activated, Please wait for your Account to be Activated',
                    'alert-type' => 'info',
                ])
                ->setStatusCode(403);
        }

        return $next($request);
    }
}

