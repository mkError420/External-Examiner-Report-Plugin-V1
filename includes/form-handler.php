<?php
if (!defined('ABSPATH')) exit;

function eer_validate_date($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    // The d && ... check is to ensure that dates like '2022-02-30' are rejected.
    return $d && $d->format($format) === $date ? $date : null;
}

add_action('init', 'eer_handle_form');
add_action('admin_init', 'eer_handle_admin_actions');

function eer_handle_form() {
    if (!isset($_POST['eer_submit'])) return;
    if (!wp_verify_nonce($_POST['eer_nonce'], 'eer_submit_form')) return;

    global $wpdb;
    $table = $wpdb->prefix . 'examiner_reports';

    // Ensure table schema is updated to include new columns (se3, se4)
    eer_create_table();

    $wpdb->insert($table, [
        'teacher_name' => isset($_POST['teacher_name']) ? sanitize_text_field($_POST['teacher_name']) : '',
        'subject' => sanitize_text_field($_POST['subject']),
        'professional' => sanitize_text_field($_POST['professional']),
        'exam_period' => sanitize_text_field($_POST['exam_period']),
        'start_date' => eer_validate_date($_POST['start_date']),
        'end_date' => eer_validate_date($_POST['end_date']),

        'fa1' => isset($_POST['fa1']) ? intval($_POST['fa1']) : 0,
        'fa2' => isset($_POST['fa2']) ? intval($_POST['fa2']) : 0,
        'fa3' => isset($_POST['fa3']) ? intval($_POST['fa3']) : 0,
        'fa4' => isset($_POST['fa4']) ? intval($_POST['fa4']) : 0,
        'fa_improvement' => isset($_POST['fa_improvement']) ? sanitize_textarea_field($_POST['fa_improvement']) : '',

        'ospe_quality' => isset($_POST['ospe_quality']) ? intval($_POST['ospe_quality']) : 0,
        'clinical_quality' => isset($_POST['clinical_quality']) ? intval($_POST['clinical_quality']) : 0,
        'practical_quality' => isset($_POST['practical_quality']) ? intval($_POST['practical_quality']) : 0,
        'soe_quality' => isset($_POST['soe_quality']) ? intval($_POST['soe_quality']) : 0,
        'ap_improvement' => isset($_POST['ap_improvement']) ? sanitize_textarea_field($_POST['ap_improvement']) : '',

        'se1' => isset($_POST['se1']) ? intval($_POST['se1']) : 0,
        'se2' => isset($_POST['se2']) ? intval($_POST['se2']) : 0,
        'se3' => isset($_POST['se3']) ? intval($_POST['se3']) : 0,
        'se4' => isset($_POST['se4']) ? intval($_POST['se4']) : 0,
        'se_improvement' => isset($_POST['se_improvement']) ? sanitize_textarea_field($_POST['se_improvement']) : '',

        'knowledge_level' => sanitize_text_field($_POST['knowledge_level']),
        'skills_level' => sanitize_text_field($_POST['skills_level']),
        'attitude_level' => sanitize_text_field($_POST['attitude_level']),
        'overall_performance' => sanitize_text_field($_POST['overall_performance']),
        'overall_comments' => isset($_POST['overall_comments']) ? sanitize_textarea_field($_POST['overall_comments']) : '',

        'submitted_by' => get_current_user_id()
    ]);

    // Redirect to prevent form resubmission on page reload
    $redirect_url = add_query_arg('report-submitted', 'true', $_SERVER['REQUEST_URI']);
    wp_redirect($redirect_url);
    exit;
}

function eer_handle_admin_actions() {
    if (isset($_POST['eer_action']) && $_POST['eer_action'] === 'delete_all') {
        if (!isset($_POST['eer_delete_nonce']) || !wp_verify_nonce($_POST['eer_delete_nonce'], 'eer_delete_all_reports')) {
            wp_die('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'examiner_reports';
        $wpdb->query("TRUNCATE TABLE $table");

        wp_redirect($_SERVER['REQUEST_URI']);
        exit;
    }

    if (isset($_POST['eer_action']) && $_POST['eer_action'] === 'delete_selected') {
        if (!isset($_POST['eer_bulk_nonce']) || !wp_verify_nonce($_POST['eer_bulk_nonce'], 'eer_bulk_action')) {
            wp_die('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        if (isset($_POST['report_ids']) && is_array($_POST['report_ids'])) {
            global $wpdb;
            $table = $wpdb->prefix . 'examiner_reports';
            $ids = array_map('intval', $_POST['report_ids']);
            if (!empty($ids)) {
                $ids_placeholder = implode(',', array_fill(0, count($ids), '%d'));
                $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id IN ($ids_placeholder)", $ids));
            }
        }

        wp_redirect(remove_query_arg(['paged', 'report-submitted'], $_SERVER['REQUEST_URI']));
        exit;
    }

    if (isset($_POST['eer_action']) && $_POST['eer_action'] === 'save_settings') {
        if (!isset($_POST['eer_settings_nonce']) || !wp_verify_nonce($_POST['eer_settings_nonce'], 'eer_save_settings')) {
            wp_die('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        if (isset($_POST['eer_logo_url'])) {
            update_option('eer_logo_url', esc_url_raw($_POST['eer_logo_url']));
        }

        if (isset($_POST['eer_subjects'])) {
            update_option('eer_subjects', sanitize_textarea_field($_POST['eer_subjects']));
        }

        if (isset($_POST['eer_professionals'])) {
            update_option('eer_professionals', sanitize_textarea_field($_POST['eer_professionals']));
        }

        if (isset($_POST['eer_fa_questions']) && is_array($_POST['eer_fa_questions'])) {
            update_option('eer_fa_questions', array_map('sanitize_text_field', $_POST['eer_fa_questions']));
        }

        if (isset($_POST['eer_ap_questions']) && is_array($_POST['eer_ap_questions'])) {
            update_option('eer_ap_questions', array_map('sanitize_text_field', $_POST['eer_ap_questions']));
        }

        if (isset($_POST['eer_se_questions']) && is_array($_POST['eer_se_questions'])) {
            update_option('eer_se_questions', array_map('sanitize_text_field', $_POST['eer_se_questions']));
        }

        if (isset($_POST['eer_performance_levels'])) {
            update_option('eer_performance_levels', sanitize_textarea_field($_POST['eer_performance_levels']));
        }

        $redirect_url = add_query_arg('settings-updated', 'true', $_SERVER['REQUEST_URI']);
        wp_redirect($redirect_url);
        exit;
    }
}

function eer_render_shortcode() {
    ob_start();
    include plugin_dir_path( dirname( __FILE__ ) ) . 'templates/form.php';
    return ob_get_clean();
}
add_shortcode('external_examiner_report', 'eer_render_shortcode');
