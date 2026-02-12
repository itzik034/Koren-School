<?php

include("../config/connection.php");
include("../helpers/function.php");

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    die("syntax error");
}

if ($action == "update_bin_list") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) == 1) {
        while ($row = mysqli_fetch_array($query)) {
            $num_bins = (int) $row['sub_bin_num'];
            $curr_bin = round($num_bins / 2);

            echo '<option value="0" id="0">כל הבינים</option>';

            for ($i = 1; $i <= $num_bins; $i++) {
                if ($i == $curr_bin) {
                    echo '<option value="' . $i . '" id="' . $i . '" selected>' . $i . '</option>';
                } else {
                    echo '<option value="' . $i . '" id="' . $i . '">' . $i . '</option>';
                }
            }
        }
    } else {
        echo "error";
    }
}

if ($action == "add_quiz") {
    $quiz_name = $_GET['quiz_name'];
    $course_id = $_SESSION['c_id'];
    $sql = "INSERT INTO quizzes (`id`, `quiz_name`, `quiz_course_id`) VALUES (NULL, '$quiz_name', '$course_id')";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if ($action == "get_course_name_by_id") {
    $course_id = $_GET['course_id'];
    $sql = "SELECT * FROM courses WHERE `id` = '$course_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['course_name'];
        }
    }
}

if ($action == "get_course_name_by_id3") {
    if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
        die();
    }
    $course_id = $_GET['course_id'];
    $sql = "SELECT * FROM courses WHERE `id` = '$course_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $level_name = get_level_name($row['course_level']);
            echo $row['course_name'] . ' - ' . $level_name;
        }
    }
}

if ($action == "add_quiz_update_course_list") {
    $sql = "SELECT * FROM courses WHERE `course_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $level_name = get_level_name($row['course_level']);
            echo '<option value="' . $row['id'] . '">' . $row['course_name'] . ' - ' . $level_name . '</option>';
        }
    }
}

if ($action == "add_quiz_load_quizzes_list") {
    $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['quiz_name'] . '<br>';
    }
}

if ($action == "add_subject_load_quizzes_list") {
    $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option value="' . $row['id'] . '" id="' . $row['id'] . '">' . $row['quiz_name'] . '</option>';
    }
}

if ($action == "add_subject_load_subjects_list") {
    $sql = "SELECT * FROM subjects WHERE `sub_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_name'] . '<br>';
    }
}

if ($action == "add_que_load_subs_list") {
    $sql = "SELECT * FROM subjects WHERE `sub_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option value="' . $row['id'] . '" id="' . $row['id'] . '">' . $row['sub_name'] . '</option>';
    }
}

if ($action == "load_subs_list_by_quiz_id") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM subjects WHERE sub_quiz_id = '$quiz_id' AND `sub_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '" id="' . $row['id'] . '">' . $row['sub_name'] . '</option>';
        }
    } else {
        echo '<option value="0">אין נושאים בשאלון זה</option>';
    }
}

if ($action == "add_que_load_ques_list") {
    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['que_text'] . '<br>';
    }
}

if ($action == "load_que_list_by_bin") {
    $sub_id = $_GET['sub_id'];
    $bin = $_GET['bin'];
    $sql = "SELECT * FROM questions WHERE que_subject = '$sub_id' AND que_bin = '$bin' AND `que_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '">' . $row['que_text'] . '</option>';
        }
    } else {
        echo '<option value="0">אין שאלות בבין זה</option>';
    }
}

