<?php

namespace Rutatiina\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Rutatiina\User\Models\Group;
use Rutatiina\User\Models\GroupUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Rutatiina\User\Models\User;
use Spatie\Permission\Models\Role;


class GroupController extends Controller
{

    public function __construct()
    {}

    public function index()
    {
        return view('limitless.groups.index')->with([
            'users' => User::all(),
            'groups' => Group::all(),
			'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        $request->flash();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:250'],
            'description' => 'required|string|max:250',
            'role_ids' => 'required|array',
        ]);

        if ($validator->fails()) {
			return redirect()->route('groups.index', ['tab'=>$request->tab])->withErrors($validator);
        }

        $Group = new Group;
        $Group->tenant_id = Auth::user()->tenant->id;
        $Group->name = $request->name;
        $Group->description = $request->description;
        $Group->role_ids = json_encode($request->role_ids);
        $Group->save();

        return redirect()->back()->with(['success' => 'Group created.']);
    }

    public function show($txnId)
	{
		return $this->index();
    }

    public function edit($txnId)
	{}

    public function update(Request $request) {}

    public function destroy() {}

    public function assign(Request $request)
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
}
