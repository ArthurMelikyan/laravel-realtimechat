<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i = 0; $i < 2; $i++){
            User::firstOrCreate([
                "email" => $faker->unique()->safeEmail
            ],[
                "name"     => "User ".($i+1),
                "password"=>Hash::make("tmp_password")
            ]
            );
        }
    }
}