if ($action == "load_que_list_by_sub") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM questions WHERE `que_subject` = '$sub_id' AND `que_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '">' . $row['que_text'] . '</option>';
        }
    } else {
        echo '<option value="0">אין שאלות בנושא זה</option>';
    }
}

if ($action == "add_ans_update_ques_list") {
    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo '<option value="' . $row['id'] . '">' . $row['que_text'] . '</option>';
    }
}

if ($action == "add_ans_load_ans_list") {
    $sql = "SELECT * FROM answears";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['ans_text'] . '<br>';
    }
}

if ($action == "add_quiz_upload_new_quiz") {
    $quiz_name = $_GET['quiz_name'];
    $course_id = $_GET['course_id'];
    $sql = "INSERT INTO `quizzes`(`id`, `quiz_name`, `quiz_course_id`) VALUES (NULL,'$quiz_name','$course_id')";
    mysqli_query($conn, $sql) or die('11');
}

if ($action == "add_subject_upload_new_subject") {
    $sub_name = $_GET['sub_name'];
    $quiz_id = $_GET['quiz_id'];
    $bin_num = $_GET['bin_num'];
    $sql = "INSERT INTO `subjects`(`id`, `sub_name`, `sub_quiz_id`, `sub_bin_num`) VALUES (NULL,'$sub_name','$quiz_id','$bin_num')";
    mysqli_query($conn, $sql) or die('11');
}

if ($action == "add_que_upload_new") {
    $que_content = $_GET['que_content'];
    $que_sub = $_GET['que_sub'];
    $que_bin = $_GET['que_bin'];
    $sql = "INSERT INTO `questions`(`id`, `que_text`, `que_bin`, `que_subject`) 
                VALUES (NULL,'$que_content','$que_bin','$que_sub')";
    mysqli_query($conn, $sql) or die('11');
}

if ($action == "add_ans_upload_new") {
    $que_id = $_GET['que_id'];
    $ans0 = $_GET['ans0'];
    $ans1 = $_GET['ans1'];
    $ans2 = $_GET['ans2'];
    $ans3 = $_GET['ans3'];
    $ans4 = $_GET['ans4'];
    $ans5 = $_GET['ans5'];
    $ans6 = $_GET['ans6'];

    if (!empty($ans0) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans0','$que_id','1')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 000;
    }

    if (!empty($ans1) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans1','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 111;
    }

    if (!empty($ans2) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans2','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 222;
    }

    if (!empty($ans3) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans3','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 333;
    }

    if (!empty($ans4) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans4','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 444;
    }

    if (!empty($ans5) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans5','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 555;
    }

    if (!empty($ans6) && !empty($que_id)) {
        $sql = "INSERT INTO `answears`(`id`, `ans_text`, `ans_question`, `ans_correct`) VALUES (NULL,'$ans6','$que_id','0')";
        mysqli_query($conn, $sql) or die('11');
    } else {
        echo 6666;
    }
}

if ($action == 'add_ans_load_ans_fields') {
    $que_id = $_GET['que_id'];
    $fields_data = array();
    $sql = "SELECT * FROM answears WHERE ans_question = '$que_id' AND ans_correct = 0";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        array_push($fields_data, $row['ans_text']);
    }
    $json_data = json_encode($fields_data);
    echo $json_data;
}

if ($action == 'add_ans_load_ans_fields_correct') {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM answears WHERE ans_question = '$que_id' AND ans_correct = 1 LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['ans_text'];
    }
}

if ($action == 'get_subject_by_que_id') {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['que_subject'];
    }
}

if ($action == 'get_bin_by_que_id') {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['que_bin'];
    }
}

if ($action == 'get_quiz_by_que_id') {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['que_quiz_id'];
    }
}

if ($action == "get_quiz_id_by_sub_id") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_quiz_id'];
    }
}

if ($action == "get_sub_by_que_id") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['que_subject'];
    }
}

if ($action == 'get_subjects_table') {
    $sql = "SELECT * FROM subjects WHERE `sub_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    ?>

    <tr class="subt_first_row subt_row">
        <th class="subt_col subt_col_fr">ID</th>
        <th class="subt_col subt_col_fr">נושא</th>
        <th class="subt_col subt_col_fr">שאלון</th>
        <th class="subt_col subt_col_fr">מספר בינים</th>
        <th class="subt_col subt_col_fr">הסבר מילולי</th>
        <th class="subt_col subt_col_fr">תמונה</th>
        <th class="subt_col subt_col_fr">סרטון</th>
        <th class="subt_col subt_col_fr">פעולה</th>
    </tr>

    <?php


    while ($row = mysqli_fetch_array($query)) {
        ?>

        <tr class="subt_row">
            <td class="subt_col col_sub_id" id="col_sub_id_<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
            <td class="subt_col col_sub_name" id="col_sub_name_<?php echo $row['id']; ?>"><?php echo $row['sub_name']; ?></td>
            <td class="subt_col col_quiz_name" id="col_quiz_name_<?php echo $row['id']; ?>"><span
                    class="quiz_id_<?php echo $row['sub_quiz_id']; ?>"></span></td>
            <td class="subt_col col_bin_count" id="col_bin_count_<?php echo $row['id']; ?>"><?php echo $row['sub_bin_num']; ?>
            </td>
            <td class="subt_col col_text" id="col_text_<?php echo $row['id']; ?>"><?php echo $row['sub_text']; ?></td>
            <td class="subt_col col_img" id="col_img_<?php echo $row['id']; ?>"><img src="<?php echo $row['sub_img']; ?>"
                    class="sutbl_img" /></td>
            <td class="subt_col col_vid" id="col_vid_<?php echo $row['id']; ?>"><?php echo $row['sub_video']; ?></td>
            <td class="subt_col col_actions">
                <div class="edit_button_fill edit_button_fill_<?php echo $row['id']; ?>">
                    <span class="sub_edit_disabled sub_edit_button_<?php echo $row['id']; ?>"
                        id="<?php echo $row['id']; ?>">עריכה</span>
                </div>
                &nbsp;-&nbsp;
                <span class="sub_delete sub_delete_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">מחיקה</span>
                &nbsp;-&nbsp;
                <span class="sub_add_que sub_add_que_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">הוספת
                    שאלות</span>
            </td>
        </tr>

        <?php
    }
}

