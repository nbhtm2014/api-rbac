<?php
/**
 * Creator htm
 * Created by 2020/10/30 9:55
 **/

namespace Szkj\Rbac\Models\Seeders;

use \Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Hash;

class UserSeeder extends  Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'superadmin',
            'email'      => 'szkj@szkj.com',
            'password'   => Hash::make('password'),
            'superadmin' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}