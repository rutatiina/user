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
    {}

    public function setup()
    {
    	Role::query()->delete();
    	Permission::query()->delete();

    	//$tenantId = Auth::user()->tenant->id;
    	$tenantId = 0;


    	Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'users.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'users.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'users.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'users.delete']);

    	Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'permissions.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'permissions.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'permissions.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'permissions.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'roles.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'roles.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'roles.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'roles.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'contacts.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'contacts.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'contacts.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'contacts.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'items.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'items.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'items.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'items.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.bank.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.bank.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.bank.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.bank.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.accounts.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.accounts.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.accounts.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'banking.accounts.delete']);

        //
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.dashboard.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.dashboard.customize']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.estimates.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.estimates.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.estimates.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.estimates.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.retainer-invoices.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.retainer-invoices.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.retainer-invoices.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.retainer-invoices.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.sales-orders.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.sales-orders.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.sales-orders.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.sales-orders.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.invoices.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.invoices.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.invoices.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.invoices.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.receipts.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.receipts.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.receipts.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.receipts.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.recurring-invoices.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.recurring-invoices.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.recurring-invoices.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.recurring-invoices.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.credit-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.credit-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.credit-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.sales.credit-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.expenses.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.expenses.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.expenses.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.expenses.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-expenses.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-expenses.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-expenses.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-expenses.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.purchase-orders.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.purchase-orders.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.purchase-orders.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.purchase-orders.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.bills.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.bills.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.bills.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.bills.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.payments.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.payments.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.payments.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.payments.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-bills.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-bills.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-bills.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.recurring-bills.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.debit-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.debit-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.debit-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.purchases.debit-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-received-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-received-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-received-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-received-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.delivery-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.delivery-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.delivery-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.delivery-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-issued-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-issued-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-issued-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-issued-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-returned-notes.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-returned-notes.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-returned-notes.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.inventory.goods-returned-notes.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.drafts.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.drafts.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.drafts.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.drafts.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.journals.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.journals.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.journals.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.journals.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.chat-of-accounts.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.chat-of-accounts.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.chat-of-accounts.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.chat-of-accounts.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.transactions.imports.view']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.transactions.imports.create']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.transactions.imports.edit']);
        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.transactions.imports.delete']);

        Permission::firstOrCreate(['tenant_id' => $tenantId, 'name' => 'accounting.reports.view']);

        return 'setup complete @' . time();
    }

    public function index(Request $request)
    {
        //load the vue version of the app
        if (!FacadesRequest::wantsJson()) {
            return view('l-limitless-bs4.layout_2-ltr-default.appVue');
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
        return view('l-limitless-bs4.layout_2-ltr-default.appVue');
    }

    public function count()
    {
        return Permission::count();
    }

}