if ($action == 'get_quiz_name_by_id') {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM quizzes WHERE id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['quiz_name'];
    }
}

if ($action == 'get_quiz_course') {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM quizzes WHERE id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['quiz_course_id'];
    }
}

if ($action == "get_num_of_quizzes") {
    $sql = "SELECT * FROM quizzes ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    }
}

if ($action == "get_num_of_courses") {
    $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    }
}

if ($action == "get_num_of_questions") {
    $sql = "SELECT * FROM questions ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    }
}

if ($action == "get_num_of_subjects") {
    $sql = "SELECT * FROM subjects";
    $query = mysqli_query($conn, $sql);
    echo mysqli_num_rows($query);
}

if ($action == "save_edit_sub_data") {
    $sub_id = $_GET['sub_id'];
    $sub_name = $_GET['sub_name'];
    $quiz_id = $_GET['quiz_id'];
    $bin_count = $_GET['bin_count'];
    $sub_txt = $_GET['sub_txt'];
    $sub_img = $_GET['sub_img'];
    $sub_video = $_GET['sub_video'];

    $sql = "UPDATE subjects SET `sub_name`='$sub_name',`sub_quiz_id`='$quiz_id',`sub_bin_num`='$bin_count', `sub_text`='$sub_txt', `sub_img`='$sub_img', `sub_video`='$sub_video' WHERE id = '$sub_id'";
    mysqli_query($conn, $sql) or die("0");
    echo "1";
}

if ($action == "load_edit_sub_data1") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_name'];
    }
}

if ($action == "load_edit_sub_data2") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_quiz_id'];
    }
}

if ($action == "load_edit_sub_data3") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_bin_num'];
    }
}

if ($action == "edit_sub_load_sub_text") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_name'];
    }
}

if ($action == "edit_sub_load_quiz_text") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_quiz_id'];
    }
}

if ($action == "edit_sub_load_bin_text") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo $row['sub_bin_num'];
    }
}

if ($action == "update_quiz_list") {
    $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="' . $row['id'] . '" id="' . $row['id'] . '">' . $row['quiz_name'] . '</option>';
        }
    }
}

if ($action == "get_que_text_by_id") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_text'];
        }
    }
}

if ($action == "get_sub_text_by_id") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_name'];
        }
    }
}

if ($action == "update_que_data") {
    $que_id = $_GET['que_id'];
    $que_text = $_GET['que_text'];
    $sql = "UPDATE questions SET `que_text`='$que_text' WHERE id = '$que_id'";
    mysqli_query($conn, $sql) or die('0');
    echo '1';
}

