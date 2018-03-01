<?php

use Illuminate\Database\Seeder;

class AddressTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert(
            [
                [
                    'name' => 'Billing',
                ],
                [
                    'name' => 'Shipping',
                ],
                [
                    'name' => 'User',
                ],
                [
                    'name' => 'Student',
                ],
                [
                    'name' => 'Patient',
                ],                
                    
        ]);
    }
}
