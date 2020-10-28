<?php
/**
 * Creator htm
 * Created by 2020/10/28 11:28
 **/

namespace Szkj\Rbac;

use Illuminate\Support\ServiceProvider;

class RbacServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerMigrations();
//        $this->registerPublishing();
    }

    /**
     * 资源发布
     */
    public function registerPublishing(){

    }

    public function registerMigrations(){
        $this->loadMigrationsFrom(__DIR__ . '../database/migrations');

    }
}