if ($action == "load_quizzes_table") {
    ?>

    <tr class="quizt_first_row quizt_row">
        <th class="quizt_col quizt_col_fr">ID</th>
        <th class="quizt_col quizt_col_fr">שם השאלון</th>
        <th class="quizt_col quizt_col_fr">קורס</th>
        <th class="quizt_col quizt_col_fr">תמונה</th>
        <th class="quizt_col quizt_col_fr">פעולה</th>
    </tr>

    <?php
    $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            ?>

            <tr class="quizt_row">
                <td class="quizt_col">
                    <?php echo $id; ?>
                </td>
                <td class="quizt_col quizt_col_quiz_name_<?php echo $id; ?>">
                    <?php echo $row['quiz_name']; ?>
                </td>
                <td class="quizt_col quizt_col_course_name_<?php echo $id; ?>" id="<?php echo $row['quiz_course_id']; ?>">
                    <span class="qt_crs_col_<?php echo $id; ?> qt_course_id_<?php echo $row['quiz_course_id']; ?>">
                        <?php echo $row['quiz_course_id']; ?>
                    </span>
                </td>
                <td class="quizt_col quizt_col_quiz_img quizt_col_quiz_img_<?php echo $id; ?>">
                    <?php
                    $quiz_img = $row['quiz_pic'];
                    if (!file_exists('../../uploads/quiz_img/' . $quiz_img)) {
                        $quiz_img = '';
                    }
                    $print_quiz_img = (empty($quiz_img)) ? "uploads/quiz_img/default.png" : "uploads/quiz_img/" . $quiz_img;
                    ?>
                    <img src="<?php echo $print_quiz_img; ?>" class="quiz_table_quiz_img">
                </td>
                <td class="quizt_col">
                    <div class="qt_edit_btn_fill qt_edit_btn_fill_<?php echo $id; ?>">
                        <span class="quizt_edit quizt_edit_<?php echo $id; ?>" id="<?php echo $id; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="quizt_delete quizt_delete_<?php echo $id; ?>" id="<?php echo $id; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="quizt_add_subs quizt_add_subs_<?php echo $id; ?>" id="<?php echo $id; ?>">הוספת נושאים</span>
                </td>
            </tr>

            <?php
        }
    }
}

if ($action == "qt_delete_quiz") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "UPDATE `quizzes` SET `quiz_status` = 'deleted' WHERE `id` = '$quiz_id'";
    mysqli_query($conn, $sql) or die("error");
    echo 1;
}

if ($action == "qet_delete_que") {
    $que_id = $_GET['que_id'];
    $sql = "UPDATE `questions` SET `que_status` = 'deleted' WHERE `id` = '$que_id'";
    mysqli_query($conn, $sql) or die("error");
    echo 1;
}

if ($action == "save_qt_data") {
    $quiz_id = $_GET['quiz_id'];
    $quiz_name_field = $_GET['quiz_name_field'];
    $quiz_course = $_GET['quiz_course'];
    $sql = "UPDATE `quizzes` SET `quiz_name` = '$quiz_name_field', `quiz_course_id` = '$quiz_course' WHERE `id` = '$quiz_id'";
    mysqli_query($conn, $sql) or die("error");
    echo 1;
}

if ($action == "st_delete_sub") {
    $sub_id = $_GET['sub_id'];
    $sql = "UPDATE `subjects` SET `sub_status` = 'deleted' WHERE `id` = '$sub_id'";
    mysqli_query($conn, $sql) or die("error");
    echo 1;
}

if ($action == "load_ques_table") {
    ?>
    <tr class="qet_row qet_first_row">
        <th class="qet_col qet_fr_col">ID</th>
        <th class="qet_col qet_fr_col">שאלה</th>
        <th class="qet_col qet_fr_col">נושא</th>
        <th class="qet_col qet_fr_col">בין</th>
        <th class="qet_col qet_fr_col">סרטון</th>
        <th class="qet_col qet_fr_col">תמונה</th>
        <th class="qet_col qet_fr_col">פעולה</th>
    </tr>
    <?php
    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            ?>
            <tr class="qet_row">
                <td class="qet_col"><?php echo $row['id']; ?></td>
                <td class="qet_col col_que_text_<?php echo $row['id']; ?>"><?php echo $row['que_text']; ?></td>
                <td class="qet_col qet_col_sub_<?php echo $row['id']; ?>"><?php echo $row['que_subject']; ?></td>
                <td class="qet_col qet_col_bin_<?php echo $row['id']; ?>"><?php echo $row['que_bin']; ?></td>
                <td class="qet_col qet_col_video qet_col_video_<?php echo $row['id']; ?>"><?php echo $row['que_video']; ?></td>
                <td class="qet_col qet_col_img qet_col_img_<?php echo $row['id']; ?>"><img src="<?php echo $row['que_img']; ?>" />
                </td>
                <td class="qet_col">
                    <div class="que_edt_btn_fill que_edt_btn_fill_<?php echo $row['id']; ?>">
                        <span id="<?php echo $row['id']; ?>"
                            class="qet_action_span qet_edit_btn qet_edit_btn_<?php echo $row['id']; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_delete_btn qet_delete_btn_<?php echo $row['id']; ?>"
                        id="<?php echo $row['id']; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_add_ans_btn qet_add_ans_btn_<?php echo $row['id']; ?>"
                        id="<?php echo $row['id']; ?>">הוספת תשובות</span>
                </td>
            </tr>
            <?php
        }
    }
}

