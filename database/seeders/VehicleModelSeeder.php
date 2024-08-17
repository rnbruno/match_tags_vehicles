<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            ['modelo' => 'Classe A', 'tag1' => 'Compacto', 'tag2' => 'Urbano', 'tag3' => 'Moderno', 'tag4' => 'Desportivo'],
            ['modelo' => 'Classe B', 'tag1' => 'Família', 'tag2' => 'Urbano', 'tag3' => 'Espaçoso', 'tag4' => 'Versatilidade'],
            ['modelo' => 'Classe C', 'tag1' => 'Executivo', 'tag2' => 'Desportivo', 'tag3' => 'Tecnológico', 'tag4' => 'Versatilidade'],
            ['modelo' => 'Classe E', 'tag1' => 'Executivo', 'tag2' => 'Desportivo', 'tag3' => 'Imponente', 'tag4' => 'Versatilidade'],
            ['modelo' => 'Classe G', 'tag1' => 'Aventura', 'tag2' => 'SUV', 'tag3' => 'Robusto', 'tag4' => 'Luxo'],
            ['modelo' => 'Classe S', 'tag1' => 'Luxo', 'tag2' => 'Prestígio', 'tag3' => 'Sofisticado', 'tag4' => 'Tecnológico'],
            ['modelo' => 'CLA', 'tag1' => 'Urbano', 'tag2' => 'Coupé', 'tag3' => 'Elegante', 'tag4' => 'Tecnológico'],
            ['modelo' => 'GLA', 'tag1' => 'SUV', 'tag2' => 'Urbano', 'tag3' => 'Versatilidade', 'tag4' => 'Luxo'],
            ['modelo' => 'GLB', 'tag1' => 'SUV', 'tag2' => 'Urbano', 'tag3' => 'Espaçoso', 'tag4' => 'Luxo'],
            ['modelo' => 'GLC', 'tag1' => 'SUV', 'tag2' => 'Desportivo', 'tag3' => 'Robusto', 'tag4' => 'Luxo'],
            ['modelo' => 'GLE', 'tag1' => 'SUV', 'tag2' => 'Desportivo', 'tag3' => 'Robusto', 'tag4' => 'Luxo'],
            ['modelo' => 'GLS', 'tag1' => 'SUV', 'tag2' => 'Luxo', 'tag3' => 'Prestígio', 'tag4' => 'Espaçoso'],
            ['modelo' => 'EQA', 'tag1' => 'Elétrico', 'tag2' => 'Compacto', 'tag3' => 'Tecnológico', 'tag4' => 'Eficiente'],
            ['modelo' => 'EQB', 'tag1' => 'Elétrico', 'tag2' => 'Família', 'tag3' => 'SUV', 'tag4' => 'Versatilidade'],
            ['modelo' => 'EQC', 'tag1' => 'Elétrico', 'tag2' => 'Família', 'tag3' => 'SUV', 'tag4' => 'Luxo'],
            ['modelo' => 'EQE', 'tag1' => 'Elétrico', 'tag2' => 'Luxo', 'tag3' => 'Prestígio', 'tag4' => 'Desempenho'],
            ['modelo' => 'EQS', 'tag1' => 'Elétrico', 'tag2' => 'Luxo', 'tag3' => 'Prestígio', 'tag4' => 'Elegante'],
            ['modelo' => 'EQV', 'tag1' => 'Elétrico', 'tag2' => 'Viagem', 'tag3' => 'Minivan', 'tag4' => 'Versatilidade'],
            ['modelo' => 'Classe V', 'tag1' => 'Viagem', 'tag2' => 'Minivan', 'tag3' => 'Espaçoso', 'tag4' => 'Conforto'],
            ['modelo' => 'smart', 'tag1' => 'Jovem', 'tag2' => 'Compacto', 'tag3' => 'Elétrico', 'tag4' => 'Tecnológico'],
            ['modelo' => 'AMG', 'tag1' => 'Desportivo', 'tag2' => 'Desempenho', 'tag3' => 'Luxo', 'tag4' => 'Exclusividade'],
        ];

        DB::table('vehicle_models')->insert($models);
    }
}
