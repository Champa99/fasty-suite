<?php

namespace App\Http\Middleware;

use Closure;
use SecureRoute;
use RouteGuard;
use Route;
use User;
use App\Packages\User\Session;

class Authenticate
{
    /**
     * Authenticate the user if he does an action that requires authentication
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$uri = $request->path();
		$routeInfo = SecureRoute::getRoute($uri);
		
		if($routeInfo === null) {

			// If we're in a local env, we can let the unsecured routes go by
			// Otherwise, we throw a 404

			return (config('app.env') !== 'local') ? abort(404) : $next($request);
		}

		if(session()->has('user_session')) {

			// If a browser session exists...

			$sessionToken = Session::hashToken(session('user_session'));
			User::loadInfo($sessionToken);
			
			RouteGuard::setUserGroup(User::getInfo()->group_id);
			RouteGuard::setUserPerm(User::getGroupInfo());

			if($routeInfo['perm_group'] == 0 && $routeInfo['perm'] == 0) {

				// If the route doesnt have any group requirements, we let the user pass

				return $next($request);
			} else {

				// Lets check if the user has the required privileges

				if(RouteGuard::perm($routeInfo['perm_group'], $routeInfo['perm'])) {

					// If the user has all of the privileges, let him pass

					return $next($request);
				} else {

					// Else we throw an authorization error

					return abort(401, 'Unauthorized access, no group/user permission');
				}
			}

			return $next($request);
		}

		return redirect('/login');
    }
}