if ($action == "get_bin_by_que") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_bin'];
        }
    }
}

if ($action == 'save_qet_edit_data') {
    $que_id = $_GET['que_id'];
    $que_text_type = $_GET['typed_que_name'];
    $que_sub = $_GET['typed_sub'];
    $que_bin = $_GET['typed_bin'];
    $que_vid = $_GET['typed_vid'];
    $que_img = $_GET['typed_img'];
    $sql = "UPDATE `questions` SET `que_text` = '{$que_text_type}', 
                                   `que_bin` = '{$que_bin}', 
                                   `que_subject` = '{$que_sub}', 
                                   `que_video` = '{$que_vid}', 
                                   `que_img` = '{$que_img}' 
            WHERE `id` = '{$que_id}'";
    mysqli_query($conn, $sql) or die('error');
    echo 1;
}

if ($action == "load_que_options_all") {
    $sql = "SELECT * FROM questions WHERE que_status = 'publish'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo "<option value='{$row["id"]}' id='{$row["id"]}'>{$row['que_text']}</option>";
        }
    }
}

if ($action == "que_get_video_row") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_video'];
        }
    }
}

if ($action == "que_get_image_row") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_img'];
        }
    }
}

if ($action == "load_esub_txt") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_text'];
        }
    }
}

if ($action == "load_esub_img") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_img'];
        }
    }
}

if ($action == "load_esub_vid") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_video'];
        }
    }
}

if ($action == "recycle_quiz") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "UPDATE quizzes SET `quiz_status` = 'publish' WHERE id = '$quiz_id'";
    mysqli_query($conn, $sql) or die("0");
    echo "1";
}

if ($action == "recycle_subjects") {
    $sub_id = $_GET['sub_id'];
    $sql = "UPDATE subjects SET `sub_status` = 'publish' WHERE id = '$sub_id'";
    mysqli_query($conn, $sql) or die("error");
    echo "1";
}

if ($action == "recycle_que") {
    $que_id = $_GET['que_id'];
    $sql = "UPDATE questions SET `que_status` = 'publish' WHERE id = '$que_id'";
    mysqli_query($conn, $sql) or die("error");
    echo "1";
}

if ($action == "load_quiz_rb_table") {
    $sql = "SELECT * FROM quizzes WHERE quiz_status = 'deleted'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        ?>
        <!-- Prints the first row -->
        <tr class="quiz_rb_tfr">
            <th class="quiz_rb_col quiz_rb_fr_col">ID</th>
            <th class="quiz_rb_col quiz_rb_fr_col">שם השאלון</th>
            <th class="quiz_rb_col quiz_rb_fr_col">פעולה</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr class="quiz_rb_tr">
                <td class="quiz_rb_col"><?php echo $row['id']; ?></td>
                <td class="quiz_rb_col"><?php echo $row['quiz_name']; ?></td>
                <td class="quiz_rb_col">
                    <span class="quiz_rb_recycle quiz_rb_recycle_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
                        שיחזור
                    </span>
                </td>
            </tr>

            <?php
        }
    } else {
        echo '<span style="color:#f00;font-size:24px;padding:5px 10px;">אין שאלונים שנמחקו</span>';
    }
}

