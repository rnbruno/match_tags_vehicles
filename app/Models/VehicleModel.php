<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VehicleModel extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public static function getVehicleTags()
    {
        $products = DB::select("
        SELECT 
            p.ID, p.post_title, pm.meta_value AS price,   GROUP_CONCAT(t.name SEPARATOR ', ') AS tags,
            (SELECT guid FROM wp_posts WHERE ID = (SELECT meta_value FROM wp_postmeta WHERE post_id =   p.ID AND meta_key = '_thumbnail_id')) AS image_url, (SELECT meta_value FROM wp_postmeta WHERE post_id = p.ID AND meta_key = '_sku') AS sku, p.post_content AS description,  CONCAT(p.guid, '?p=', p.ID) AS url
        FROM 
            wp_posts p
            LEFT JOIN 
                wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_price'
            LEFT JOIN 
                wp_term_relationships tr ON p.ID = tr.object_id
            LEFT JOIN 
                wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = 'product_tag'
            LEFT JOIN 
                wp_terms t ON tt.term_id = t.term_id
        WHERE 
            p.post_type = 'product'
            AND p.post_status = 'publish'
        GROUP BY 
            p.ID, p.post_title, pm.meta_value, p.guid, p.post_content

        ");

        // Retorna os dados utilizando a MarcacoesResource
        return $products;
    }
}
