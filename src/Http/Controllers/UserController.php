<?php

namespace Rutatiina\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Rutatiina\User\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Rutatiina\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Rutatiina\Qbuks\Models\ServiceUser;
use Rutatiina\Contact\Models\Contact;
use Rutatiina\Contact\Models\ContactPerson;
use Rutatiina\Globals\Services\Countries as ClassesCountries;
use Rutatiina\Globals\Services\Currencies as ClassesCurrencies;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    private $onLoginOptions;

    public function __construct()
    {
        $this->middleware('permission:users.view');
        $this->middleware('permission:users.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users.update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users.delete', ['only' => ['destroy']]);


        $this->onLoginOptions = [
            [
                'value' => 'show-dashboard',
                'text' => 'Show dashboard'
            ],
            [
                'value' => 'show-pos',
                'text' => 'Show Point of sales'
            ],
            [
                'value' => 'show-items',
                'text' => 'Show items'
            ],
            [
                'value' => 'show-contacts',
                'text' => 'Show contacts'
            ],
            [
                'value' => 'show-invoices',
                'text' => 'Show invoices'
            ],
            [
                'value' => 'show-bills',
                'text' => 'Show bills'
            ]
        ];
    }

    public function index(Request $request)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson())
        {
            return view('ui.limitless::layout_2-ltr-default.appVue');
        }

        $per_page = ($request->per_page) ? $request->per_page : 20;

        //$users = ServiceUser::with('user')->where('service_id', 1)->where('tenant_id', Auth::user()->tenant->id)->paginate($per_page);

        $tenant = Auth::user()->tenant;

        //query to get users who have given service
        if ($request->pagination && ($request->pagination == false || $request->pagination == 'false'))
        {
            $users = User::with('permissions')->whereHas('services', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id);
                $query->where('service_id', 1);
            })->limit(50)->get();

            return $users;
        }
        else
        {
            $users = User::with('permissions')->whereHas('services', function ($query) use ($tenant) {
                $query->where('tenant_id', $tenant->id);
                $query->where('service_id', 1);
            })->paginate($per_page);

            return ['tableData' => $users];
        }

    }

    public function create()
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('ui.limitless::layout_2-ltr-default.appVue');
        }

        $contact = new User;
        $attributes = $contact->rgGetAttributes();

        $attributes['_method'] = 'POST';

        $data = [
            'pageTitle' => 'Create User',
            'urlPost' => '/users', #required
            'onLoginOptions' => $this->onLoginOptions,
            'attributes' => $attributes,
        ];

        if (FacadesRequest::wantsJson()) {
            return $data;
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails())
        {
            return [
                'status' => false,
                'messages' => $validator->errors()->all()
            ];
        }

        DB::connection('system')->beginTransaction();

        try
        {
            //create the user
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            //give user access to current tenant
            $ServiceUser = new ServiceUser;
            $ServiceUser->service_id = 1;
            $ServiceUser->user_id = $user->id;
            $ServiceUser->tenant_id = Auth::user()->tenant->id;
            $ServiceUser->save();

            $userDetails = new UserDetails;

            $userDetails->user_id = $user->id;
            $userDetails->tenant_id = Auth::user()->tenant->id;
            $userDetails->on_login = $request->input('details.on_login');
            $userDetails->salutation = $request->input('details.salutation');
            //$userDetails->first_name = $request->first_name;
            //$userDetails->middle_name = $request->middle_name;
            //$userDetails->surname = $request->surname;
            //$userDetails->country = $request->country;
            //$userDetails->zip_code = $request->zip_code;
            //$userDetails->mobile = $request->mobile;
            //$userDetails->profile_image = $request->profile_image;

            $userDetails->billing_address_attention = $request->input('details.billing_address_attention');
            $userDetails->billing_address_street1 = $request->input('details.billing_address_street1');
            $userDetails->billing_address_street2 = $request->input('details.billing_address_street2');
            $userDetails->billing_address_city = $request->input('details.billing_address_city');
            $userDetails->billing_address_state = $request->input('details.billing_address_state');
            $userDetails->billing_address_zip_code = $request->input('details.billing_address_zip_code');
            $userDetails->billing_address_country = $request->input('details.billing_address_country');
            $userDetails->billing_address_fax = $request->input('details.billing_address_fax');

            $userDetails->shipping_address_attention = $request->input('details.shipping_address_attention');
            $userDetails->shipping_address_street1 = $request->input('details.shipping_address_street1');
            $userDetails->shipping_address_street2 = $request->input('details.shipping_address_street2');
            $userDetails->shipping_address_city = $request->input('details.shipping_address_city');
            $userDetails->shipping_address_state = $request->input('details.shipping_address_state');
            $userDetails->shipping_address_zip_code = $request->input('details.shipping_address_zip_code');
            $userDetails->shipping_address_country = $request->input('details.shipping_address_country');
            $userDetails->shipping_address_fax = $request->input('details.shipping_address_fax');

            $userDetails->save();

            DB::connection('system')->commit();

            return [
                'status' => true,
                'messages' => ['User created and saved'],
                'callback' => '/users'
            ];

        }
        catch (\Exception $e)
        {
            DB::connection('system')->rollBack();

            $message = [];

            //print_r($e); exit;
            if (App::environment('local'))
            {
                $message[] = 'Error: Failed to save transaction to database.';
                $message[] = 'File: '. $e->getFile();
                $message[] = 'Line: '. $e->getLine();
                $message[] = 'Message: ' . $e->getMessage();
            }
            else
            {
                $message[] = 'Fatal Internal Error: Failed to save transaction to database. Please contact Admin';
            }

            return [
                'status' => false,
                'messages' => $message,
                'callback' => '/users'
            ];
        }
    }

    public function show($id)
    {
        $system = [
            'name' => env('APP_NAME'),
            'description' => env('APP_DESCRIPTION')
        ];

        if ($id == 'current')
        {
            $user = Auth::user();
            $user->load('details', 'permissions', 'roles');

            return [
                'user' => $user,
                'system' => $system
            ];
        }
    }

    public function edit($id)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('ui.limitless::layout_2-ltr-default.appVue');
        }

        $user = User::with('details')->find($id);
        $attributes = $user->toArray();

        $attributes['details'] = ($attributes['details'])? $attributes['details'] : (object) [];

        $attributes['_method'] = 'PATCH';

        $data = [
            'pageTitle' => 'Edit / Update User',
            'urlPost' => '/users/'.$id, #required
            'onLoginOptions' => $this->onLoginOptions,
            'attributes' => $attributes,
        ];

        if (FacadesRequest::wantsJson()) {
            return $data;
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->errors()->all()];
        }

        DB::connection('system')->beginTransaction();

        try {

            //create the user
            $user = User::find($id);
            $user->name = $request->name;
            $user->save();

            $userDetails = UserDetails::where('user_id', $id)->firstOrCreate([
                'user_id' => $id,
                'tenant_id' => Auth::user()->tenant->id,
            ]);

            $userDetails->on_login = $request->input('details.on_login');
            $userDetails->salutation = $request->input('details.salutation');;
            //$userDetails->first_name = $request->first_name;
            //$userDetails->middle_name = $request->middle_name;
            //$userDetails->surname = $request->surname;
            //$userDetails->country = $request->country;
            //$userDetails->zip_code = $request->zip_code;
            //$userDetails->mobile = $request->mobile;
            //$userDetails->profile_image = $request->profile_image;

            $userDetails->billing_address_attention = $request->input('details.billing_address_attention');
            $userDetails->billing_address_street1 = $request->input('details.billing_address_street1');
            $userDetails->billing_address_street2 = $request->input('details.billing_address_street2');
            $userDetails->billing_address_city = $request->input('details.billing_address_city');
            $userDetails->billing_address_state = $request->input('details.billing_address_state');
            $userDetails->billing_address_zip_code = $request->input('details.billing_address_zip_code');
            $userDetails->billing_address_country = $request->input('details.billing_address_country');
            $userDetails->billing_address_fax = $request->input('details.billing_address_fax');

            $userDetails->shipping_address_attention = $request->input('details.shipping_address_attention');
            $userDetails->shipping_address_street1 = $request->input('details.shipping_address_street1');
            $userDetails->shipping_address_street2 = $request->input('details.shipping_address_street2');
            $userDetails->shipping_address_city = $request->input('details.shipping_address_city');
            $userDetails->shipping_address_state = $request->input('details.shipping_address_state');
            $userDetails->shipping_address_zip_code = $request->input('details.shipping_address_zip_code');
            $userDetails->shipping_address_country = $request->input('details.shipping_address_country');
            $userDetails->shipping_address_fax = $request->input('details.shipping_address_fax');

            $userDetails->save();

            DB::connection('system')->commit();

            return [
                'status' => true,
                'messages' => ['User details updated'],
                'callback' => '/users'
            ];

        }
        catch (\Exception $e)
        {
            DB::connection('system')->rollBack();

            $message = [];

            if (App::environment('local'))
            {
                $message[] = 'Error: Failed to save user details to database.';
                $message[] = 'File: '. $e->getFile();
                $message[] = 'Line: '. $e->getLine();
                $message[] = 'Message: ' . $e->getMessage();
            }
            else
            {
                $message[] = 'Fatal Internal Error: Failed to save user details to database. Please contact Admin';
            }

            return [
                'status' => false,
                'messages' => $message,
                'callback' => ''
            ];
        }
    }

    public function destroy($id)
    {}
}
