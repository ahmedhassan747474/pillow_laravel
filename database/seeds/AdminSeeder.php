<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Admin;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        Admin::create([
            'name'          => 'Admin',
            'email'         => 'admin@bidsbooking.com',
            'password'      => bcrypt('admin123'),
            'image'         => 'admin_default.png'
        ]);
    }
}
