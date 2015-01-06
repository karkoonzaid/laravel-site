<?php

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    public function run()
    {

        DB::table('users')->truncate();

        $users = array(
            array(
                'username'      => 'ad_user',
                'email'      => 'z4ls@live.com',
                'password'   => Hash::make('admin'),
                'active'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'moderator',
                'email'      => 'moderator@gmail.com',
                'password'   => Hash::make('abc'),
                'active'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'author',
                'email'      => 'author@gmail.com',
                'password'   => Hash::make('abc'),
                'active'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('users')->insert( $users );


    }

}
