<form method="post">
    <?php wp_nonce_field('eer_submit_form', 'eer_nonce'); ?>

    <h3>External Examiner Report</h3>

    <?php
    $subjects_opt = get_option('eer_subjects');
    $subjects = $subjects_opt ? array_map('trim', explode("\n", $subjects_opt)) : [];
    $active_subject = get_option('eer_active_subject', '');
    ?>
    <label>Subject</label>
    <?php if (!empty($subjects)) : ?>
        <select name="subject" required>
            <?php foreach ($subjects as $subject) : ?>
                <option <?php selected($active_subject, $subject); ?>><?php echo esc_html($subject); ?></option>
            <?php endforeach; ?>
        </select>
    <?php else: ?>
        <input type="text" name="subject" required>
    <?php endif; ?>

    <?php
    $professionals_opt = get_option('eer_professionals', "First\nSecond\nThird\nFinal");
    $professionals = array_map('trim', explode("\n", $professionals_opt));
    $active_prof = get_option('eer_active_professional', '');
    ?>
    <label>Professional</label>
    <select name="professional">
        <?php foreach ($professionals as $prof) : ?>
            <option <?php selected($active_prof, $prof); ?>><?php echo esc_html($prof); ?></option>
        <?php endforeach; ?>
    </select>

    <label>Period of examination:</label><br>
    <input type="text" name="exam_period" value="<?php echo esc_attr(get_option('eer_active_period')); ?>">
    <br>
    <label>Start Date</label>
    <input type="date" name="start_date" value="<?php echo esc_attr(get_option('eer_active_start')); ?>">

    <label>End Date</label>
    <input type="date" name="end_date" value="<?php echo esc_attr(get_option('eer_active_end')); ?>">

    <h4>(1)Assessment Process</h4>
    <h5> (a) Formative assessment procedures were satisfactory(All terms & card exam)</h5>
      <h4 class="text-center, color-gray">SA-strongly agree, A-agree, U-undecided, DA-disagree, SDA-Strongly Disagree</h4>

    <?php
    $questions = get_option('eer_fa_questions', [
        'fa1' => 'Formative assessment procedures were satisfactory',
        'fa2' => 'Records of formative assessment were adequate',
        'fa3' => 'Question papers and scripts were available',
        'fa4' => 'Opportunity to scrutinize scripts was given'
    ]);

    foreach ($questions as $key => $label) {
        echo "<p>$label<br>";
        $options = [
            'SA(1)' => 5,
            'A (2)' => 4,
            'U (3)' => 3,
            'DA (4)' => 2,
            'SDA (5)' => 1
        ];
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='$key' value='$val' required> $text</label> ";
        }
        echo "</p>";
    }
    ?>

    <label>Formative Assessment can be further Improved by:</label>
    <textarea name="fa_improvement"></textarea>

    <h5>(b) Quality of Summative Assessments (professional Examination):</h5>

    <?php
    $ap_questions = get_option('eer_ap_questions', [
        'ospe_quality' => 'Quality of OSPE was appropriate',
        'clinical_quality' => 'Quality of Clinical skill assessment was appropriate',
        'practical_quality' => 'Quality of Practical practical assessment was appropriate',
        'soe_quality' => 'Quality of structured oral examination was appropriate'
    ]);

    foreach ($ap_questions as $key => $label) {
        echo "<p>$label<br>";
        $options = [
            'SA(1)' => 5,
            'A (2)' => 4,
            'U (3)' => 3,
            'DA (4)' => 2,
            'SDA (5)' => 1
        ];
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='$key' value='$val' required> $text</label> ";
        }
        echo "</p>";
    }
    ?>
    <label>The quality of SOE, OSPE, Traditional Practical, Clinical skill assessment can be further improved by:</label>
    <textarea name="ap_improvement"></textarea>

    <h5>(c) Making by internal examiner in professional examination:</h5>

    <?php
    $se_questions = get_option('eer_se_questions', [
        'se1' => 'Marking by internal examiners for SOE was as per rating scale',
        'se2' => 'Marking by internal examiners for OSPE was as per rating scale',
        'se3' => 'Marking by internal examiners for Practical examination was logical',
        'se4' => 'Marking by internal examiners for Clinical skill assessment was appropriate'
    ]);

    foreach ($se_questions as $key => $label) {
        echo "<p>$label<br>";
        $options = [
            'SA(1)' => 5,
            'A (2)' => 4,
            'U (3)' => 3,
            'DA (4)' => 2,
            'SDA (5)' => 1
        ];
        foreach ($options as $text => $val) {
            echo "<label><input type='radio' name='$key' value='$val' required> $text</label> ";
        }
        echo "</p>";
    }
    ?>

    <?php
    $levels_opt = get_option('eer_performance_levels', "Below expectation\nMet expectation\nAbove expectation");
    $levels = array_map('trim', explode("\n", $levels_opt));
    ?>

    <h4>(2)Student Performance(During Professional Examination/summative exam.)</h4>
     <h5> (a) Quality of learning otucomes:</h5>

    <label>Lavel of learning outcome demonstrated by students in relation to knowledge was</label>
    <select name="knowledge_level">
        <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
    </select>

    <label>Lavel of learning outcome demonstrated by students in relation to skills was</label>
    <select name="skills_level">
        <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
    </select>

    <label>Lavel of learning outcome demonstrated by students in relation to attituade was</label>
    <select name="attitude_level">
        <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
    </select>

    
     <h5> (b) Overall, the performance of the students in relation to students of other Medical:</h5>
    <select name="overall_performance">
        <?php foreach ($levels as $level) echo "<option>" . esc_html($level) . "</option>"; ?>
    </select>

    <h4>(3) Overall comments (assessment process, Formative & summative examination) & suggestions:</h4>
    <textarea name="overall_comments"></textarea>

    <br><br>
    <input type="submit" name="eer_submit" value="Submit Report">

    
</form>
