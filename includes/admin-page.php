<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('eer_get_rating_label')) {
    function eer_get_rating_label($score) {
        $map = [
            5 => 'SA - Strongly Agree',
            4 => 'A - Agree',
            3 => 'U - Undecided',
            2 => 'DA - Disagree',
            1 => 'SDA - Strongly Disagree'
        ];
        return isset($map[$score]) ? $map[$score] . " ($score)" : "N/A ($score)";
    }
}

function eer_display_single_report($report) {
    ?>
    <div class="wrap">
        <h1>Report Details (ID: <?php echo $report->id; ?>)</h1>
        <a href="?page=eer-reports" class="button">&larr; Back to Dashboard</a>
        <button id="eer-download-pdf" class="button">Download This Report</button>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('eer-download-pdf').addEventListener('click', function() {
                var element = document.getElementById('eer-report-content');
                var opt = {
                    margin:       0.5,
                    filename:     'Examiner_Report_<?php echo $report->id; ?>.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
                    pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
                };
                html2pdf().set(opt).from(element).save();
            });
        });
        </script>

        <div id="poststuff" style="margin-top: 20px;">
            <div id="eer-report-content">
            <h2 style="text-align: center; margin-bottom: 0; background: #070d5f; border: 1px solid #070d5f; border-radius: 5px; color: #fff;padding: 5px;color: #c8cfd6;">Rangpur Community Medical College Hospital (RCMCH) </h2>
            <div class="postbox">
                <h2 class="hndle"><span>General Information</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <tbody>
                            <tr>
                                <td style="width: 200px;"><strong>Teacher Name</strong></td>
                                <td><?php echo esc_html($report->teacher_name); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;"><strong>Subject</strong></td>
                                <td><?php echo esc_html($report->subject); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Professional</strong></td>
                                <td><?php echo esc_html($report->professional); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Exam Period</strong></td>
                                <td><?php echo esc_html($report->exam_period); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Dates</strong></td>
                                <td><?php echo esc_html($report->start_date); ?> to <?php echo esc_html($report->end_date); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Submitted At</strong></td>
                                <td><?php echo esc_html($report->submitted_at); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            $fa_questions = get_option('eer_fa_questions', [
                'fa1' => 'Formative assessment procedures were satisfactory',
                'fa2' => 'Records of formative assessment were adequate',
                'fa3' => 'Question papers and scripts were available',
                'fa4' => 'Opportunity to scrutinize scripts was given'
            ]);
            ?>
            <div class="postbox">
                <h2 class="hndle"><span>(1) Assessment Process</span></h2>
                <h3 class="hndle"><span>(a) Formative assessment procedures were satisfactory (All terms & card exam):</span></h3>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Statements</th>
                                <th style="width: 200px;">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fa_questions as $key => $label): if(isset($report->$key)) : ?>
                                <tr>
                                    <td><?php echo esc_html($label); ?></td>
                                    <td><?php echo eer_get_rating_label($report->$key); ?></td>
                                </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    <p><strong>Formative Assessment can be further Improved by:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->fa_improvement)); ?></div>
                </div>
            </div>

            <?php $ap_questions = get_option('eer_ap_questions', [
                'ospe_quality' => 'Quality of OSPE was appropriate',
                'clinical_quality' => 'Quality of Clinical skill assessment was appropriate',
                'practical_quality' => 'Quality of Practical practical assessment was appropriate',
                'soe_quality' => 'Quality of structured oral examination was appropriate'
            ]); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(b) Quality of Summative Assessments (Professional Examination):</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Statements</th>
                                <th style="width: 200px;">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ap_questions as $key => $label): if(isset($report->$key)) : ?>
                                <tr>
                                    <td><?php echo esc_html($label); ?></td>
                                    <td><?php echo eer_get_rating_label($report->$key); ?></td>
                                </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    <p><strong>The quality of SOE, OSPE, Traditional Practical, Clinical skill assessment can be further improved by:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->ap_improvement)); ?></div>
                </div>
            </div>

            <?php $se_questions = get_option('eer_se_questions', [
                'se1' => 'Marking by internal examiners for SOE was as per rating scale',
                'se2' => 'Marking by internal examiners for OSPE was as per rating scale',
                'se3' => 'Marking by internal examiners for Practical examination was logical',
                'se4' => 'Marking by internal examiners for Clinical skill assessment was appropriate'
            ]); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(c) Marking by internal examiner in professional examination:</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Statements</th>
                                <th style="width: 200px;">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($se_questions as $key => $label): if(isset($report->$key)) : ?>
                                <tr>
                                    <td><?php echo esc_html($label); ?></td>
                                    <td><?php echo eer_get_rating_label($report->$key); ?></td>
                                </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                    <br>
                    
                </div>
            </div>

            <div class="postbox">
                <h2 class="hndle"><strong>(2) Student Performance (During Professional Examination/Summative Exam)</strong></h2>
                <h3 class="hndle"><strong>(a) Quality of learning outcomes:</strong></h3>
                
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Statements</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Level of learning outcome demonstrated by students in relation to knowledge was</strong></td>
                                <td><?php echo esc_html($report->knowledge_level); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Level of learning outcome demonstrated by students in relation to skills was</strong></td>
                                <td><?php echo esc_html($report->skills_level); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Level of learning outcome demonstrated by students in relation to attitude was</strong></td>
                                <td><?php echo esc_html($report->attitude_level); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="postbox">
                <h3 class="hndle"><span>(b) Overall, the performance of the students in relation to students of other Medical Colleges:</span></h3>
                <div class="inside">
                    <table class="widefat striped">
                        <tbody>
                            <tr>
                                <td style="width: 200px;"><strong>Overall Performance</strong></td>
                                <td><?php echo esc_html($report->overall_performance); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p><strong>(3) Overall comments (Assessment process, Formative & Summative examination) & suggestions:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->overall_comments)); ?></div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <?php
}

