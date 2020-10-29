<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:38
 **/

namespace Szkj\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Szkj\Rbac\Traits\DateTimeFormatter;

class RouteCatalog extends Model
{
    use DateTimeFormatter;
    /**
     * table name
     * @var string
     */
    protected $table = 'routes_catalogs';


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


    public function hasManyRoutes(){
        return $this->hasMany(Route::class,'pid','id');
    }
}