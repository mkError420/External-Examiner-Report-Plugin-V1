<style>
 
    .eer-form-wrapper {
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        color: #333;
    }
    .eer-form-wrapper h3 {
        text-align: center;
        border-bottom: 2px solid #0073aa;
        padding-bottom: 15px;
        margin-bottom: 25px;
        color: #23282d;
        font-size: 1.5em;
    }
    .eer-form-wrapper h4 {
        background: #f9f9f9;
        padding: 12px;
        border-left: 4px solid #0073aa;
        margin-top: 30px;
        margin-bottom: 15px;
        font-size: 1.1em;
        color: #23282d;
    }
    .eer-form-wrapper h5 {
        margin-top: 20px;
        margin-bottom: 10px;
        font-size: 1em;
        color: #444;
        font-weight: 600;
    }
    .eer-input-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
    }
    .eer-form-group {
        flex: 1;
        min-width: 200px;
        margin-bottom: 15px;
    }
    .eer-form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 0.95em;
    }
    .eer-form-group input[type="text"],
    .eer-form-group input[type="date"],
    .eer-form-group select,
    .eer-form-wrapper textarea {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
        line-height: 1.5;
    }
    .eer-form-wrapper textarea {
        min-height: 100px;
        resize: vertical;
    }
    .eer-question-item {
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }
    .eer-question-label {
        font-weight: 500;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .eer-radio-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .eer-radio-options label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9em;
        cursor: pointer;
        background: #fcfcfc;
        padding: 5px 10px;
        border: 1px solid #eee;
        border-radius: 15px;
    }
    .eer-radio-options label:hover {
        background: #f0f0f1;
        border-color: #ccc;
    }
    .eer-submit-btn {
        background: #070d5f;
        color: #fff;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        display: block;
        width: 100%;
        margin-top: 30px;
        font-weight: 600;
    }
    .eer-submit-btn:hover {
        background: #005177;
    }
    .eer-scale-legend {
        color: #ffffff;
        background: #6f6f70;
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 15px;
        text-align: center;
        font-size: medium;
        font-weight: bold;
    }
    .scale{
        text-decoration: none;
        font-weight: 800;
        margin-right: 8px;
        color: #ffece7;
        
    }
    .eer-required {
        color: #d63638;
        margin-left: 3px;
    }
    /* Modal styles */
    .eer-modal {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0,0,0,0.8);
        animation: fadeIn 0.4s;
    }
    .eer-modal-content {
        background-color: #fefefe;
        margin: 0;
        padding: 30px;
        border: 1px solid #888;
        width: 90%;
        max-width: 450px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        position: relative;
        animation: slideIn 0.4s;
    }
    .eer-close {
        position: absolute;
        top: 10px;
        right: 15px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    .eer-close:hover,
    .eer-close:focus {
        color: #000;
        text-decoration: none;
    }
    .eer-success-icon {
        color: #28a745;
        font-size: 60px;
        margin-bottom: 15px;
    }
    .eer-modal-btn {
        background-color: #0073aa;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    .eer-modal-btn:hover {
        background-color: #005177;
    }
    @keyframes fadeIn {
        from {opacity: 0} 
        to {opacity: 1}
    }
    @keyframes slideIn {
        from {transform: translateY(-50px); opacity: 0}
        to {transform: translateY(0); opacity: 1}
    }
</style>

<?php if (isset($_GET['report-submitted']) && $_GET['report-submitted'] === 'true') : ?>
    <div id="eer-success-modal" class="eer-modal">
        <div class="eer-modal-content">
            <span class="eer-close" onclick="document.getElementById('eer-success-modal').style.display='none'">&times;</span>
            <div class="eer-success-icon">&#10004;</div>
            <h2 style="margin-top: 0; color: #333;">Success!</h2>
            <p style="font-size: 16px; color: #666;">Your report has been submitted successfully.</p>
            <button class="eer-modal-btn" onclick="document.getElementById('eer-success-modal').style.display='none'">Close</button>
        </div>
    </div>
    <script>
        window.onclick = function(event) {
            var modal = document.getElementById('eer-success-modal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Remove query param from URL to prevent popup on refresh
        if (window.history.replaceState) {
            var url = new URL(window.location.href);
            url.searchParams.delete('report-submitted');
            window.history.replaceState(null, '', url.toString());
        }
    </script>
<?php endif; ?>

<div class="eer-form-wrapper">
<form method="post">
    <?php wp_nonce_field('eer_submit_form', 'eer_nonce'); ?>

    <h2  style="text-align: center; text-transform: uppercase; font-weight: 800;margin-bottom: 5px; background: #070d5f; border: 1px solid #070d5f; border-radius: 5px; color: #fff;padding: 5px;color: #f0feff;">Rangpur Community Medical College Hospital (RCMCH) </h2>
    <h3>External Examiner's Report</h3>

    <div class="eer-input-row">
        <div class="eer-form-group">
            <label>Teacher Name <span class="eer-required">*</span></label>
            <input type="text" name="teacher_name" required placeholder="Enter Teacher Name">
        </div>
    </div>

    <div class="eer-input-row">
        <div class="eer-form-group">
            <?php
            $subjects_opt = get_option('eer_subjects');
            $subjects = $subjects_opt ? array_map('trim', explode("\n", $subjects_opt)) : [];
            $active_subject = get_option('eer_active_subject', '');
            ?>
            <label>Subject <span class="eer-required">*</span></label>
            <?php if (!empty($subjects)) : ?>
                <select name="subject" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $subject) : ?>
                        <option <?php selected($active_subject, $subject); ?>><?php echo esc_html($subject); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text" name="subject" required placeholder="Enter Subject">
            <?php endif; ?>
        </div>

        <div class="eer-form-group">
            <?php
            $professionals_opt = get_option('eer_professionals', "First\nSecond\nThird\nFinal");
            $professionals = array_map('trim', explode("\n", $professionals_opt));
            $active_prof = get_option('eer_active_professional', '');
            ?>
            <label>Professional <span class="eer-required">*</span></label>
            <select name="professional" required>
                <option value="">Select Here</option>
                <?php foreach ($professionals as $prof) : ?>
                    <option <?php selected($active_prof, $prof); ?>><?php echo esc_html($prof); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="eer-input-row">
        <div class="eer-form-group">
            <label>Period of examination <span class="eer-required">*</span></label>
            <input type="text" name="exam_period" value="<?php echo esc_attr(get_option('eer_active_period')); ?>" placeholder="e.g. May 2023" required>
        </div>
        <div class="eer-form-group">
            <label>Start Date <span class="eer-required">*</span></label>
            <input type="date" name="start_date" value="<?php echo esc_attr(get_option('eer_active_start')); ?>" required>
        </div>
        <div class="eer-form-group">
            <label>End Date <span class="eer-required">*</span></label>
            <input type="date" name="end_date" value="<?php echo esc_attr(get_option('eer_active_end')); ?>" required>
        </div>
    </div>

    <h4>(1) Assessment Process</h4>
    
    <h5>(a) Formative assessment procedures were satisfactory (All terms & card exam)</h5>
    <div class="eer-scale-legend"><span class="scale">SCALE:</span> SA - Strongly Agree (5), A - Agree (4), U - Undecided (3), DA - Disagree (2), SDA - Strongly Disagree (1)</div>

    <?php
    $questions = get_option('eer_fa_questions', [
        'fa1' => 'Formative assessment procedures were satisfactory',
        'fa2' => 'Records of formative assessment were adequate',
        'fa3' => 'Question papers and scripts were available',
        'fa4' => 'Opportunity to scrutinize scripts was given'
    ]);

    $options = [
        'SA (5)' => 5,
        'A (4)' => 4,
        'U (3)' => 3,
        'DA (2)' => 2,
        'SDA (1)' => 1
    ];

    foreach ($questions as $key => $label) {
        echo '<div class="eer-question-item">';
        echo '<div class="eer-question-label">' . esc_html($label) . ' <span class="eer-required">*</span></div>';
        echo '<div class="eer-radio-options">';
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='" . esc_attr($key) . "' value='" . esc_attr($val) . "' required> " . esc_html($text) . "</label>";
        }
        echo '</div></div>';
    }
    ?>

    <div class="eer-form-group" style="margin-top: 15px;">
        <label>Formative Assessment can be further Improved by: <span class="eer-required">*</span></label>
        <textarea name="fa_improvement" required></textarea>
    </div>

    <h5>(b) Quality of Summative Assessments (Professional Examination):</h5>

    <?php
    $ap_questions = get_option('eer_ap_questions', [
        'ospe_quality' => 'Quality of OSPE was appropriate',
        'clinical_quality' => 'Quality of Clinical skill assessment was appropriate',
        'practical_quality' => 'Quality of Practical practical assessment was appropriate',
        'soe_quality' => 'Quality of structured oral examination was appropriate'
    ]);

    foreach ($ap_questions as $key => $label) {
        echo '<div class="eer-question-item">';
        echo '<div class="eer-question-label">' . esc_html($label) . ' <span class="eer-required">*</span></div>';
        echo '<div class="eer-radio-options">';
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='" . esc_attr($key) . "' value='" . esc_attr($val) . "' required> " . esc_html($text) . "</label>";
        }
        echo '</div></div>';
    }
    ?>
    
    <div class="eer-form-group" style="margin-top: 15px;">
        <label>The quality of SOE, OSPE, Traditional Practical, Clinical skill assessment can be further improved by: <span class="eer-required">*</span></label>
        <textarea name="ap_improvement" required></textarea>
    </div>

    <h5>(c) Marking by internal examiner in professional examination:</h5>

    <?php
    $se_questions = get_option('eer_se_questions', [
        'se1' => 'Marking by internal examiners for SOE was as per rating scale',
        'se2' => 'Marking by internal examiners for OSPE was as per rating scale',
        'se3' => 'Marking by internal examiners for Practical examination was logical',
        'se4' => 'Marking by internal examiners for Clinical skill assessment was appropriate'
    ]);

    foreach ($se_questions as $key => $label) {
        echo '<div class="eer-question-item">';
        echo '<div class="eer-question-label">' . esc_html($label) . ' <span class="eer-required">*</span></div>';
        echo '<div class="eer-radio-options">';
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='" . esc_attr($key) . "' value='" . esc_attr($val) . "' required> " . esc_html($text) . "</label>";
        }
        echo '</div></div>';
    }
    ?>

    

    <?php
    $levels_opt = get_option('eer_performance_levels', "Below expectation\nMet expectation\nAbove expectation");
    $levels = array_map('trim', explode("\n", $levels_opt));
    ?>

    <h4>(2) Student Performance (During Professional Examination/Summative Exam)</h4>
    
    <h5>(a) Quality of learning outcomes:</h5>

    <div class="eer-input-row">
        <div class="eer-form-group">
            <label>Level of learning outcome demonstrated by students in relation to knowledge was <span class="eer-required">*</span></label>
            <select name="knowledge_level" required>
                <option value="">Select Here</option>
                <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
            </select>
        </div>
        <div class="eer-form-group">
            <label>Level of learning outcome demonstrated by students in relation to skills was <span class="eer-required">*</span></label>
            <select name="skills_level" required>
                <option value="">Select Here</option>
                <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
            </select>
        </div>
        <div class="eer-form-group">
            <label>Level of learning outcome demonstrated by students in relation to attitude was <span class="eer-required">*</span></label>
            <select name="attitude_level" required>
                <option value="">Select Here</option>
                <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
            </select>
        </div>
    </div>

    <h5>(b) Overall, the performance of the students in relation to students of other Medical Colleges: <span class="eer-required">*</span></h5>
    <div class="eer-form-group">
        <select name="overall_performance" required>
            <option value="">Select Here</option>
            <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
        </select>
    </div>

    <h4>(3) Overall comments (Assessment process, Formative & Summative examination) & suggestions: <span class="eer-required">*</span></h4>
    <div class="eer-form-group">
        <textarea name="overall_comments" required></textarea>
    </div>

    <input type="submit" name="eer_submit" value="Submit Report" class="eer-submit-btn">
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var radios = document.querySelectorAll('.eer-form-wrapper input[type="radio"]');
        radios.forEach(function(radio) {
            if (radio.checked) {
                radio.setAttribute('data-was-checked', 'true');
            }
            radio.addEventListener('click', function() {
                var wasChecked = this.getAttribute('data-was-checked') === 'true';
                var groupName = this.name;
                var group = document.querySelectorAll('input[name="' + groupName + '"]');
                
                group.forEach(function(r) {
                    r.setAttribute('data-was-checked', 'false');
                });

                if (wasChecked) {
                    this.checked = false;
                } else {
                    this.checked = true;
                    this.setAttribute('data-was-checked', 'true');
                }
            });
        });
    });
</script>
</div>
