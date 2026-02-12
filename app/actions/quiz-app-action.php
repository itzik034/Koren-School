<?php

include("../config/connection.php");
include("../helpers/function.php");

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    die("syntax error");
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];

if ($action == "get_que_text") {
    if (isset($_GET['que_id']) && !empty($_GET['que_id'])) {
        $que_id = $_GET['que_id'];
    } else {
        return;
    }
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_text'];
        }
    }
}

if ($action == "get_sub_text") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_name'];
        }
    }
}

if ($action == "get_correct_ans") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM answears WHERE ans_question = '$que_id' AND ans_correct = '1' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    }
}

if ($action == "get_ans") {
    $que_id = $_GET['que_id'];
    $fields_data = array();
    $sql = "SELECT * FROM answears WHERE ans_question = '$que_id' AND ans_correct = 0 LIMIT 6";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        array_push($fields_data, $row['id']);
    }
    $json_data = json_encode($fields_data);
    echo $json_data;
}

if ($action == "get_num_of_subs_by_quiz_id") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM subjects WHERE sub_quiz_id = {$quiz_id}";
    $query = mysqli_query($conn, $sql);
    echo mysqli_num_rows($query);
}

if ($action == "qa_get_subs") {
    $quiz_id = $_GET['quiz_id'];
    $fields_data = array();
    $sql = "SELECT * FROM subjects WHERE sub_quiz_id = {$quiz_id}";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        array_push($fields_data, $row['id']);
    }
    $json_data = json_encode($fields_data);
    echo $json_data;
}

if ($action == "get_ques_by_sub_id") {
    if (!isset($_GET['sub_id']) || empty($_GET['sub_id'])) {
        die();
    } else {

        $sub_id = $_GET['sub_id'];
        $fields_data = array();
        $sql = "SELECT * FROM questions WHERE que_subject = {$sub_id}";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            array_push($fields_data, $row['id']);
        }
        $json_data = json_encode($fields_data);
        echo $json_data;

    }
}

if ($action == "get_ans_text") {
    $ans_id = $_GET['ans_id'];
    $sql = "SELECT * FROM answears WHERE id = '$ans_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['ans_text'];
        }
    }
}

if ($action == "qa_check_ans") {
    $que_id = $_GET['que_id'];
    $ans_id = $_GET['ans_id'];
    $sql = "SELECT * FROM answears WHERE ans_question = {$que_id} AND id = {$ans_id} AND ans_correct = '1' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        echo 1;
    } else {
        echo 0;
    }
}

if ($action == "get_que_video") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_video'];
        }
    }
}

if ($action == "get_num_of_bins") {
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['sub_bin_num'];
            die();
        }
    }
}

if ($action == "save_user_ans_info") {
    $que_id = $_GET['que_id'];
    $ans_id = $_GET['ans_id'];
    $sql1 = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql1);
    $num_of_ans = '';
    $new_num = '';
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $num_of_ans = $row['que_students_ans'];
        }
        $new_num = $num_of_ans + 1;
        $sql2 = "UPDATE questions SET que_students_ans = '$new_num' WHERE id = '$que_id'";
        mysqli_query($conn, $sql2);
        echo 1;
    }
}

if ($action == "save_user_ans_corr_info") {
    $que_id = $_GET['que_id'];
    $ans_id = $_GET['ans_id'];
    $sql1 = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql1);
    $num_of_ans = '';
    $new_num = '';
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $num_of_ans = $row['que_stud_ans_correct'];
        }
        $new_num = $num_of_ans + 1;
        $sql2 = "UPDATE questions SET que_stud_ans_correct = '$new_num' WHERE id = '$que_id'";
        mysqli_query($conn, $sql2);
        echo 1;
    }
}

if ($action == "update_que_diff") {
    $que_id = $_GET['que_id'];
    $sql1 = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($query1) > 0) {
        while ($row = mysqli_fetch_array($query1)) {
            $stud_ans = (int) $row['que_students_ans'];
            $stud_ans_correct = (int) $row['que_stud_ans_correct'];
            $que_diff = $stud_ans_correct / $stud_ans;
            $sql2 = "UPDATE questions SET que_diff = '$que_diff' WHERE id = '$que_id'";
            mysqli_query($conn, $sql2);
            echo 1;
        }
    }
}

if ($action == "check_session_avlbl") {
    $session_id = $_GET['session_id'];
    $sql = "SELECT * FROM quiz_run WHERE run_session_id = '$session_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        echo '0';
    } else {
        echo '1';
    }
}

if ($action == "save_run_data") {
    $que_id = $_GET['que_id'];
    $quiz_id = $_GET['quiz_id'];
    $correct = (int) $_GET['correct'];
    $mistakes = (int) $_GET['mistakes'];
    $session_id = $_GET['session_id'];
    $user_id = $_SESSION['user_id'];
    $ans = $correct + $mistakes;
    $sql = "INSERT INTO quiz_run (`id`, `user_id`, `quiz_id`, `run_correct`, `run_ans`, `run_session_id`) 
                          VALUES (NULL,'$user_id','$quiz_id','$correct','$ans', '$session_id')";
    mysqli_query($conn, $sql);
    echo 1;
}

