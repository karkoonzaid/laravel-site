<?php

use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->truncate();

        $faker = Faker\Factory::create();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->save();

        $moderatorRole = new Role;
        $moderatorRole->name = 'moderator';
        $moderatorRole->save();

        $authorRole = new Role;
        $authorRole->name = 'author';
        $authorRole->save();

        $user = User::where('username','=','ad_user')->first();
        $user->attachRole( $adminRole );

//        $user = User::where('username','=','ad_user1')->first();
//        $user->attachRole( $adminRole );

        $m = User::where('username','=','moderator')->first();
        $m->attachRole($moderatorRole);

//        $m = User::where('username','=','mo_user1')->first();
//        $m->attachRole($moderatorRole);

        $a  = User::where('username','=','author')->first();
        $a->attachRole($authorRole);
//        $a  = User::where('username','=','au_user1')->first();
//        $a->attachRole($authorRole);
    }

}
