<?php
/**
 * Creator htm
 * Created by 2020/10/29 11:39
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Szkj\Rbac\Traits\DateTimeFormatter;

class RoleRoute extends Model
{
    use DateTimeFormatter;
    /**
     * table name
     * @var string
     */
    protected $table = 'roles_routes';


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
}