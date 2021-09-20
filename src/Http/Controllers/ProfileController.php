<?php

namespace Rutatiina\User\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rutatiina\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Rutatiina\User\Models\UserDetails;
use Spatie\Activitylog\Models\Activity;
use Rutatiina\Classes\Countries as ClassesCountries;
use Rutatiina\Classes\Currencies as ClassesCurrencies;


class ProfileController extends Controller
{

    public function __construct()
    {}

    private function _user_()
    {
    	$user = Auth::user();
    	$user->slug = Str::slug($user->first_name.' '.$user->other_name);
        return $user;
    }

    public function index()
    {
    	$user = $this->_user_();
        return view('limitless.profile.index')->with([
            'user' => $user,
        ]);
    }

    public function create(Request $request)
    {}

    public function store(Request $request)
    {}

    public function show()
	{
		return $this->index();
	}

    public function edit($id)
	{
		$user = $this->_user_();
        return view('limitless.profile.edit')->with([
			'user' => $user,
			'currencies' => ClassesCurrencies::en_IN(),
            'countries' => ClassesCountries::ungrouped(),
        ]);
	}

    public function update(Request $request)
	{
		$tenant_id = Auth::user()->tenant->id;
		$user_id = Auth::id();

		$UserDetails = UserDetails::firstOrCreate(['tenant_id' => $tenant_id, 'user_id' => $user_id]);

		$UserDetails->salutation = $request->salutation;
		$UserDetails->first_name = $request->first_name;
		$UserDetails->middle_name = $request->middle_name;
		$UserDetails->surname = $request->surname;
		$UserDetails->country = $request->country;
		$UserDetails->zip_code = $request->zip_code;
		$UserDetails->mobile = $request->mobile;
		$UserDetails->profile_image = $request->profile_image;

		$UserDetails->billing_address_attention = $request->billing_address_attention;
		$UserDetails->billing_address_street1 = $request->billing_address_street1;
		$UserDetails->billing_address_street2 = $request->billing_address_street2;
		$UserDetails->billing_address_city = $request->billing_address_city;
		$UserDetails->billing_address_state = $request->billing_address_state;
		$UserDetails->billing_address_zip_code = $request->billing_address_zip_code;
		$UserDetails->billing_address_country = $request->billing_address_country;
		$UserDetails->billing_address_fax = $request->billing_address_fax;

		$UserDetails->shipping_address_attention = $request->shipping_address_attention;
		$UserDetails->shipping_address_street1 = $request->shipping_address_street1;
		$UserDetails->shipping_address_street2 = $request->shipping_address_street2;
		$UserDetails->shipping_address_city = $request->shipping_address_city;
		$UserDetails->shipping_address_state = $request->shipping_address_state;
		$UserDetails->shipping_address_zip_code = $request->shipping_address_zip_code;
		$UserDetails->shipping_address_country = $request->shipping_address_country;
		$UserDetails->shipping_address_fax = $request->shipping_address_fax;

		$UserDetails->save();

		return redirect()->back()->with(['success' => 'Details updates.']);
	}

    public function destroy()
	{}

    public function activity()
	{
		$user = $this->_user_();

		$activities = Activity::causedBy(Auth::user())->orderBy('id', 'desc')->paginate(20);
		$activities = rg_activity($activities);
        return view('limitless.profile.activity')->with([
            'user' => $user,
            'activities' => $activities,
        ]);
	}

    public function roles()
	{
		$user = $this->_user_();
        return view('limitless.profile.roles')->with([
            'user' => $user,
        ]);
	}

    public function permissions()
	{
		$user = $this->_user_();
        return view('limitless.profile.permissions')->with([
			'user' => $user,
			'permissions_array' => rg_permissions_array(),
        ]);
	}
}
