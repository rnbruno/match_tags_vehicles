
# API for Matching Vehicle Models with Product Tags

Descrição do projeto

1. Wordpress
    -  Alteração do arquivo funtions.php no template do projeto de E-commerce para habilitar a chamada do API http://127.0.0.1:8000/.

 
```add_action('wp_ajax_get_product_tags', 'get_product_tags');add_action('wp_ajax_nopriv_get_product_tags', 'get_product_tags');function get_product_tags() {$product_id = intval($_GET['product_id']); // Obtém o ID do produto via GET

    if (!$product_id) {
        wp_send_json_error('ID do produto inválido');
    }

    $taxonomy = 'product_tag';
    $product_tags = wp_get_post_terms($product_id, $taxonomy);

    if (!is_wp_error($product_tags) && !empty($product_tags)) {
        $tags = array();
        foreach ($product_tags as $tag) {
            $tags[] = array(
                // 'id' => $tag->term_id,
                'tag' => $tag->name
            );
        }
        wp_send_json_success($tags);
    } else {
        wp_send_json_error('Nenhuma tag encontrada para este produto.');
    }
}

function my_enqueue_scripts() {
    // Enfileira o script JavaScript
    wp_enqueue_script('my-script', get_template_directory_uri() . '/assets/js/my-script.js', array('jquery'), null, true);

    // Adiciona a variável global wp_vars para o seu script
    wp_localize_script('my-script', 'wp_vars', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
```

2. No arquivo my-script.js adiciono o js + Jquery para fazer diversas chamadas com várias tags para testas o resultado dos matchs

```jQuery(document).ready(function ($) {
  // Adiciona um evento de clique a todos os elementos <li> com o atributo data-wc-key
  $("li[data-wc-key]").on("click", function (event) {
    // Obtém o valor do atributo data-wc-key
    var wcKey = $(this).data("wc-key");

    // Extrai o número do data-wc-key
    var productId = wcKey.replace("product-item-", "");

    // Agora você pode usar o productId como quiser
    console.log("Product ID:", productId);

    if (typeof wp_vars !== "undefined") {
      $.ajax({
        url: wp_vars.ajax_url, // URL do endpoint AJAX
        type: "GET",
        async: true,
        data: {
          action: "get_product_tags", // Nome da ação no PHP
          product_id: productId,
        },
        success: function (response) {
          var tags = response.data;
         
          $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
          });
          event.preventDefault();
          let tagGroups = [
              // Grupos com 1 tag
              ['Luxo'],
              ['Urbano'],
              ['Desportivo'],
              ['Compacto'],
              ['Tecnológico'],
          
              // Grupos com 2 tags
              ['Luxo', 'Urbano'],
              ['Jovem', 'Sofisticado'],
              ['Compacto', 'Tecnológico'],
              ['Família', 'Versatilidade'],
              ['Desportivo', 'Robusto'],
              ['Elétrico', 'Eficiente'],
              ['SUV', 'Aventura'],
              ['Executivo', 'Imponente'],
              ['Viagem', 'Minivan'],
              ['Modern', 'Elegante'],
          
              // Grupos com 3 tags
              ['Luxo', 'Urbano', 'Tecnológico'],
              ['Jovem', 'Sofisticado', 'Desportivo'],
              ['Compacto', 'Tecnológico', 'Eficiente'],
              ['Família', 'Versatilidade', 'Conforto'],
              ['Desportivo', 'Robusto', 'Aventura'],
              ['Elétrico', 'Eficiente', 'Sofisticado'],
              ['SUV', 'Aventura', 'Luxo'],
              ['Executivo', 'Imponente', 'Tecnológico'],
              ['Viagem', 'Minivan', 'Espaçoso'],
              ['Modern', 'Elegante', 'Desempenho'],
          
              // Grupos com 4 tags
              ['Luxo', 'Urbano', 'Tecnológico', 'Elegante'],
              ['Jovem', 'Sofisticado', 'Desportivo', 'Eficiente'],
              ['Compacto', 'Tecnológico', 'Eficiente', 'Conforto'],
              ['Família', 'Versatilidade', 'Conforto', 'Espaçoso'],
              ['Desportivo', 'Robusto', 'Aventura', 'Luxo'],
              ['Elétrico', 'Eficiente', 'Sofisticado', 'Tecnológico'],
              ['SUV', 'Aventura', 'Luxo', 'Conforto'],
              ['Executivo', 'Imponente', 'Tecnológico', 'Versatilidade'],
              ['Viagem', 'Minivan', 'Espaçoso', 'Conforto'],
              ['Modern', 'Elegante', 'Desempenho', 'Luxo'],
          ];

          // console.log(tagGroups);

          tagGroups.forEach(function(tags) {
              console.log(tags);
              $.ajax({
                  url: "http://localhost:8000/api/vehicles/",
                  type: "POST",
                  data: {
                      data: tags // Envia o grupo de tags atual
                  },
                  success: function(response) {
                      console.log('Resposta para tags:', tags);
                      console.log(response); // Processa a resposta da API
                  },
                  error: function(xhr, status, error) {
                      console.log('Erro para tags:', tags);
                      console.log(xhr.responseText); // Processa o erro da API
                  }
              });
          });

        
          $.ajax({
            url: "http://localhost:8000/api/vehicles/",
            type: "POST",
            data: {
              data: tags,
            },
            async: true,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8", // Tipo de conteúdo
            headers: {
              Accept: "application/json", // Tipo de resposta esperado
            },
            success: function (response) {
              console.log("Success:", response);
            },
            error: function (xhr, status, error) {
              console.error("Error:", status, error);
            },
          });
          
        },
        error: function () {
          console.log("Erro ao obter tags do produto.");
        },
      });
    } else {
      console.log("wp_vars não está definido.");
    }
    return false;
  });
});
```

3.    API Laravel no server http://127.0.0.1:8000/api/vehicles

    3.1 chamada routes/api

    Route::apiResource('/vehicles', App\Http\Controllers\Api\VehicleModelController::class);
    Route::post('/vehicles', [App\Http\Controllers\Api\VehicleModelController::class, 'vehicleTag']);

    VehicleModel verificandos os itens na tabela wp_posts
    VehicleModelController Buscando os dados no Model e calculando os matchs
    VehicleModelRequest Requisição da API para validação das chamda
    VehicleModelResources Transformando a coleção em json

4.     Bando de dados
   4.1    Banco de dados onde hospeda o WordPress.


