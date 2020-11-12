<?php
/**
 * Creator htm
 * Created by 2020/10/28 15:30.
 **/

namespace Szkj\Rbac\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /**
     * table name.
     *
     * @var string
     */
    protected $table = 'menus';

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
     * @var array
     */
    protected $fillable = ['name', 'path', 'icon', 'pid'];

    /**
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function hasManyMenus(): HasMany
    {
        return $this->hasMany(Menu::class, 'pid', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasManyMenus()->with('children');
    }
}
