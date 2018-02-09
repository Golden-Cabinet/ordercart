<?php

use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $brands_arr = [
            'Evergreen Herbs', 		
            'Legendary Herbs', 		
            'Classical Pearls', 		
            'KPC', 		
            'Qualiherb', 		
            'Extract', 		
            'Golden Lotus', 		
            'Nong\'s', 		
            'NuHerbs', 		
            'Aloha Medicinals', 		
            'Root of the Matter', 		
            'Starwest', 		
            'Happy Herbalist', 		
            'China Herbs', 		
            'E-Fong', 		
            'Meridian Pro', 		
            'Mountain Rose Herbs'
        ];

        foreach($brands_arr as $brand)
        {
            DB::table('brands')->insert(
                [
                    'name' => $brand,
                    'deleted' => 0,
                    'created_at' => $now,                     
            ]);
        }

        
    }
}
