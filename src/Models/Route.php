<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:41.
 **/

namespace Szkj\Rbac\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    /**
     * table name.
     *
     * @var string
     */
    protected $table = 'routes';

    /**
     * Create a new Eloquent model instance.
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('database.default');

        $this->setConnection($connection);

        parent::__construct($attributes);
    }

    /**
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function hasManyRoleRoutes(): HasMany
    {
        return $this->hasMany(RoleRoute::class, 'route_id', 'id');
    }
}
