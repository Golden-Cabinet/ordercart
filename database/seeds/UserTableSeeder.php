<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'GCH Admin',
                'email' => 'gchadmin@goldencabinetherbs.com',
                'password' => bcrypt('m3d1s1n3'),
                'user_roles_id' => '1',
                'username' => 'admin',
                'area_code' => '503',
                'phonePre' => '555',
                'phonePost' => '1212',
                'ext' => '',
                'license_state' => null,
            ]
        );
    }
}
