<?php
/**
 * Plugin Name: External Examiner Report
 * Description: Digital External Examiner Report Form for Medical Colleges
 * Version: 02.10
 * Author: Mk. Rabbani(Website Manager RCMCH)
 */

if (!defined('ABSPATH')) exit;

define('EER_PATH', plugin_dir_path(__FILE__));
define('EER_URL', plugin_dir_url(__FILE__));

require_once EER_PATH . 'includes/db.php';
require_once EER_PATH . 'includes/form-handler.php';
require_once EER_PATH . 'includes/admin-page.php';

/* Create table on activation */
register_activation_hook(__FILE__, 'eer_create_table');

/* Shortcode */
add_shortcode('external_examiner_form', 'eer_load_form');

function eer_load_form() {
    ob_start();
    include EER_PATH . 'templates/form.php';
    return ob_get_clean();
}

/* Admin menu */
add_action('admin_menu', 'eer_admin_menu');

function eer_admin_menu() {
    add_menu_page(
        'Examiner Reports',
        'Examiner Reports',
        'manage_options',
        'eer-reports',
        'eer_admin_page',
        'dashicons-clipboard'
    );
}

/* Enqueue admin styles */
add_action('admin_enqueue_scripts', 'eer_enqueue_admin_styles');

function eer_enqueue_admin_styles($hook) {
    // Only load on the reports page
    if (strpos($hook, 'eer-reports') === false) {
        return;
    }
    wp_enqueue_style('eer-admin-style', EER_URL . 'assets/css/style.css');

    // For media uploader on settings tab
    if (isset($_GET['tab']) && $_GET['tab'] === 'settings') {
        wp_enqueue_media();
    }
}

add_action('wp_ajax_eer_live_search', 'eer_live_search_callback');
