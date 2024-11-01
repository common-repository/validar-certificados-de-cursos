<?php
/**
* Plugin Name:        ValidateCertify Free
* Plugin URI:         https://www.systenjrh.com/plugin-validatecertify/
* Author:             Systen JRH
* Author URI:         https://www.systenjrh.com/
* Version:            1.5.5
* Requires at least:  6.0
* Requires PHP:       7.3
* Text Domain:        stvc_validatecertify
* Domain Path:        /languages
* License:            GLPv2 or later.
* License URI:        https://www.gnu.org/licenses/gpl-2.0.html
* Description:        With ValidateCertify Free, you can guarantee the authenticity and veracity of the certificates issued, providing confidence to your students and those who validate them. Simplify the verification process and improve the experience of your users with ValidateCertify. Load your certificate base and validate them with the code from your website.
*
* @package ValidateCertify
* @category Core Functionality
* 
*/
define( 'stvc_validatecertify_version', '1.5.5' );

//Archivo para crear la base
function stvc_install(){
    require_once 'includes/class-stvc-activator.php';
}
register_activation_hook(__FILE__, 'stvc_install');

require_once plugin_dir_path(__FILE__) . 'includes/class-stvc-menu.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-stvc-notification.php';
require_once plugin_dir_path(__FILE__) . 'admin/partials/class-stvc-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'admin/partials/class-stvc-admin-display.php';
require_once plugin_dir_path(__FILE__) . 'admin/partials/class-stvc-admin-dashboard.php';
// Crea una instancia de la clase para caja de DashBoard
$stvc_admin_dashboard = new STVC_Admin_Dashboard();

wp_enqueue_style( 'validatecertify-styles', plugins_url( 'assets/css/validatecertify-styles.css', __FILE__ ) );

// Registrar el hook de activación del plugin
register_activation_hook(__FILE__, 'stvc_admin_notice_plugin_activation_hook');

// Registrar el hook para mostrar las notificaciones
add_action('admin_notices', 'stvc_admin_notice_plugin_notice');

// Añadir link en el plugin
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'stvc_validatecertify' );

function stvc_validatecertify( $actions ) {
$actions[] = '<a href="https://www.systenjrh.com/plugin-validatecertify/" target="_blank">Pro</a>';
return $actions;
}

add_filter( 'plugin_action_links', 'stvc_validatecertify_add_action_plugin', 10, 5 );

// Añade enlaces en la información de la versión del plugin
add_filter('plugin_row_meta', 'agregar_enlaces_version_plugin', 10, 2);

//Activar las traducciones
add_action('plugins_loaded', 'stvc_plugin_load_textdomain');

$plugin_header_translate = array(
    __('With ValidateCertify Free, you can guarantee the authenticity and veracity of the certificates issued, providing confidence to your students and those who validate them. Simplify the verification process and improve the experience of your users with ValidateCertify. Load your certificate base and validate them with the code from your website.', 'stvc_validatecertify')
);

//Carga la traducciones
function stvc_plugin_load_textdomain() {
    load_plugin_textdomain('stvc_validatecertify', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'stvc_plugin_load_textdomain');
