<?php

namespace Rutatiina\User\Models;

use Rutatiina\Tenant\Scopes\TenantIdScope;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $connection = 'system';

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rg_user_details';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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

    public function getOnLoginUrlAttribute()
    {
    	if ($this->on_login == 'show-dashboard') return '/'; //'/financial-accounts/dashboard';
    	if ($this->on_login == 'show-pos') return '/pos';

        return '/';
    }

}
