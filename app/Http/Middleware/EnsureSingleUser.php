<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureSingleUser
{

    public function handle(Request $request, Closure $next)
    {
        if (User::count() > 0 && $request->route()->named('register')) {
            return redirect()->route('login')->with('error', 'O cadastro está fechado. Apenas um usuário é permitido.');
        }

        return $next($request);
    }

}
