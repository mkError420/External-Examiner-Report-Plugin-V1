<?php
if (!defined('ABSPATH')) exit;

function eer_create_table() {
    global $wpdb;

    $table = $wpdb->prefix . 'examiner_reports';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT AUTO_INCREMENT PRIMARY KEY,
        subject VARCHAR(100),
        professional VARCHAR(50),
        exam_period VARCHAR(50),
        start_date DATE,
        end_date DATE,

        fa1 TINYINT,
        fa2 TINYINT,
        fa3 TINYINT,
        fa4 TINYINT,
        fa_improvement TEXT,
 
        ospe_quality TINYINT,
        clinical_quality TINYINT,
        practical_quality TINYINT,
        soe_quality TINYINT,
        ap_improvement TEXT,

        se1 TINYINT,
        se2 TINYINT,
        se3 TINYINT,
        se4 TINYINT,
        se_improvement TEXT,

        knowledge_level VARCHAR(20),
        skills_level VARCHAR(20),
        attitude_level VARCHAR(20),
        overall_performance VARCHAR(20),

        overall_comments TEXT,
        submitted_by BIGINT,
        submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
