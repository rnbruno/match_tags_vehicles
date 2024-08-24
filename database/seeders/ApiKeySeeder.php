<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;
use App\Models\User1;
use App\Models\ApiKey;


class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Suponha que você já tenha usuários no banco de dados
        $users = User1::all();

        foreach ($users as $user) {
            // Gerar uma chave aleatória

            // Armazenar o hash da chave no banco de dados
            $hashedApiKey = Hash::make($user->api_key);

            // Salvar o hash da chave no banco
            ApiKey::create([
                'user_id' => $user->user_id,
                'hash' => $hashedApiKey,
            ]);

            // Opcional: Exibir a chave original no console
            $this->command->info('API Key for user ' . $user->name . $user->api_key . ': ' . $hashedApiKey);
        }
    }
}
