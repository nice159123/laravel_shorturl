<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;
class ShortUrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('en_EN');
    	for ($count = 0; $count < 10; $count++) {
            $arrInsert[] = [
                'user_id' => $faker->numberBetween(1, 10),
                'code' => Str::random(5),
                'url' => $faker->url(),
                'password' => Hash::make('password'),
                'count' => 0,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('short_urls')->insert($arrInsert);
    }
}
