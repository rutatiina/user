<?php

namespace Rutatiina\User\Models;

use Rutatiina\Tenant\Scopes\TenantIdScope;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantIdScope);
    }

}