if ($action == "save_user_run_data") {
    $que_id = $_GET['que_id'];
    $sub_id = $_GET['sub_id'];
    $quiz_id = $_GET['quiz_id'];
    $array_corr = $_GET['array_corr'];
    $progressbar = $_GET['progressbar'];
    $correct = (int) $_GET['correct'];
    $mistakes = (int) $_GET['mistakes'];
    $user_id = $_SESSION['user_id'];
    $ans = $correct + $mistakes;
    $sql1 = "SELECT * FROM user_quiz_run WHERE quiz_id = '$quiz_id' AND user_id = '$user_id'";
    $query1 = mysqli_query($conn, $sql1);
    if ($progressbar > 100) {
        $progressbar = 100;
    }
    if (mysqli_num_rows($query1) > 0) {
        $sql = "UPDATE user_quiz_run SET 
        `last_run_time`=CURRENT_TIMESTAMP,
        `run_sub_id`='$sub_id',
        `run_que_id`='$que_id',
        `run_progress_bar`='$progressbar',
        `run_corr_array`='$array_corr', 
        `run_status`='active'
         WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO `user_quiz_run`(`user_id`, `quiz_id`, `first_run_time`, `last_run_time`, `run_sub_id`, `run_que_id`, `run_progress_bar`, `run_corr_array`, `run_status`) 
                              VALUES ('$user_id','$quiz_id',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$sub_id','$que_id','$progressbar', '$array_corr', 'active')";
        mysqli_query($conn, $sql);
    }

    echo 1;
}

if ($action == "end_quiz") {
    $quiz_id = $_GET['quiz_id'];
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE user_quiz_run SET `run_status` = 'end' WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
    mysqli_query($conn, $sql) or die('sql error');

    echo 1;
}

if ($action == "update_run_data") {
    $que_id = $_GET['que_id'];
    $quiz_id = $_GET['quiz_id'];
    $correct = (int) $_GET['correct'];
    $wrong = (int) $_GET['wrong'];
    $mistakes = $_GET['mistakes'];
    $session_id = $_GET['session_id'];
    $user_id = $_SESSION['user_id'];
    $ans = $correct + $wrong;
    $sql = "UPDATE quiz_run SET `run_correct` = '$correct', `run_ans` = '$ans' WHERE run_session_id = '$session_id'";
    mysqli_query($conn, $sql);
    echo 1;
}

if ($action == "load_que_from_bin") {
    $sub_id = (int) $_GET['sub_id'];
    $bin = (int) $_GET['bin'];
    $sql = "SELECT * FROM questions WHERE que_subject = '$sub_id' AND que_bin = '$bin' ORDER BY RAND() LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    } else {
        echo '0';
    }
}

if ($action == "get_next_bin") {
    $sub_id = $_GET['sub_id'];
    $bin = $_GET['bin'];
    $sql2 = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    if (mysqli_num_rows($query2) > 0) {
        while ($row = mysqli_fetch_array($query2)) {
            $nob = (int) $row['sub_bin_num'];
            if ($bin < $nob) {
                $bin += 1;
            }
            echo $bin;
        }
    }
}

if ($action == "get_last_sub") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM user_quiz_run WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            echo $row['run_sub_id'];
        }
    }
}

if ($action == "get_last_que") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM user_quiz_run WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            echo $row['run_que_id'];
        }
    }
}

if ($action == "get_last_progbar") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM user_quiz_run WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            echo $row['run_progress_bar'];
        }
    }
}

if ($action == "get_last_corr") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM user_quiz_run WHERE user_id = '$user_id' AND quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            echo $row['run_corr_array'];
        }
    }
}

if ($action == "save_quiz_run") {
    $quiz_id = $_GET['quiz_id'];
    $sql1 = "SELECT * FROM run_quiz WHERE quiz_id = '$quiz_id' AND user_id = '$user_id'";
    $query1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($query1) > 0) {
        while ($row = $query1->fetch_array()) {
            if ($row['run_status'] == 'end') {
                $sql5 = "SELECT * FROM run_quiz WHERE quiz_id = '$quiz_id' AND user_id = '$user_id' AND run_status = 'run'";
                $query5 = mysqli_query($conn, $sql5);
                if (mysqli_num_rows($query5) == 0) {
                    $sql4 = "INSERT INTO run_quiz (`user_id`, `quiz_id`, `run_status`) VALUES ('$user_id', '$quiz_id', 'run')";
                    mysqli_query($conn, $sql4) or die('sql error');
                    echo 2;
                }
            }
        }
    } else {
        $sql3 = "INSERT INTO run_quiz (`user_id`, `quiz_id`, `run_status`) VALUES ('$user_id', '$quiz_id', 'run')";
        mysqli_query($conn, $sql3) or die('sql error');
        echo 1;
    }
}

if ($action == "update_quiz_run_end") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "UPDATE run_quiz SET `run_status` = 'end' WHERE `quiz_id` = '$quiz_id' AND `user_id` = '$user_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
}