if ($action == "search_sub") {
    if (!isset($_GET['value']) || empty($_GET['value'])) {
        return;
    }

    $value = $_GET['value'];
    $value = clear_value($conn, $value);

    $sql = "SELECT * FROM subjects WHERE sub_name LIKE '%{$value}%' AND `sub_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        ?>

        <tr class="subt_first_row subt_row">
            <th class="subt_col subt_col_fr">ID</th>
            <th class="subt_col subt_col_fr">נושא</th>
            <th class="subt_col subt_col_fr">שאלון</th>
            <th class="subt_col subt_col_fr">מספר בינים</th>
            <th class="subt_col subt_col_fr">הסבר מילולי</th>
            <th class="subt_col subt_col_fr">תמונה</th>
            <th class="subt_col subt_col_fr">סרטון</th>
            <th class="subt_col subt_col_fr">פעולה</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr class="subt_row">
                <td class="subt_col col_sub_id" id="col_sub_id_<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
                <td class="subt_col col_sub_name" id="col_sub_name_<?php echo $row['id']; ?>"><?php echo $row['sub_name']; ?></td>
                <td class="subt_col col_quiz_name" id="col_quiz_name_<?php echo $row['id']; ?>"><span
                        class="quiz_id_<?php echo $row['sub_quiz_id']; ?>"></span></td>
                <td class="subt_col col_bin_count" id="col_bin_count_<?php echo $row['id']; ?>"><?php echo $row['sub_bin_num']; ?>
                </td>
                <td class="subt_col col_text" id="col_text_<?php echo $row['id']; ?>"><?php echo $row['sub_text']; ?></td>
                <td class="subt_col col_img" id="col_img_<?php echo $row['id']; ?>"><img src="<?php echo $row['sub_img']; ?>"
                        class="sutbl_img" /></td>
                <td class="subt_col col_vid" id="col_vid_<?php echo $row['id']; ?>"><?php echo $row['sub_video']; ?></td>
                <td class="subt_col col_actions">
                    <div class="edit_button_fill edit_button_fill_<?php echo $row['id']; ?>">
                        <span class="sub_edit_disabled sub_edit_button_<?php echo $row['id']; ?>"
                            id="<?php echo $row['id']; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="sub_delete sub_delete_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="sub_add_que sub_add_que_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">הוספת
                        שאלות</span>
                </td>
            </tr>

            <?php
        }
    }
}

if ($action == "search_que") {
    if (!isset($_GET['value']) || empty($_GET['value'])) {
        return;
    }

    $value = $_GET['value'];
    $value = clear_value($conn, $value);

    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish' AND que_text LIKE '%$value%' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        ?>
        <tr class="qet_row qet_first_row">
            <th class="qet_col qet_fr_col">ID</th>
            <th class="qet_col qet_fr_col">שאלה</th>
            <th class="qet_col qet_fr_col">נושא</th>
            <th class="qet_col qet_fr_col">בין</th>
            <th class="qet_col qet_fr_col">סרטון</th>
            <th class="qet_col qet_fr_col">תמונה</th>
            <th class="qet_col qet_fr_col">פעולה</th>
        </tr>
        <?php

        while ($row = mysqli_fetch_array($query)) {
            ?>
            <tr class="qet_row">
                <td class="qet_col"><?php echo $row['id']; ?></td>
                <td class="qet_col col_que_text_<?php echo $row['id']; ?>"><?php echo $row['que_text']; ?></td>
                <td class="qet_col qet_col_sub_<?php echo $row['id']; ?>"><?php echo $row['que_subject']; ?></td>
                <td class="qet_col qet_col_bin_<?php echo $row['id']; ?>"><?php echo $row['que_bin']; ?></td>
                <td class="qet_col qet_col_video qet_col_video_<?php echo $row['id']; ?>"><?php echo $row['que_video']; ?></td>
                <td class="qet_col qet_col_img qet_col_img_<?php echo $row['id']; ?>"><img src="<?php echo $row['que_img']; ?>" />
                </td>
                <td class="qet_col">
                    <div class="que_edt_btn_fill que_edt_btn_fill_<?php echo $row['id']; ?>">
                        <span id="<?php echo $row['id']; ?>"
                            class="qet_action_span qet_edit_btn qet_edit_btn_<?php echo $row['id']; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_delete_btn qet_delete_btn_<?php echo $row['id']; ?>"
                        id="<?php echo $row['id']; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_add_ans_btn qet_add_ans_btn_<?php echo $row['id']; ?>"
                        id="<?php echo $row['id']; ?>">הוספת תשובות</span>
                </td>
            </tr>
            <?php
        }
    }
}

