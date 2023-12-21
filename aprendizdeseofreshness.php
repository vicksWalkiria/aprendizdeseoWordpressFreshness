Version: 1.0
Author: AprendizDeSeo.top
*/


add_action('admin_menu', 'aprendizdeseo_freshness_add_menu');

function aprendizdeseo_freshness_add_menu() {
    add_menu_page(
        'Listado de Artículos', // Título de la página
        'AprendizDeSEO Freshness', // Título del menú
        'manage_options', // Capacidad requerida para ver esta página
        'aprendiz-de-seo-freshness', // Slug del menú
        'show_articles_by_update_date' // Función que renderiza la página del plugin
    );
}


function show_articles_by_update_date() {
    // Obtener artículos
    $args = array(
        'post_type' => array('post','page'),
        'posts_per_page' => -1, // Obtener todos los artículos
        'orderby' => 'modified', // Ordenar por fecha de modificación
        'order' => 'ASC' // Del más antiguo al más moderno
    );
    $consulta = new WP_Query($args);

    // Comprobar si hay artículos y mostrarlos
    if ($consulta->have_posts()) {
        echo '<ul>';
        while ($consulta->have_posts()) {
            $consulta->the_post();
            $fecha_modificacion = get_the_modified_date('Y-m-d H:i:s');
            $dias_desde_modificacion = round((time() - strtotime($fecha_modificacion)) / (60 * 60 * 24));
            echo '<li>';
            echo '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>';
            echo ' - Actualizado hace ' . $dias_desde_modificacion . ' días';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No hay artículos para mostrar.';
    }

    // Restablecer consulta
    wp_reset_postdata();
}
