<?php

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    public function run()
    {

        DB::table('users')->truncate();

        $users = array(
            array(
                'username'      => 'admin',
                'email'      => 'admin@gmail.com',
                'password'   => Hash::make('password'),
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
