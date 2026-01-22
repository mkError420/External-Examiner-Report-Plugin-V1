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
                    <p><strong>Subject:</strong> <?php echo esc_html($report->subject); ?></p>
                    <p><strong>Professional:</strong> <?php echo esc_html($report->professional); ?></p>
                    <p><strong>Exam Period:</strong> <?php echo esc_html($report->exam_period); ?></p>
                    <p><strong>Start Date:</strong> <?php echo esc_html($report->start_date); ?></p>
                    <p><strong>End Date:</strong> <?php echo esc_html($report->end_date); ?></p>
                    <p><strong>Submitted At:</strong> <?php echo esc_html($report->submitted_at); ?></p>
                </div>
            </div>

            <?php
            $fa_questions = get_option('eer_fa_questions', []);
            ?>
            <div class="postbox">
                <h2 class="hndle"><span>(a) Formative Assessment</span></h2>
                <div class="inside">
                    <?php foreach ($fa_questions as $key => $label): if(isset($report->$key)) : ?>
                        <p><strong><?php echo esc_html($label); ?>:</strong> <?php echo eer_get_rating_label($report->$key); ?></p>
                    <?php endif; endforeach; ?>
                    <hr>
                    <p><strong>Improvements:</strong></p>
                    <p><?php echo nl2br(esc_html($report->fa_improvement)); ?></p>
                </div>
            </div>

            <?php $ap_questions = get_option('eer_ap_questions', []); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(b) Quality of Summative Assessments</span></h2>
                <div class="inside">
                    <?php foreach ($ap_questions as $key => $label): if(isset($report->$key)) : ?>
                        <p><strong><?php echo esc_html($label); ?>:</strong> <?php echo eer_get_rating_label($report->$key); ?></p>
                    <?php endif; endforeach; ?>
                    <hr>
                    <p><strong>Improvements:</strong></p>
                    <p><?php echo nl2br(esc_html($report->ap_improvement)); ?></p>
                </div>
            </div>

            <?php $se_questions = get_option('eer_se_questions', []); ?>
            <div class="postbox">
                <h2 class="hndle"><span>(c) Making by internal examiner</span></h2>
                <div class="inside">
                    <?php foreach ($se_questions as $key => $label): if(isset($report->$key)) : ?>
                        <p><strong><?php echo esc_html($label); ?>:</strong> <?php echo eer_get_rating_label($report->$key); ?></p>
                    <?php endif; endforeach; ?>
                    <hr>
                    <p><strong>Improvements:</strong></p>
                    <p><?php echo nl2br(esc_html($report->se_improvement)); ?></p>
                </div>
            </div>

            <div class="postbox">
                <h2 class="hndle"><span>Student Performance</span></h2>
                <div class="inside">
                    <p><strong>Knowledge:</strong> <?php echo esc_html($report->knowledge_level); ?></p>
                    <p><strong>Skills:</strong> <?php echo esc_html($report->skills_level); ?></p>
                    <p><strong>Attitude:</strong> <?php echo esc_html($report->attitude_level); ?></p>
                </div>
            </div>

            <div class="postbox">
                <h2 class="hndle"><span>Overall Performance & Comments</span></h2>
                <div class="inside">
                    <p><strong>Overall Performance:</strong> <?php echo esc_html($report->overall_performance); ?></p>
                    <hr>
                    <p><strong>Overall Comments:</strong></p>
                    <p><?php echo nl2br(esc_html($report->overall_comments)); ?></p>
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

    // Get all reports for the table
    $reports = $wpdb->get_results("SELECT * FROM $table ORDER BY submitted_at DESC");
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
                                <ul>
                                    <?php if (!empty($subject_dist)) : ?>
                                        <?php foreach ($subject_dist as $row) : ?>
                                            <li><strong><?php echo esc_html($row->subject); ?>:</strong> <?php echo $row->count; ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                                <hr>
                                <h4>Average Formative Assessment Ratings (out of 5):</h4>
                                <?php
                                $questions = get_option('eer_fa_questions', [
                                    'fa1' => 'Formative assessment procedures were satisfactory',
                                    'fa2' => 'Records of formative assessment were adequate',
                                    'fa3' => 'Question papers and scripts were available',
                                    'fa4' => 'Opportunity to scrutinize scripts was given'
                                ]);
                                ?>
                                <ul>
                                    <?php foreach ($questions as $key => $label) : ?>
                                        <li><?php echo esc_html($label); ?>: <strong><?php echo number_format($avg_ratings->$key, 2); ?></strong></li>
                                    <?php endforeach; ?>
                                </ul>
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
                                <ul>
                                    <?php foreach ($ap_labels as $key => $label) : ?>
                                        <li><?php echo esc_html($label); ?>: <strong><?php echo number_format($avg_ap->$key, 2); ?></strong></li>
                                    <?php endforeach; ?>
                                </ul>
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
                                <ul>
                                    <?php if ($avg_se) : ?>
                                        <?php foreach ($se_questions as $key => $label) : ?>
                                            <li><?php echo esc_html($label); ?>: <strong><?php echo number_format($avg_se->$key, 2); ?></strong></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Overall Performance Distribution</span></h2>
                            <div class="inside">
                                <ul>
                                    <li><strong>Above expectation:</strong> <?php echo isset($performance_dist['Above expectation']) ? $performance_dist['Above expectation']->count : 0; ?></li>
                                    <li><strong>Met expectation:</strong> <?php echo isset($performance_dist['Met expectation']) ? $performance_dist['Met expectation']->count : 0; ?></li>
                                    <li><strong>Below expectation:</strong> <?php echo isset($performance_dist['Below expectation']) ? $performance_dist['Below expectation']->count : 0; ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2 class="hndle"><span>Student Performance Breakdown</span></h2>
                            <div class="inside">
                                <p><strong>Knowledge:</strong><br>
                                Above: <?php echo isset($knowledge_dist['Above expectation']) ? $knowledge_dist['Above expectation']->count : 0; ?> |
                                Met: <?php echo isset($knowledge_dist['Met expectation']) ? $knowledge_dist['Met expectation']->count : 0; ?> |
                                Below: <?php echo isset($knowledge_dist['Below expectation']) ? $knowledge_dist['Below expectation']->count : 0; ?></p>

                                <p><strong>Skills:</strong><br>
                                Above: <?php echo isset($skills_dist['Above expectation']) ? $skills_dist['Above expectation']->count : 0; ?> |
                                Met: <?php echo isset($skills_dist['Met expectation']) ? $skills_dist['Met expectation']->count : 0; ?> |
                                Below: <?php echo isset($skills_dist['Below expectation']) ? $skills_dist['Below expectation']->count : 0; ?></p>

                                <p><strong>Attitude:</strong><br>
                                Above: <?php echo isset($attitude_dist['Above expectation']) ? $attitude_dist['Above expectation']->count : 0; ?> |
                                Met: <?php echo isset($attitude_dist['Met expectation']) ? $attitude_dist['Met expectation']->count : 0; ?> |
                                Below: <?php echo isset($attitude_dist['Below expectation']) ? $attitude_dist['Below expectation']->count : 0; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <h2>All Submitted Reports</h2>
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
