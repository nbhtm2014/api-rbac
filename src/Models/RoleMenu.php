<?php
/**
 * Creator htm
 * Created by 2020/10/29 11:40
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    /**
     * table name
     * @var string
     */
    protected $table = 'roles_menus';


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
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}