if ($action == "load_sub_txt") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_text'];
        }
    }
}

if ($action == "load_que_tbl_pg") {
    $output = '';
    $page = $_GET['page'];
    $limit = 10;
    $start_from = ($page - 1) * $limit;
    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish' ORDER BY id DESC LIMIT $start_from, $limit";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $output .= '
        <tr class="qet_row qet_first_row">
            <th class="qet_col qet_fr_col">ID</th>
            <th class="qet_col qet_fr_col">שאלה</th>
            <th class="qet_col qet_fr_col">נושא</th>
            <th class="qet_col qet_fr_col">בין</th>
            <th class="qet_col qet_fr_col">סרטון</th>
            <th class="qet_col qet_fr_col">תמונה</th>
            <th class="qet_col qet_fr_col">פעולה</th>
        </tr>';

        while ($row = mysqli_fetch_array($query)) {
            $output .= '
            <tr class="qet_row">
                <td class="qet_col">' . $row['id'] . '</td>
                <td class="qet_col col_que_text_' . $row['id'] . '">' . $row['que_text'] . '</td>
                <td class="qet_col qet_col_sub_' . $row['id'] . '">' . $row['que_subject'] . '</td>
                <td class="qet_col qet_col_bin_' . $row['id'] . '">' . $row['que_bin'] . '</td>
                <td class="qet_col qet_col_video qet_col_video_' . $row['id'] . '">' . $row['que_video'] . '</td>
                <td class="qet_col qet_col_img qet_col_img_' . $row['id'] . '"><img src="' . $row['que_img'] . '" /></td>
                <td class="qet_col">
                    <div class="que_edt_btn_fill que_edt_btn_fill_' . $row['id'] . '">
                        <span id="' . $row['id'] . '" class="qet_action_span qet_edit_btn qet_edit_btn_' . $row['id'] . '">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_delete_btn qet_delete_btn_' . $row['id'] . '" id="' . $row['id'] . '">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="qet_action_span qet_add_ans_btn qet_add_ans_btn_' . $row['id'] . '" id="' . $row['id'] . '">הוספת תשובות</span>
                </td>
            </tr>
            ';
        }
    } else {
        $output .= 'אין שאלות עדיין';
    }

    echo $output;
}

if ($action == "load_ques_pages") {
    $output = "";
    $limit = 10;
    $page = $_GET['page'];
    $sql = "SELECT * FROM questions WHERE `que_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    $total_ques = mysqli_num_rows($query);
    $total_pages = ceil($total_ques / $limit);

    if ($page > 1) {
        $previous = $page - 1;
        $output .= '<div class="previous_page" id="' . $previous . '">&gt;</div>';
    }

    $output .= '<div class="page_nums_fill">';


    // Prints all the pages
    /*
    for($i=1; $i<=$total_pages; $i++)
    {
        $active_class = "";
        if($i == $page)
        {
            $active_class = "active";
        }
        $output .= '<div class="pg pg_'.$i.' '.$active_class.'" id="'.$i.'">'.$i.'</div>';
    }
    */


    $pre1 = $page - 2;
    $pre2 = $page - 1;
    $nex1 = $page + 1;
    $nex2 = $page + 2;

    if ($page > 2) {
        $output .= '<div class="pg pg_1" id="1">1</div>';
        $output .= '&nbsp;&nbsp;&nbsp;';
    }

    if ($page > 2 && $page != 3) {
        $output .= '<div class="pg pg_' . $pre1 . '" id="' . $pre1 . '">' . $pre1 . '</div>';
    }

    if ($page > 1) {
        $output .= '<div class="pg pg_' . $pre2 . '" id="' . $pre2 . '">' . $pre2 . '</div>';
    }

    $output .= '&nbsp;&nbsp;&nbsp;';
    $output .= '<div class="pg pg_' . $page . ' active" id="' . $page . '">' . $page . '</div>';
    $output .= '&nbsp;&nbsp;&nbsp;';

    if ($page <= ($total_pages - 2)) {
        $output .= '<div class="pg pg_' . $nex1 . '" id="' . $nex1 . '">' . $nex1 . '</div>';
    }

    if ($page < ($total_pages - 1) && $page != ($total_pages - 2)) {
        $output .= '<div class="pg pg_' . $nex2 . '" id="' . $nex2 . '">' . $nex2 . '</div>';
    }

    if ($page < $total_pages) {
        $output .= '&nbsp;&nbsp;&nbsp;';
        $output .= '<div class="pg pg_' . $total_pages . '" id="' . $total_pages . '">' . $total_pages . '</div>';
    }



    $output .= '</div>';

    if ($page < $total_pages) {
        $page++;
        $output .= '<div class="next_page" id="' . ($page) . '">&lt;</div>';
    }


    echo $output;
}

