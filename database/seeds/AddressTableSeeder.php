<?php

use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->insert([

            [
                'users_id' => 1,
                'address_types_id' => 1,
                'street' => '123 Apple Tree Street',
                'city' => 'Whatever',
                'address_states_id' => 13,
                'zip' => '88876'
            ],

            [
                'users_id' => 1,
                'address_types_id' => 2,
                'street' => '123 Apple Tree Street',
                'city' => 'Whatever',
                'address_states_id' => 13,
                'zip' => '88876'
            ],

            [
                'users_id' => 2,
                'address_types_id' => 1,
                'street' => '321 Apple Tree Street',
                'city' => 'Whatever',
                'address_states_id' => 13,
                'zip' => '88876'
            ],

            [
                'users_id' => 2,
                'address_types_id' => 2,
                'street' => '456 Orange Tree Street',
                'city' => 'Whatever',
                'address_states_id' => 13,
                'zip' => '88875'
            ],

            [
                'users_id' => 3,
                'address_types_id' => 1,
                'street' => '555 Grove Street',
                'city' => 'Whatever',
                'address_states_id' => 19,
                'zip' => '56897'
            ],

            [
                'users_id' => 3,
                'address_types_id' => 2,
                'street' => '555 Grove Street',
                'city' => 'Whatever',
                'address_states_id' => 19,
                'zip' => '56897'
            ],

            [
                'users_id' => 4,
                'address_types_id' => 1,
                'street' => '8887 Tiny Street',
                'city' => 'Whatever',
                'address_states_id' => 31,
                'zip' => '87414'
            ],

            [
                'users_id' => 4,
                'address_types_id' => 2,
                'street' => '123 Giant Street',
                'city' => 'Whatever',
                'address_states_id' => 31,
                'zip' => '87411'
            ],

        ]);
    }
}
