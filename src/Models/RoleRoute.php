<?php
/**
 * Creator htm
 * Created by 2020/10/29 11:39.
 **/

namespace Szkj\Rbac\Models;

use Illuminate\Database\Eloquent\Model;

class RoleRoute extends Model
{
    /**
     * table name.
     *
     * @var string
     */
    protected $table = 'roles_routes';

    /**
     * @var array
     */
    protected $guarded = [];

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
}
