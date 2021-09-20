<?php

namespace Rutatiina\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Rutatiina\User\Models\GroupUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Rutatiina\User\Models\User;
use Spatie\Permission\Models\Role;


class GroupUserController extends Controller
{

    public function __construct()
    {}

    public function index()
	{}

    public function create(Request $request)
	{}

    public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'group_ids' => ['required', 'array'],
			'user_ids' => ['required', 'array'],
		]);

		if ($validator->fails()) {
			return redirect()->route('groups.index', ['tab'=>$request->tab])->withErrors($validator);
		}

		$tenant_id = Auth::user()->tenant->id;

		foreach ($request->user_ids as $user_id) {
			foreach ($request->group_ids as $group_id) {
				$GroupUser = new GroupUser;
				$GroupUser->tenant_id = $tenant_id;
				$GroupUser->group_id = $group_id;
				$GroupUser->user_id = $user_id;
				$GroupUser->save();
			}
		}

		return redirect()->back()->with(['success' => 'User(s) assigned to group(s).']);
	}

    public function show($id)
	{}

    public function edit($id)
	{}

    public function update(Request $request)
	{}

    public function destroy($id)
	{}
}
