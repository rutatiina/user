<?php

namespace Rutatiina\User\Models;

use Illuminate\Database\Eloquent\Model;
use Rutatiina\Tenant\Scopes\TenantIdScope;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetails extends Model
{
    use SoftDeletes;
    
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

        //NOTE:: this model does NOT need the tenant scope because the user details are for a user no matter what tenant they belong to.
        //user details are only dependant on the user
        // static::addGlobalScope(new TenantIdScope);
    }

    public function getOnLoginUrlAttribute()
    {
    	if ($this->on_login == 'show-dashboard') return '/'; //'/financial-accounts/dashboard';
    	if ($this->on_login == 'show-pos') return '/pos';

        return '/';
    }

}
