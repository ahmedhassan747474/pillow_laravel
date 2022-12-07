<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        User::create([
	            'name' => $faker->name,
	            'email' => $faker->email,
                'password' => bcrypt('123456'),
                'status' => (string) rand(0,1),
            ]);
        }
    }
}
