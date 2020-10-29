<?php
/**
 * Creator htm
 * Created by 2020/10/29 11:21
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Szkj\Rbac\Traits\DateTimeFormatter;

class Role extends Model
{
    use DateTimeFormatter;
    /**
     * table name
     * @var string
     */
    protected $table = 'roles';


    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection =config('database.default');

        $this->setConnection($connection);

        parent::__construct($attributes);
    }

    /**
     * @return HasOne
     */
    public function hasOneUser() : HasOne{

        $userModel  = config('auth.providers.users.model');

        return $this->hasOne($userModel,'role_id','id');
    }

    /**
     * @return HasMany
     */
    public function hasManyRoutes() : HasMany{
        return $this->hasMany(RoleRoute::class,'role_id','id');
    }

    /**
     * @return HasMany
     */
    public function hasManyMenus():HasMany{
        return $this->hasMany(RoleMenu::class,'role_id','id');
    }
}