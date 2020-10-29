<?php
/**
 * Creator htm
 * Created by 2020/10/28 9:53
 **/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRbacTable extends Migration
{
    /**
     * @return string
     */
    public function getConnection() :string
    {
        return config('database.default');
    }

    /**
     * @return string
     */
    public function getPrefix() : string
    {
        return config('database.connections.'.$this->getConnection().'.prefix');
    }

    /**
     * @param string $name
     * @return string
     */
    public function tableName(string $name):string{
        return $name;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create menus table
        Schema::create($this->tableName('menus'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('path', 255)->nullable();
            $table->string('icon',100)->nullable();
            $table->integer('pid')->default(0);
            $table->index(['pid'],'pid');
            $table->timestamps();
        });

        //create roles table
        Schema::create($this->tableName('roles'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->timestamps();
        });


        //create roles_menus table
        Schema::create($this->tableName('roles_menus'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->index(['role_id','menu_id'],'role_id');

            $table->timestamps();
        });

        //create roles_routes table
        Schema::create($this->tableName('roles_routes'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id');
            $table->integer('route_id');
            $table->index(['role_id','route_id'],'role_id');

            $table->timestamps();
        });

        //create routes table
        Schema::create($this->tableName('routes'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('path',255);
            $table->string('methods',50);
            $table->string('name',255)->nullable();
            $table->tinyInteger('default')->default(0);
            $table->integer('pid')->default(0);
            $table->index(['pid'],'pid');
            $table->index(['path','name'],'path');

            $table->timestamps();
        });


        //create routes_catalogs table
        Schema::create($this->tableName('routes_catalogs'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);

            $table->timestamps();
        });

        Schema::table('users',function (Blueprint $table){
            $table->tinyInteger('superadmin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName('menus'));
        Schema::dropIfExists($this->tableName('roles'));
        Schema::dropIfExists($this->tableName('roles_menus'));
        Schema::dropIfExists($this->tableName('roles_routes'));
        Schema::dropIfExists($this->tableName('routes'));
        Schema::dropIfExists($this->tableName('routes_catalogs'));
    }
}