if ($action == "search_quiz") {
    if (!isset($_GET['value']) || empty($_GET['value'])) {
        return;
    }

    $value = $_GET['value'];
    $value = clear_value($conn, $value);

    $sql = "SELECT * FROM quizzes WHERE quiz_name LIKE '%{$value}%' AND `quiz_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        ?>
        <tr class="quizt_first_row quizt_row">
            <th class="quizt_col quizt_col_fr">ID</th>
            <th class="quizt_col quizt_col_fr">שם השאלון</th>
            <?php /*<th class="quizt_col quizt_col_fr">קורס</th> */ ?>
            <th class="quizt_col quizt_col_fr">פעולה</th>
        </tr>
        <?php

        while ($row = mysqli_fetch_array($query)) {
            ?>

            <tr class="quizt_row">
                <td class="quizt_col">
                    <?php echo $row['id']; ?>
                </td>
                <td class="quizt_col quizt_col_quiz_name_<?php echo $row['id']; ?>">
                    <?php echo $row['quiz_name']; ?>
                </td>
                <?php /*
                              <td class="quizt_col quizt_col_course_name_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
                                  <?php echo $row['quiz_course_id']; ?>
                              </td>
                              */ ?>
                <td class="quizt_col">
                    <div class="qt_edit_btn_fill qt_edit_btn_fill_<?php echo $row['id']; ?>">
                        <span class="quizt_edit quizt_edit_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="quizt_delete quizt_delete_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="quizt_add_subs quizt_add_subs_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">הוספת
                        נושאים</span>
                </td>
            </tr>

            <?php
        }
    }
}

if ($action == "get_qt_edit_crs_list") {
    $sql = "SELECT * FROM courses WHERE course_status = 'publish'";
    $query = mysqli_query($conn, $sql);
    echo '<select id="edit_quiz_select_course" class="basic_field pointer">';
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $level_name = get_level_name($row['course_level']);
            echo '<option value="' . $row['id'] . '">' . $row['course_name'] . ' - ' . $level_name . '</option>';
        }
    } else {
        echo '<option value="0">אין קורסים עדיין</option>';
    }
    echo '</select>';
}

if ($action == "get_num_of_classes") {
    $sql = "SELECT * FROM classes ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    }
}

if ($action == "save_qdit_quiz_data") {
    $quiz_id = $_GET['quiz_id'];
    $quiz_name = $_GET['quiz_name'];
    $quiz_course = $_GET['quiz_course'];
    $sql = "UPDATE quizzes SET `quiz_name` = '$quiz_name', `quiz_course_id` = '$quiz_course' WHERE id = '$quiz_id'";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if ($action == "del_quiz") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "UPDATE quizzes SET `quiz_status` = 'deleted' WHERE id = '$quiz_id'";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if ($action == "del_class") {
    $class_id = $_GET['class_id'];
    $sql = "UPDATE classes SET `class_status` = 'deleted' WHERE id = '$class_id'";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if ($action == "quiz_is_check") {
    $class_id = $_GET['class_id'];
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM homework WHERE class_id = '$class_id' AND quiz_id = '$quiz_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) === 0) {
        $sql2 = "INSERT INTO homework (`class_id`, `quiz_id`) VALUES ('$class_id', '$quiz_id')";
        mysqli_query($conn, $sql2) or die("sql error");
        echo 999;
    }
}

if ($action == "quiz_is_not_check") {
    $class_id = $_GET['class_id'];
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM homework WHERE class_id = '$class_id' AND quiz_id = '$quiz_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $sql3 = "DELETE FROM homework WHERE quiz_id = '$quiz_id' AND class_id = '$class_id'";
        mysqli_query($conn, $sql3) or die("sql error 2");
        echo 777;
    } else {
        echo 888;
    }
}

?>