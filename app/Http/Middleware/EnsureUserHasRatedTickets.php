<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ticket;

class EnsureUserHasRatedTickets
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            $hasUnrated = Ticket::where('user_id', $user->id)
                                ->where('Booking_Status', true)
                                ->where('rated', false)
                                ->exists();

            if ($hasUnrated && !$request->routeIs('rating.create') && !$request->routeIs('rating.store')) {
                return redirect()->route('rating.create');
            }
        }

        return $next($request);
    }
}
