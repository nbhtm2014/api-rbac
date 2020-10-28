<?php
/**
 * Creator htm
 * Created by 2020/10/28 11:28
 **/

namespace Szkj\Rbac\Providers;

use Illuminate\Support\ServiceProvider;

class RbacServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerMigrations();
    }

    /**
     * 资源发布
     */
    public function registerPublishing(){

    }

    /**
     * 表迁移
     */
    public function registerMigrations(){
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}