function eer_live_search_callback() {
    global $wpdb;
    $table = $wpdb->prefix . 'examiner_reports';

    $search_query = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $filter_subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $filter_professional = isset($_POST['professional']) ? sanitize_text_field($_POST['professional']) : '';

    $where_sql = "WHERE 1=1";
    $query_args = [];

    if ($filter_subject) {
        $where_sql .= " AND subject = %s";
        $query_args[] = $filter_subject;
    }

    if ($filter_professional) {
        $where_sql .= " AND professional = %s";
        $query_args[] = $filter_professional;
    }

    if ($search_query) {
        $where_sql .= " AND (teacher_name LIKE %s OR professional LIKE %s)";
        $like = '%' . $wpdb->esc_like($search_query) . '%';
        $query_args[] = $like;
        $query_args[] = $like;
    }

    $sql = "SELECT * FROM $table $where_sql ORDER BY submitted_at DESC";
    if (!empty($query_args)) {
        $reports = $wpdb->get_results($wpdb->prepare($sql, $query_args));
    } else {
        $reports = $wpdb->get_results($sql);
    }

    if (!empty($reports)) {
        foreach ($reports as $r) {
            ?>
            <tr>
                <td class="check-column"><input type="checkbox" name="report_ids[]" value="<?php echo $r->id; ?>"></td>
                <td>
                    <span class="eer-id-column">#<?php echo $r->id; ?></span>
                </td>
                <td><?php echo esc_html($r->teacher_name); ?></td>
                <td><?php echo esc_html($r->subject); ?></td>
                <td><?php echo esc_html($r->professional); ?></td>
                <td><?php echo esc_html($r->overall_performance); ?></td>
                <td><?php echo date_i18n(get_option('date_format'), strtotime($r->submitted_at)); ?></td>
                <td>
                    <a href="?page=eer-reports&action=view&report_id=<?php echo $r->id; ?>" class="button button-small">View Details</a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="8" style="text-align: center; padding: 30px;">No reports found.</td></tr>';
    }
    wp_die();
}

function eer_admin_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'examiner_reports';

    // Get total reports
    $total_reports = $wpdb->get_var("SELECT COUNT(*) FROM $table");

    if (isset($_GET['action']) && $_GET['action'] === 'view' && isset($_GET['report_id'])) {
        $report_id = intval($_GET['report_id']);
        $report = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $report_id));

        if ($report) {
            eer_display_single_report($report);
        } else {
            echo '<div class="wrap"><h1>Report not found</h1><p>The requested report could not be found.</p><a href="?page=eer-reports" class="button">Back to all reports</a></div>';
        }
        return; // Stop rendering the dashboard
    }

    // Handle Filters
    $filter_subject = isset($_GET['filter_subject']) ? sanitize_text_field($_GET['filter_subject']) : '';
    $filter_professional = isset($_GET['filter_professional']) ? sanitize_text_field($_GET['filter_professional']) : '';
    $search_query = isset($_GET['eer_search']) ? sanitize_text_field($_GET['eer_search']) : '';

    $where_sql = "WHERE 1=1";
    $query_args = [];

    if ($filter_subject) {
        $where_sql .= " AND subject = %s";
        $query_args[] = $filter_subject;
    }

    if ($filter_professional) {
        $where_sql .= " AND professional = %s";
        $query_args[] = $filter_professional;
    }

    if ($search_query) {
        $where_sql .= " AND (teacher_name LIKE %s OR professional LIKE %s)";
        $like = '%' . $wpdb->esc_like($search_query) . '%';
        $query_args[] = $like;
        $query_args[] = $like;
    }

    // Get filtered reports
    $sql = "SELECT * FROM $table $where_sql ORDER BY submitted_at DESC";
    if (!empty($query_args)) {
        $reports = $wpdb->get_results($wpdb->prepare($sql, $query_args));
    } else {
        $reports = $wpdb->get_results($sql);
    }

    // Get options for filter dropdowns
    $available_subjects = $wpdb->get_col("SELECT DISTINCT subject FROM $table WHERE subject != '' ORDER BY subject");
    $available_professionals = $wpdb->get_col("SELECT DISTINCT professional FROM $table WHERE professional != '' ORDER BY professional");
    
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'dashboard';
    ?>

    <div class="wrap">
        <h1>External Examiner Report Dashboard</h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=eer-reports&tab=dashboard" class="nav-tab <?php echo $active_tab === 'dashboard' ? 'nav-tab-active' : ''; ?>">Dashboard</a>
            <a href="?page=eer-reports&tab=settings" class="nav-tab <?php echo $active_tab === 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        </h2>

        <?php
        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
        }
        if (isset($_GET['report-submitted']) && $_GET['report-submitted'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>Report submitted successfully.</p></div>';
        }
        
        if ($active_tab === 'settings') {
            ?>
            <div class="card" style="max-width: 100%; margin-top: 20px; padding: 20px;">
                <h3>Shortcode</h3>
                <p>Use this shortcode to display the form on any page:</p>
                <p><input type="text" value="[external_examiner_report]" class="large-text" readonly onclick="this.select();"></p>
            </div>
            <?php
        } else {
        ?>

        <div class="eer-reports-card">
            <div class="eer-reports-header">
                <h2 class="eer-reports-title">All Submitted Reports</h2>
            </div>
            
            <div class="eer-filter-bar">
                <form method="get" action="" class="eer-filter-group">
                    <input type="hidden" name="page" value="eer-reports">
                    <input type="search" id="eer-search-input" name="eer_search" value="<?php echo esc_attr($search_query); ?>" placeholder="Search Teacher or Professional" autocomplete="off">
                    <select name="filter_subject">
                        <option value="">All Subjects</option>
                        <?php foreach ($available_subjects as $subj) : ?>
                            <option value="<?php echo esc_attr($subj); ?>" <?php selected($filter_subject, $subj); ?>><?php echo esc_html($subj); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select name="filter_professional">
                        <option value="">All Professionals</option>
                        <?php foreach ($available_professionals as $prof) : ?>
                            <option value="<?php echo esc_attr($prof); ?>" <?php selected($filter_professional, $prof); ?>><?php echo esc_html($prof); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" class="button" value="Filter">
                </form>

            </div>

            <form method="post" action="">
            <?php wp_nonce_field('eer_bulk_action', 'eer_bulk_nonce'); ?>
            <div class="tablenav top" style="padding: 10px 20px; clear: both;">
                <div class="alignleft actions bulkactions">
                    <select name="eer_action" id="bulk-action-selector-top">
                        <option value="-1">Bulk Actions</option>
                        <option value="delete_selected">Delete Selected</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="Apply">
                </div>
            </div>

            <table class="eer-custom-table">
                <thead>
                    <tr>
                        <th class="manage-column column-cb check-column"><input type="checkbox" id="cb-select-all-1"></th>
                        <th>ID</th>
                        <th>Teacher Name</th>
                        <th>Subject</th>
                        <th>Professional</th>
                        <th>Overall Performance</th>
                        <th>Date Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="eer-reports-body">
                    <?php if (!empty($reports)) : ?>
                        <?php foreach ($reports as $r) : ?>
                            <tr>
                                <td class="check-column"><input type="checkbox" name="report_ids[]" value="<?php echo $r->id; ?>"></td>
                                <td>
                                    <span class="eer-id-column">#<?php echo $r->id; ?></span>
                                </td>
                                <td><?php echo esc_html($r->teacher_name); ?></td>
                                <td><?php echo esc_html($r->subject); ?></td>
                                <td><?php echo esc_html($r->professional); ?></td>
                                <td><?php echo esc_html($r->overall_performance); ?></td>
                                <td><?php echo date_i18n(get_option('date_format'), strtotime($r->submitted_at)); ?></td>
                                <td>
                                    <a href="?page=eer-reports&action=view&report_id=<?php echo $r->id; ?>" class="button button-small">View Details</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px;">No reports found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </form>

            <script type="text/javascript">
            jQuery(document).ready(function($) {
                var searchTimer;
                $('#eer-search-input, select[name="filter_subject"], select[name="filter_professional"]').on('input change', function() {
                    clearTimeout(searchTimer);
                    var search = $('#eer-search-input').val();
                    var subject = $('select[name="filter_subject"]').val();
                    var professional = $('select[name="filter_professional"]').val();

                    searchTimer = setTimeout(function() {
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'eer_live_search',
                                search: search,
                                subject: subject,
                                professional: professional
                            },
                            success: function(response) {
                                $('#eer-reports-body').html(response);
                            }
                        });
                    }, 300);
                });

                // Select All checkbox
                $('#cb-select-all-1').on('click', function() {
                    $('input[name="report_ids[]"]').prop('checked', this.checked);
                });
            });
            </script>
        </div>
        <?php } ?>
    </div>
<?php }
