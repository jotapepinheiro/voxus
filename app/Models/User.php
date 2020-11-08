<?php

namespace App\Models;

use App\Traits\JWT;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, JWT;
    use EntrustUserTrait {
        can as entrustCan;
    }

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime:d/m/Y H:i:s',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    /**
     * @return BelongsToMany
     */
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'location_user', 'user_id', 'location_id');
    }

    /**
     * Define all permissions for role Super Admin
     *
     * @param $permission
     * @param bool $requireAll
     * @return bool
     */
    public function can($permission, $requireAll = false)
    {
        if (Auth::user()->hasRole('super')) {
            return true;
        }

        return $this->entrustCan($permission, $requireAll);
    }

}
