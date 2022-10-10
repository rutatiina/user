<?php

namespace Rutatiina\User\Models;

use Laravel\Passport\HasApiTokens;
use Rutatiina\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use SoftDeletes;
    use HasRoles, HasApiTokens, Notifiable;

    protected $guard_name = 'web'; //Spatie

    protected $connection = 'system';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category', 'name', 'first_name', 'other_name', 'email', 'password', 'user_group_id', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rgGetAttributes()
    {
        $attributes = [];
        $describeTable =  \DB::select('describe ' . $this->getTable());

        foreach ($describeTable  as $row) {

            if (in_array($row->Field, ['id', 'created_at', 'updated_at', 'deleted_at', 'tenant_id', 'user_id'])) continue;

            if (in_array($row->Field, ['currencies', 'taxes'])) {
                $attributes[$row->Field] = [];
                continue;
            }

            if ($row->Default == '[]') {
                $attributes[$row->Field] = [];
            } else {
                $attributes[$row->Field] = '';
            }
        }

        //add the relationships
        $attributes['details'] = json_decode('{"salutation":""}');

        return $attributes;
    }

    public function services()
    {
        return $this->hasMany('Rutatiina\User\Models\UserService', 'user_id', 'id');
    }

    public function getTenantAttribute()
    {
    	if(session()->has('tenant_id')) {
			return Tenant::find(session('tenant_id'));
		}

        return null;
    }

    public function details()
    {
        return $this->hasOne('Rutatiina\User\Models\UserDetails', 'user_id', 'id');
    }

    public function getSearchableColumns()
    {
        return Schema::connection('tenant')->getColumnListing($this->table);
    }

}
