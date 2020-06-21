<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
class UsersTableSeeder extends Seeder
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
                'name' => $faker->name,
                'email'	=> $faker->freeEmail,
                'email_verified_at'	=> null,
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        DB::table('users')->insert($arrInsert);
    }
}
