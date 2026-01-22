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

        <div id="poststuff" style="margin-top: 20px;">
            <div class="postbox">
                <h2 class="hndle"><span>General Information</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <tbody>
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
            $fa_questions = get_option('eer_fa_questions', []);
            ?>
            <div class="postbox">
                <h2 class="hndle"><span>(a) Formative Assessment</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Criteria</th>
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
                    <p><strong>Improvements:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->fa_improvement)); ?></div>
                </div>
            </div>

            <?php $ap_questions = get_option('eer_ap_questions', []); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(b) Quality of Summative Assessments</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Criteria</th>
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
                    <p><strong>Improvements:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->ap_improvement)); ?></div>
                </div>
            </div>

            <?php $se_questions = get_option('eer_se_questions', []); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(c) Making by internal examiner</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Criteria</th>
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
                    <p><strong>Improvements:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->se_improvement)); ?></div>
                </div>
            </div>

            <div class="postbox">
                <h2 class="hndle"><span>Student Performance</span></h2>
                <div class="inside">
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Domain</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Knowledge</strong></td>
                                <td><?php echo esc_html($report->knowledge_level); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Skills</strong></td>
                                <td><?php echo esc_html($report->skills_level); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Attitude</strong></td>
                                <td><?php echo esc_html($report->attitude_level); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="postbox">
                <h2 class="hndle"><span>Overall Performance & Comments</span></h2>
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
                    <p><strong>Overall Comments:</strong></p>
                    <div style="background: #fff; border: 1px solid #ccd0d4; padding: 10px;"><?php echo nl2br(esc_html($report->overall_comments)); ?></div>
                </div>
            </div>

        </div>
    </div>
    <?php
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


    $avg_ratings = null;
    $avg_ap = null;
    $avg_se = null;
    $performance_dist = [];
    $knowledge_dist = [];
    $skills_dist = [];
    $attitude_dist = [];
    $subject_dist = [];

    if ($total_reports > 0) {
        // Get average ratings for formative assessment
        $avg_ratings = $wpdb->get_row("SELECT AVG(fa1) as fa1, AVG(fa2) as fa2, AVG(fa3) as fa3, AVG(fa4) as fa4 FROM $table");
        // Get average ratings for assessment process
        $avg_ap = $wpdb->get_row("SELECT AVG(ospe_quality) as ospe, AVG(clinical_quality) as clinical, AVG(practical_quality) as practical, AVG(soe_quality) as soe FROM $table");
        // Get average ratings for standard of examination
        $avg_se = $wpdb->get_row("SELECT AVG(se1) as se1, AVG(se2) as se2, AVG(se3) as se3, AVG(se4) as se4 FROM $table");

        // Get overall performance distribution
        $performance_dist = $wpdb->get_results("SELECT overall_performance, COUNT(*) as count FROM $table GROUP BY overall_performance", OBJECT_K);
        $knowledge_dist = $wpdb->get_results("SELECT knowledge_level, COUNT(*) as count FROM $table GROUP BY knowledge_level", OBJECT_K);
        $skills_dist = $wpdb->get_results("SELECT skills_level, COUNT(*) as count FROM $table GROUP BY skills_level", OBJECT_K);
        $attitude_dist = $wpdb->get_results("SELECT attitude_level, COUNT(*) as count FROM $table GROUP BY attitude_level", OBJECT_K);

        // Get report counts by subject
        $subject_dist = $wpdb->get_results("SELECT subject, COUNT(*) as count FROM $table GROUP BY subject");
    }

    // Handle Filters
    $filter_subject = isset($_GET['filter_subject']) ? sanitize_text_field($_GET['filter_subject']) : '';
    $filter_professional = isset($_GET['filter_professional']) ? sanitize_text_field($_GET['filter_professional']) : '';

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
    ?>

    <div class="wrap">
        <h1>External Examiner Report Dashboard</h1>

        <?php
        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
            echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
        }
        ?>

        <?php if ($total_reports > 0) : ?>
        <div id="dashboard-widgets-wrap">
            <div id="dashboard-widgets" class="metabox-holder">
                <div class="postbox-container" style="width:100%">
                    <div class="meta-box-sortables">
                        <div class="postbox">
                            <h2 class="hndle"><span>Summary</span></h2>
                            <div class="inside">
                                <p><strong>Total Reports:</strong> <?php echo $total_reports; ?></p>
                                <h4>Reports by Subject:</h4>
                                <table class="widefat striped">
                                    <thead><tr><th>Subject</th><th>Count</th></tr></thead>
                                    <tbody>
                                        <?php if (!empty($subject_dist)) : ?>
                                            <?php foreach ($subject_dist as $row) : ?>
                                                <tr><td><?php echo esc_html($row->subject); ?></td><td><?php echo $row->count; ?></td></tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="2">No data</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <br>
                                <h4>Average Formative Assessment Ratings (out of 5):</h4>
                                <?php
                                $questions = get_option('eer_fa_questions', [
                                    'fa1' => 'Formative assessment procedures were satisfactory',
                                    'fa2' => 'Records of formative assessment were adequate',
                                    'fa3' => 'Question papers and scripts were available',
                                    'fa4' => 'Opportunity to scrutinize scripts was given'
                                ]);
                                ?>
                                <table class="widefat striped">
                                    <thead><tr><th>Question</th><th>Avg Score</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($questions as $key => $label) : ?>
                                            <tr><td><?php echo esc_html($label); ?></td><td><strong><?php echo number_format($avg_ratings->$key, 2); ?></strong></td></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Assessment Process Quality (Avg)</span></h2>
                            <div class="inside">
                                <?php
                                $ap_questions_opt = get_option('eer_ap_questions', [
                                    'ospe_quality' => 'Quality of OSPE/OSCE',
                                    'clinical_quality' => 'Quality of Clinical Exam',
                                    'practical_quality' => 'Quality of Practical Exam',
                                    'soe_quality' => 'Quality of SOE'
                                ]);
                                $ap_labels = [
                                    'ospe' => $ap_questions_opt['ospe_quality'],
                                    'clinical' => $ap_questions_opt['clinical_quality'],
                                    'practical' => $ap_questions_opt['practical_quality'],
                                    'soe' => $ap_questions_opt['soe_quality']
                                ];
                                ?>
                                <table class="widefat striped">
                                    <thead><tr><th>Question</th><th>Avg Score</th></tr></thead>
                                    <tbody>
                                        <?php foreach ($ap_labels as $key => $label) : ?>
                                            <tr><td><?php echo esc_html($label); ?></td><td><strong><?php echo number_format($avg_ap->$key, 2); ?></strong></td></tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Standard of Examination (Avg)</span></h2>
                            <div class="inside">
                                <?php
                                $se_questions = get_option('eer_se_questions', [
                                    'se1' => 'Marking by internal examiners for SOE was as per rating scale',
                                    'se2' => 'Marking by internal examiners for OSPE was as per rating scale',
                                    'se3' => 'Marking by internal examiners for Practical examination was logical',
                                    'se4' => 'Marking by internal examiners for Clinical skill assessment was appropriate'
                                ]);
                                ?>
                                <table class="widefat striped">
                                    <thead><tr><th>Question</th><th>Avg Score</th></tr></thead>
                                    <tbody>
                                        <?php if ($avg_se) : ?>
                                            <?php foreach ($se_questions as $key => $label) : ?>
                                                <tr><td><?php echo esc_html($label); ?></td><td><strong><?php echo number_format($avg_se->$key, 2); ?></strong></td></tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Overall Performance Distribution</span></h2>
                            <div class="inside">
                                <table class="widefat striped">
                                    <thead><tr><th>Level</th><th>Count</th></tr></thead>
                                    <tbody>
                                        <tr><td>Above expectation</td><td><?php echo isset($performance_dist['Above expectation']) ? $performance_dist['Above expectation']->count : 0; ?></td></tr>
                                        <tr><td>Met expectation</td><td><?php echo isset($performance_dist['Met expectation']) ? $performance_dist['Met expectation']->count : 0; ?></td></tr>
                                        <tr><td>Below expectation</td><td><?php echo isset($performance_dist['Below expectation']) ? $performance_dist['Below expectation']->count : 0; ?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Student Performance Breakdown</span></h2>
                            <div class="inside">
                                <table class="widefat striped">
                                    <thead><tr><th>Domain</th><th>Above</th><th>Met</th><th>Below</th></tr></thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Knowledge</strong></td>
                                            <td><?php echo isset($knowledge_dist['Above expectation']) ? $knowledge_dist['Above expectation']->count : 0; ?></td>
                                            <td><?php echo isset($knowledge_dist['Met expectation']) ? $knowledge_dist['Met expectation']->count : 0; ?></td>
                                            <td><?php echo isset($knowledge_dist['Below expectation']) ? $knowledge_dist['Below expectation']->count : 0; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Skills</strong></td>
                                            <td><?php echo isset($skills_dist['Above expectation']) ? $skills_dist['Above expectation']->count : 0; ?></td>
                                            <td><?php echo isset($skills_dist['Met expectation']) ? $skills_dist['Met expectation']->count : 0; ?></td>
                                            <td><?php echo isset($skills_dist['Below expectation']) ? $skills_dist['Below expectation']->count : 0; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Attitude</strong></td>
                                            <td><?php echo isset($attitude_dist['Above expectation']) ? $attitude_dist['Above expectation']->count : 0; ?></td>
                                            <td><?php echo isset($attitude_dist['Met expectation']) ? $attitude_dist['Met expectation']->count : 0; ?></td>
                                            <td><?php echo isset($attitude_dist['Below expectation']) ? $attitude_dist['Below expectation']->count : 0; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <h2>All Submitted Reports</h2>

        <!-- Filter Form -->
        <form method="get" action="" style="margin-bottom: 15px; background: #fff; padding: 10px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
            <input type="hidden" name="page" value="eer-reports">
            <div class="alignleft actions">
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
                <input type="submit" class="button" value="Filter Results">
            </div>
            <br class="clear">
        </form>

        <form method="post" action="" style="margin-bottom: 20px;" onsubmit="return confirm('Are you sure you want to delete ALL reports? This action cannot be undone.');">
            <?php wp_nonce_field('eer_delete_all_reports', 'eer_delete_nonce'); ?>
            <input type="hidden" name="eer_action" value="delete_all">
            <input type="submit" class="button button-link-delete" value="Delete All Reports">
        </form>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-primary">ID</th>
                    <th scope="col" class="manage-column">Subject</th>
                    <th scope="col" class="manage-column">Professional</th>
                    <th scope="col" class="manage-column">Overall Performance</th>
                    <th scope="col" class="manage-column">Date Submitted</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php if (!empty($reports)) : ?>
                    <?php foreach ($reports as $r) : ?>
                        <tr>
                            <td class="column-primary" data-colname="ID">
                                <a href="?page=eer-reports&action=view&report_id=<?php echo $r->id; ?>"><strong><?php echo $r->id; ?></strong></a>
                                <div class="row-actions">
                                    <span class="view"><a href="?page=eer-reports&action=view&report_id=<?php echo $r->id; ?>">View Details</a></span>
                                </div>
                            </td>
                            <td data-colname="Subject"><?php echo esc_html($r->subject); ?></td>
                            <td data-colname="Professional"><?php echo esc_html($r->professional); ?></td>
                            <td data-colname="Overall Performance"><?php echo esc_html($r->overall_performance); ?></td>
                            <td data-colname="Date Submitted"><?php echo esc_html($r->submitted_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="no-items">
                        <td class="colspanchange" colspan="5">No reports found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php }
