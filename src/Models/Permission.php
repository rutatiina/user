<?php

namespace Rutatiina\User\Models;

use Rutatiina\Tenant\Scopes\TenantIdScope;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

//        static::addGlobalScope(new TenantIdScope); //this line is to be removed
    }

}
