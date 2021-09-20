<?php

namespace Rutatiina\User\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rutatiina\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{

    public function __construct()
    {}

    public function index(Request $request)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('l-limitless-bs4.layout_2-ltr-default.appVue');
        }

        $perPage = ($request->per_page) ? $request->per_page : 20;

        if ($request->pagination && ($request->pagination == false || $request->pagination == 'false')) {
            return Role::limit(50)->get();
        }

        return [
            'tableData' => Role::paginate($perPage)
        ];

    }

    public function create(Request $request)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('l-limitless-bs4.layout_2-ltr-default.appVue');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->errors()->all()];
        }

        $role = Role::create([
        	'tenant_id' => Auth::user()->tenant->id,
        	'name' => $request->name
		]);
        $role->syncPermissions($request->permissions);

        return ['status' => true, 'messages' => ['Role created']];
    }

    public function show($txnId) {
    }

    public function edit($txnId) {}

    public function update(Request $request) {}

    public function destroy() {}

    public function count()
    {
        return Role::count();
    }

    public function assign(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('l-limitless-bs4.layout_2-ltr-default.appVue');
        }

        $validator = Validator::make($request->all(), [
			'user_id' => ['required'],
			'roles' => 'required|array',
		]);

		if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->errors()->all()];
		}

		$user = User::find($request->user_id);
		$user->assignRole($request->role);

        return ['status' => true, 'messages' => ['Role(s) assigned to user.']];
    }
}
