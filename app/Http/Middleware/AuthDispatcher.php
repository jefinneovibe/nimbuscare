<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use MongoDB\BSON\ObjectID;
use Illuminate\Support\Facades\Session;


class AuthDispatcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		// dd(Auth::user()->isActive);
		if (!Auth::check() || Auth::user()->isActive==0) {
            Auth::logout();
            Session::flush();   
	        return redirect('/');
	    } elseif (Auth::check()) {
            $role = Auth::user()->roleDetail('name');
            if ($role['name'] == 'Coordinator') {
                $user = User::find(Auth::user()->_id);
                $assigned_agent = new ObjectID($user['assigned_agent']['id']);
            } else {
                $assigned_agent = '';
            }
            if (isset(Auth::user()->permission['permissionCheck'])) {
                $assigned_permissions=Auth::user()->permission['permissionCheck'];
            } else {
                $assigned_permissions=[];
            }
           
            session(['role' => $role['name'],
            'user_name' => Auth::user()->name,
            'permissions' => $role['permissions'],
            'abbreviation' => $role['abbreviation'],
            'assigned_agent' => $assigned_agent,
            'assigned_permissions' => $assigned_permissions,
            ]);
        } else {
		     if (Auth::user()->roleDetail('name')['name'] == "Insurer")
		    {
			    return redirect('/');
		    }
	    }
	    return $next($request);
    }
}
