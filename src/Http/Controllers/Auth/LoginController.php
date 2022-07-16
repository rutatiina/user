<?php

namespace Rutatiina\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/financial-accounts/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    #rutatiina
    public function showLoginForm()
    {
    	#rutatiina
        //return view('limitless.auth.login');
		//return view('d-dashcore.login');
        return view('ui.limitless::indexVue');
    }

    /**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
    protected function authenticated(Request $request, $user)
	{
		//$service = $user->services->first();

		$user->whereHas('services', function ($query) {
			$query->where('service_id', 1);
		})->first();

		$service = $user->services()->first();

        //if the user has no service assigned to them
		if(!$service) 
        {
            session([
				'tenant_id' => 0,
			]);

			return redirect(route('organisations.create'));
		}
        
        session([
            'tenant_id' => $service->tenant_id,
        ]);

        //var_dump($user->details); exit;

        if ($user->details && $user->details->on_login_url)
        {
            return redirect($user->details->on_login_url);
            //return redirect()->intended($user->details->on_login_url);
        }

        return null;
    
	}
}
