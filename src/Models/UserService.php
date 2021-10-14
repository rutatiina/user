<?php

namespace Rutatiina\User\Models;

use Rutatiina\Tenant\Scopes\TenantIdScope;
use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    protected $connection = 'system';

    protected $table = 'rg_service_users';

    protected $primaryKey = 'id';

    //do NOT apply the TenantIdScope scope to this model because login will not work

    public function user()
    {
        return $this->hasOne('Rutatiina\User\Models\User', 'id', 'user_id');
    }

    public function tenant()
    {
        return $this->hasOne('Rutatiina\Tenant\Models\Tenant', 'id', 'tenant_id');
    }
}
