<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:41
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Szkj\Rbac\Traits\DateTimeFormatter;

class Route extends Model
{

    use DateTimeFormatter;
    /**
     * table name
     * @var string
     */
    protected $table = 'routes';


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
     * @return HasMany
     */
    public function hasManyRoleRoutes() : HasMany{
        return $this->hasMany(RoleRoute::class,'route_id','id');
    }
}