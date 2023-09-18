<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class VendorStatusChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $desiredStatus
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $status): Response
    {   
        // Check the user's status
        if ($request->user()->status !== $status) {
            // User has a status other than "active," redirect to home
            $not_error = [
                'message' => 'Your Vendor Account is not Activated, Please wait for Admin to Activate your Account.',
                'alert-type' => 'info',
            ];

            return redirect('/')
                ->with($not_error)
                ->setStatusCode(403); // Forbidden status code
        } 

        // If the user's status is "active," allow access to the next middleware or route
        return $next($request);
    }
}

