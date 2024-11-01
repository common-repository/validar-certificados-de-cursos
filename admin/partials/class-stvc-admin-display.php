<?php
/* ValidateCertify Free Admin Display
 *
 * @class    stvc-admin-display
 * @package  ValidateCertify
 */
function agregar_enlaces_version_plugin($plugin_meta, $plugin_file) {
    // Verifica si se trata del archivo de tu plugin
    if (strpos($plugin_file, 'ValidateCertify-Free.php') !== false) {
        // Añade los enlaces a los metadatos del plugin
        $plugin_meta[] = '<a href="https://systenjrh.com/plugin-validatecertify/documentacion-validatecertify/" target="_blank">' . esc_html__( 'Documentation', 'stvc_validatecertify' ) . '</a>';
        $plugin_meta[] = '<a href="https://wordpress.org/support/plugin/validar-certificados-de-cursos/reviews/#new-post" target="_blank">' . esc_html__( 'Rate the plugin ★★★★★', 'stvc_validatecertify' ) . '</a>';
    }
    return $plugin_meta;
}

function stvc_validatecertify_add_action_plugin( $actions, $plugin_file )
{
// Especifica directamente el nombre de tu plugin
    $plugin = 'validar-certificados-de-cursos/ValidateCertify-Free.php';

    if ($plugin == $plugin_file) {

        $Herramientas = array('herramientas' => '<a href="admin.php?page=tools_validatecertify">' . esc_html__( 'Tools', 'stvc_validatecertify' ) . '</a>');
        $actions = array_merge($Herramientas, $actions);
    }

    return $actions;
    }
    

function validar_pagina_vtvc() {
    $plugin_pages = array('ValidateCertify', 'new_certificates_stvc', 'edit_certificates_stvc', 'delete_certificates_stvc', 'tools_validatecertify');

    // Verificar si la página actual tiene uno de los slugs de tu plugin
    if (isset($_GET['page']) && in_array($_GET['page'], $plugin_pages)) {
        return true;
    }
    return false;
}

// Eliminar el mensaje "Gracias por crear con WordPress" solo en páginas de tu plugin
if (validar_pagina_vtvc()) {
    remove_filter( 'update_footer', 'core_update_footer' );

    // Agregar nuestra info en el pie de página
    function custom_plugin_footer_text( $text ) {
        // Agregar el mensaje personalizado con la valoración de estrellas y el enlace
        $text = __('Have you enjoyed ValidateCertify? Please leave us a review ', 'stvc_validatecertify' );
        $text .= '<a href="https://wordpress.org/support/plugin/validar-certificados-de-cursos/reviews/#new-post" target="_blank">★★★★★</a>. ';
        $text .= __('We really appreciate your support!', 'stvc_validatecertify' ); 
        return $text;
    }
    add_filter( 'admin_footer_text', 'custom_plugin_footer_text' );

    // Reemplazar el texto "Versión" seguido de la versión del plugin
    function custom_plugin_version_text( $footer_text ) {
        // Obtener la versión del plugin
        $plugin_version = defined( 'stvc_validatecertify_version' ) ? stvc_validatecertify_version : '';

        // Reemplazar el texto "Versión" seguido de la versión del plugin
        $footer_text = str_replace( __('Version', 'stvc_validatecertify'), __('Version ValidateCertify Free', 'stvc_validatecertify'), $footer_text );

        // Reemplazar la versión del plugin con la versión definida
        $footer_text = str_replace( '6.4.5', $plugin_version, $footer_text );

        // Reemplazar cualquier versión en el pie de página con la versión definida
        $footer_text = preg_replace( '/\d+\.\d+\.\d+/', $plugin_version, $footer_text );

        return $footer_text;
    }

    add_filter( 'update_footer', 'custom_plugin_version_text', 11 );

}