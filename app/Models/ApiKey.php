<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ApiKey extends Model
{
    use HasFactory;

    // Indicar os atributos que são mass assignable
    protected $fillable = [
        'user_id',
        'api_key',
    ];

    // Caso queira esconder algum atributo da serialização
    protected $hidden = [
        'api_key',
    ];


    public static function verification($api_key, $userId){
        $apiKeyFromClient = $api_key;
        
        $hashedApiKey = ApiKey::where('user_id', $userId)->value('api_key');

        if (Hash::check($apiKeyFromClient, $hashedApiKey)) {
            // A chave é válida
        } else {
            // A chave é inválida
        }
    }

}
