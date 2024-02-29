<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PickupLocationExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requiredValues = ['pickup_location', 'pickup_date', 'pickup_time', 'return_date', 'return_time'];

        foreach ($requiredValues as $value) {
            if (!session($value)) {
                return redirect('/reserve/itinerary');
            }
        }

        return $next($request);
    }
}
