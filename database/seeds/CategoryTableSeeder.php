<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        
        $category_arr = [
            'Herbs', 		
            'None'
        ];

        foreach($category_arr as $category)
        {
            DB::table('categories')->insert(
                [
                    'name' => $category,
                    'created_at' => $now,  
                ]
            );
        }                  
    }
}
