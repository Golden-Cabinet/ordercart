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
                [
                    'name' => 'GCH Admin',
                    'email' => 'gchadmin@goldencabinetherbs.com',
                    'password' => bcrypt('m3d1s1n3'),
                    'user_roles_id' => '2',
                    'registration_token' => str_random(32),
                    'is_registered' => '1',
                    'is_approved' => '1',
                    'username' => 'admin',
                    'area_code' => '503',
                    'phonePre' => '555',
                    'phonePost' => '1212',
                    'ext' => '',
                    'license_state' => null,
                ],
                    // practitioner
                [
                    'name' => 'Bob Jones',
                    'email' => 'bobjones@goldencabinetherbs.com',
                    'password' => bcrypt('m3d1s1n3'),
                    'user_roles_id' => '3',
                    'registration_token' => str_random(32),
                    'is_registered' => '1',
                    'is_approved' => '1',
                    'username' => 'bob',
                    'area_code' => '757',
                    'phonePre' => '555',
                    'phonePost' => '1212',
                    'ext' => '333',
                    'license_state' => '29',
                ],
                    // patients
                [
                    'name' => 'Mary Smith',
                    'email' => 'marysmith@goldencabinetherbs.com',
                    'password' => bcrypt(str_random(8)),
                    'user_roles_id' => '5',
                    'registration_token' => str_random(32),
                    'is_registered' => '0',
                    'is_approved' => '0',
                    'username' => 'mary',
                    'area_code' => '757',
                    'phonePre' => '555',
                    'phonePost' => '1414',
                    'ext' => '',
                    'license_state' => '29',
                ],

                [
                    'name' => 'Bill Williams',
                    'email' => 'billwilliams@goldencabinetherbs.com',
                    'password' => bcrypt(str_random(8)),
                    'user_roles_id' => '5',
                    'registration_token' => str_random(32),
                    'is_registered' => '0',
                    'is_approved' => '0',
                    'username' => 'bill',
                    'area_code' => '800',
                    'phonePre' => '555',
                    'phonePost' => '1515',
                    'ext' => '',
                    'license_state' => '28',
                ],

                // student

                [
                    'name' => 'Jenny Jackson',
                    'email' => 'jennyjackson@goldencabinetherbs.com',
                    'password' => bcrypt('m3d1s1n3'),
                    'user_roles_id' => '4',
                    'registration_token' => str_random(32),
                    'is_registered' => '1',
                    'is_approved' => '1',
                    'username' => 'jenny',
                    'area_code' => '735',
                    'phonePre' => '555',
                    'phonePost' => '1616',
                    'ext' => '',
                    'license_state' => '19',
                ],
            ]
        );
    }
}