if ($action == "save_que_run") {
    $que_id = $_GET['que_id'];
    $is_correct = $_GET['is_correct'];
    $quiz_run_id = $_GET['quiz_run_id'];
    $sub_id = $_GET['cur_sub_id'];
    $sql1 = "SELECT * FROM run_question WHERE run_quiz_id = '$quiz_run_id' AND que_id = '$que_id'";
    $query1 = mysqli_query($conn, $sql1);
    // if(mysqli_num_rows($query1) > 0)
    // {
    //     $sql2 = "UPDATE run_question SET `is_correct` = '$is_correct' WHERE run_quiz_id = '$quiz_run_id' AND que_id = '$que_id'";
    //     mysqli_query($conn, $sql2) or die('sql error');
    //     echo 1;
    // }
    // else
    // {
    $sql3 = "INSERT INTO run_question (`run_quiz_id`, `que_id`, `is_correct`, `sub_id`) VALUES ('$quiz_run_id', '$que_id', '$is_correct', '$sub_id')";
    mysqli_query($conn, $sql3) or die('sql error');
    echo 2;
    // }
}

if ($action == "get_run_quiz_id") {
    $run_id = 0;
    $quiz_id = $_GET['quiz_id'];
    $sql1 = "SELECT * FROM run_quiz WHERE quiz_id = '$quiz_id' AND user_id = '$user_id' AND run_status = 'run'";
    $query1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($query1) > 0) {
        while ($row = $query1->fetch_array()) {
            $run_id = $row['id'];
        }
    }
    echo $run_id;
}

if ($action == "get_last_que2") {
    $last_que = '';
    $run_quiz_id = $_GET['run_quiz_id'];
    $sql = "SELECT * FROM run_question WHERE run_quiz_id = '$run_quiz_id' ORDER BY id ASC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            $last_que = $row['que_id'];
        }
    }
    echo $last_que;
}

if ($action == "get_last_que_in_sub") {
    $last_que = '';
    $sub_id = $_GET['sub_id'];
    $run_quiz_id = $_GET['run_quiz_id'];
    $sql = "SELECT * FROM run_question WHERE run_quiz_id = '$run_quiz_id' AND sub_id = '$sub_id' ORDER BY id ASC";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            $last_que = $row['que_id'];
        }
    }
    echo $last_que;
}

if ($action == "get_subs_list_by_quiz_id") {
    $quiz_id = $_GET['quiz_id'];
    $sql = "SELECT * FROM subjects WHERE sub_quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $data = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($data, $row['id']);
        }
        $json_data = json_encode($data);
        echo $json_data;
    }
}

if ($action == "get_last_bin_in_sub") {
    $sub_id = $_GET['sub_id'];
    $quiz_id = $_GET['quiz_id'];
    $last_que_loaded_in_sub = 0;
    $sql = "SELECT * FROM questions WHERE que_subject = '$sub_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = $query->fetch_array()) {
            $cur_que = $row['id'];
            $sql3 = "SELECT * FROM run_quiz WHERE quiz_id = '$quiz_id' AND user_id = '$user_id' ORDER BY id DESC LIMIT 1";
            $query3 = mysqli_query($conn, $sql3);
            if (mysqli_num_rows($query3) > 0) {
                while ($row3 = $query3->fetch_array()) {
                    $cur_run_id = $row3['id'];
                    $sql2 = "SELECT * FROM run_question WHERE que_id = '$cur_que' AND run_quiz_id = '$cur_run_id'";
                    $query2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($query2) > 0) {
                        while ($row2 = $query2->fetch_array()) {

                        }
                    }
                }
            }
        }
    }

}

if ($action == "get_last_run_quiz_id") {
    $current_quiz = $_GET['current_quiz'];
    $sql = "SELECT * FROM run_quiz WHERE quiz_id = '$current_quiz' AND run_status = 'run' AND user_id = '$user_id'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['id'];
        }
    } else {
        echo '0';
    }
}

if ($action == "get_last_ansed_que_in_sub") {
    $run_id = $_GET['run_id'];
    $sub_id = $_GET['sub_id'];
    $sql = "SELECT * FROM run_question WHERE run_quiz_id = '$run_id' AND sub_id = '$sub_id' ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $data = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($data, $row['que_id']);
            array_push($data, $row['is_correct']);
        }
        $json_data = json_encode($data);
        echo $json_data;
    }
}

if ($action == "get_bin_by_que_id") {
    $que_id = $_GET['que_id'];
    $sql = "SELECT * FROM questions WHERE id = '$que_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['que_bin'];
        }
    }
}

if ($action == "load_saved_mistakes") {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $quiz_id = $_GET['quiz_id'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM quiz_run WHERE quiz_id = '$quiz_id' AND user_id = '$user_id' ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            echo $row['run_mistakes'];
        }
    }
}

if ($action == "update_run_data_mistakes") {
    $mistakes = $_GET['mistakes'];
    $session_id = $_GET['session_id'];
    $sql = "UPDATE quiz_run SET `run_mistakes` = '$mistakes' WHERE run_session_id = '$session_id'";
    mysqli_query($conn, $sql);
    echo 1;
}

?>