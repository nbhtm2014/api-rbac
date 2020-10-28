<?php
/**
 * Creator htm
 * Created by 2020/10/28 15:30
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /**
     * table name
     * @var string
     */
    protected $table = 'menus';

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
     * @var array
     */
    protected $fillable = ['name', 'path', 'icon', 'pid'];

    /**
     * @return HasMany
     */
    public function hasManyMenus(): HasMany
    {
        return $this->hasMany(Menu::class, 'pid', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasManyMenus()->with('children');
    }
}