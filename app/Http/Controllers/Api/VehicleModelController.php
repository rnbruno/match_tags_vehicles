<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleModelRequest;
use App\Http\Resources\VehicleModelResource;
use Illuminate\Support\Facades\DB;
use App\Models\User1;
use App\Models\ApiKey;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class VehicleModelController extends Controller
{
    public function index()
    {
        return VehicleModelResource::collection(VehicleModel::all());
    }

    public function store(VehicleModelRequest $request)
    {
        $vehicleModel = VehicleModel::create($request->validated());

        return new VehicleModelResource($vehicleModel);
    }

    public function show(VehicleModel $vehicleModel)
    {
        return new VehicleModelResource($vehicleModel);
    }

    public function update(VehicleModelRequest $request, VehicleModel $vehicleModel)
    {
        $vehicleModel->update($request->validated());

        return new VehicleModelResource($vehicleModel);
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        $vehicleModel->delete();

        return response()->noContent();
    }
    public static function vehicleTag(Request $request)
    {

        $tagsData = $request->input('data', []);

        if ($request->has('user_id')) {
            $userId = $request->input('user_id');
            $query = DB::table('users1')->where('user_id', $userId);
            $results = $query->get();
            if ($results->isEmpty()) {
                // O usuário não existe
                return [
                    'sucesso' => false,
                    'mensagem' => 'Nenhum Usuário encontrado'
                ];
            }
        } else {
            return [
              
                'sucesso' => false,
                'mensagem' => 'Nenhum Usuário enviado'
            ];
        }

        $authorizationHeader = $request->header('Authorization');
    
        // Verifica se o cabeçalho segue o formato 'Bearer token'
        if (Str::startsWith($authorizationHeader, 'Bearer ')) {
            // Remove o prefixo 'Bearer ' para capturar somente o token/chave
            $apiKey = Str::replaceFirst('Bearer ', '', $authorizationHeader);
        }else{
            return [
                'sucesso' => false,
                'mensagem' => 'Bearer error.'
            ];
        }

        $hashedApiKey = ApiKey::where('user_id', $userId)->value('hash');

        if (!Hash::check($apiKey, $hashedApiKey)) {
            return [
                'sucesso' => false,
                'mensagem' => 'Key Api error.'
            ];
        } 
        
        $products_tags = VehicleModel::getVehicleTags();

        // Transforma os resultados em uma coleção para manipulação fácil
        $products = collect($products_tags);

        // Mapeia os produtos e calcula os matches para cada um
        $results = $products->map(function ($item) use ($tagsData) {
            // Quebra a string de tags em um array
            $productTags = explode(', ', $item->tags);

            // Contador de matches
            $matches = 0;

            // Verifica quantas tags coincidem
            foreach ($tagsData as $tag) {
                if (in_array($tag, $productTags)) {
                    $matches++;
                }
            }

            // Retorna o produto com o número de matches
            return [
                'ID' => $item->ID,
                'post_title' => $item->post_title,
                'price' => $item->price,
                'tags' => $item->tags,
                'matches' => $matches,
                'image_url' => $item->image_url,
                'sku' => $item->sku,
                'description' => $item->description,
                'url' => $item->url,
                'sucesso' => true,
                'mensagem' => ''
            ];
        });

        // Ordena os resultados por número de matches em ordem decrescente
        $sortedResults = $results->sortByDesc('matches')->values();

        // Retorna apenas as 4 primeiras linhas
        $topFourResults = $sortedResults->take(4);

        if ($topFourResults->every(fn($item) => $item['matches'] === 0)) {
            return [
                'ID' => '',
                'post_title' => '',
                'price' => '',
                'tags' => '',
                'matches' => 0,
                'image_url' => '',
                'sku' => '',
                'description' => '',
                'url' => '',
                'sucesso' => false,
                'mensagem' => 'Nenhum produto foi encontrado com essas Tags'
            ];
        }

        // Retorna o resultado como JSON
        return response()->json($topFourResults);
    }
}
