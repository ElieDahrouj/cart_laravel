<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        $fakeEng = Faker::create('en_UK');
        for ($i = 0; $i < 10; $i++) {
            $post = new Product();
            $post->name = $fakeEng->streetName;
            $post->picture = "https://picsum.photos/id/".rand(1,300)."/500/300";
            $post->description = $faker->realText(100);
            $post->release_date = $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now');
            $post->price = $faker->numberBetween('50',200);
            $post->save();
        }
    }
}
