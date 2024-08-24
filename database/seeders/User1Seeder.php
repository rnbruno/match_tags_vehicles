<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User1;
use Illuminate\Support\Str;

class User1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Criar 5 usuários com dados variados
        foreach (range(1, 5) as $index) {
            User1::create([
                'user_id' => Str::uuid()->toString(),
                'name' => $faker->name,
                'api_key' => Str::random(60),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->boolean ? $faker->dateTimeThisYear : null,
                'password' => Hash::make('password'), // senha padrão para todos os usuários
                'remember_token' => $faker->boolean ? $faker->uuid : null,
            ]);
        }
    }
}
