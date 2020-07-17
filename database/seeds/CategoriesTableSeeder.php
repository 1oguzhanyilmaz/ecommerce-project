<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Category::create([
            'name'          =>  'Root',
            'slug'          =>  'root',
            'parent_id'     =>  0,
        ]);

        factory('App\Category', 10)->create();

        $categoriesQuantity = 10;
        factory(App\Category::class, $categoriesQuantity)->create();
    }
}
