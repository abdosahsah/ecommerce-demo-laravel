<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker\Factory::create();

        for($i=0; $i < 25; $i++)
        {
            Product::create([
                'title' => $fake->sentence(5),
                'slug' => $fake->slug,
                'subtitle' => $fake->sentence(6),
                'description' => $fake->text,
                'price' => $fake->numberBetween(45, 350),
                'image' => 'https://via.placeholder.com/200x250'
            ]);
        }
    }
}
