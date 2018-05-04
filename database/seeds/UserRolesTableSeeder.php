<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            [
                'name' => 'Public',
            ],

            [
                'name' => 'Admin'
            ],

            [
                'name' => 'Practitioner'
            ],

            [
                'name' => 'Student'
            ],

            [
                'name' => 'Patient'
            ] 
        ]);
    }
}
