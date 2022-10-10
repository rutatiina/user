<?php

namespace Rutatiina\User\Models;

use Illuminate\Database\Eloquent\Model;
use Rutatiina\Tenant\Scopes\TenantIdScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupUser extends Model
{
    use SoftDeletes;
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_users';

    protected $primaryKey = 'id';

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

    public function tenant()
    {
        return $this->hasOne('Rutatiina\Tenant\Models\Tenant', 'id', 'tenant_id');
    }

}
