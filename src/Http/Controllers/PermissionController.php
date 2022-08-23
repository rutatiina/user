<?php

namespace Rutatiina\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Rutatiina\User\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:permissions.view');
        $this->middleware('permission:permissions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permissions.update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions.delete', ['only' => ['destroy', 'deleteTxns']]);
        $this->middleware('permission:permissions.assign', ['only' => ['assign']]);
    }

    public function index(Request $request)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('ui.limitless::layout_2-ltr-default.appVue');
        }

        //$perPage = ($request->per_page) ? $request->per_page : 20;

        if (FacadesRequest::wantsJson()) {
            return rg_permissions_array();
        }
    }

    public function create(Request $request)
    {
        if ($request->user_id) {
            $user = User::find($request->user_id);
        } elseif ($request->session()->get('user_id')) {
            $user = User::find($request->session()->get('user_id'));
        } else {
            $user = User::first();
        }

        //$user->givePermissionTo('campaigns.view');

        //$permissions = $user->getAllPermissions();

        //print_r($permissions); exit;

        return view('limitless.permissions.create')->with([
            'permissions_array' => rg_permissions_array(),
            'users' => User::all(),
            'user' => $user,
        ]);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->errors()->all()];
        }

        $user = User::find($request->user_id);

        $user->syncPermissions($request->permissions);

        /*
        foreach ($request->permissions as $permission) {
            //$user->givePermissionTo($permission);
        }
        */

        return ['status' => true, 'messages' => ['User assigned permissions']];
    }

    public function show($id)
    {}

    public function edit($id)
    {}

    public function update(Request $request)
    {}

    public function assign()
    {
        return view('ui.limitless::layout_2-ltr-default.appVue');
    }

    public function count()
    {
        return Permission::count();
    }

}
