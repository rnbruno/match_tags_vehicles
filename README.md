
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

    1.2     No arquivo my-script.js adiciono

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


- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
