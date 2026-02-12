<link rel="stylesheet" href="assets/css/quiz.css">
<script src="assets/js/quiz/quiz.js"></script>

<!-- Quiz manage popup -->
<div class="add_quiz_popup_fill" style="position: fixed;top: -10000px;left: 0;">
    <div class="add_quiz_popup">
        <div class="close_quiz_btn_fill">
            <span id="close_quiz_popup_btn">סגור</span>
        </div>
        <div class="quiz_top_tabs">
            <div class="quiz_tab_1 quiz_tabs quiz_tab_choosed">ניהול שאלונים</div>
            <div class="quiz_tab_2 quiz_tabs">ניהול נושאים</div>
            <?php /*<div class="quiz_tab_3 quiz_tabs">הוספת שאלה</div>*/ ?>
            <div class="quiz_tab_4 quiz_tabs">ניהול שאלות ותשובות</div>
            <div class="quiz_tab_6 quiz_tabs">העלאת נושאים מתוך Excel</div>
            <div class="quiz_tab_5 quiz_tabs">העלאת שאלות מתוך Excel</div>
        </div>
        <div id="quiz_popup_current_tab_content"></div>
    </div>
</div>

<div class="rc_row rc_title">
    שאלונים
</div>
<div class="rc_scroll">
    <div class="rc_plus" id="add_quiz"><i class="fa-solid fa-plus" aria-hidden="true"></i>&nbsp;ניהול שאלונים</div>
        <?php 

        include_once('../../../../config/connection.php');
        include_once('../../../../helpers/function.php');

        // Stop the script here if there is'nt course_id so the user won't get error
        if(!isset($_GET['course_id']) || empty($_GET['course_id'])){die('שגיאה בטעינת השאלונים');}

        if(session_status() === PHP_SESSION_NONE) 
        {
            session_start();
        }

        $course_id = $_GET['course_id'];
        $user_id = $_SESSION['user_id'];

        if($course_id == '-1' || $course_id == '0')
        {
            $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish' ORDER BY id DESC";
            $sql6 = "SELECT * FROM quizzes WHERE `quiz_status` = 'deleted' ORDER BY id DESC";
        }
        else
        {
            $sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish' AND `quiz_course_id` = '$course_id' ORDER BY id DESC";
            $sql6 = "SELECT * FROM quizzes WHERE `quiz_status` = 'deleted' AND `quiz_course_id` = '$course_id' ORDER BY id DESC";
        }
        
        $query = mysqli_query($conn, $sql);
        $query6 = mysqli_query($conn, $sql6);

        if(mysqli_num_rows($query) > 0)
        {
            $q_text = "";
            while($row = mysqli_fetch_array($query))
            {
                $id = $row['id'];

                $prog_bar = 0;
                $prog_bar_text = '';

                $quiz_pic_field = get_quiz_pic($conn, $id);
                $quiz_pic = $quiz_pic_field ? 'uploads/quiz_img/'.$quiz_pic_field : 'uploads/quiz_img/default.png';
                $quiz_pic_html = '<img src="'.$quiz_pic.'">';

                $sql3 = "SELECT * FROM user_quiz_run WHERE user_id = '$user_id' AND quiz_id = '$id'";
                $query3 = mysqli_query($conn, $sql3);
                if(mysqli_num_rows($query3) > 0)
                {
                    while($row3 = $query3 -> fetch_array())
                    {
                        $prog_bar = $row3['run_progress_bar'];
                        $run_status = $row3['run_status'];
                        if($run_status == "end"){ $prog_bar = '100'; }
                        $prog_bar_text = $prog_bar . '%';

                        echo "<script>setTimeout(() => { $('.rpi_".$id."').css('width', '".$prog_bar_text."'); }, 500);</script>";
                    }
                }
                if($prog_bar === 0)
                {
                    $prog_bar_text = '';
                }

                $q_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
                $q_text .= '<div class="rc_row_pic quiz_pic_fill">';
                $q_text .= $quiz_pic_html;
                $q_text .= '</div>';
                $q_text .= '<div class="rc_row_text">';
                $q_text .= '<div class="edit-split">';
                $q_text .= '<div class="edit-click-quiz ds_edit_quiz_' . $row['id'] . '" id="' . $row['id'] . '"';
                $q_text .= ' quiz-id="' . $row['id'] . '">עריכה</div>';
                $q_text .= '<div class="delete-click delete-quiz del_quiz_' . $row['id'] . '" id="' . $row['id'] . '">מחיקה</div>';
                $q_text .= '</div>';
                $q_text .= '<div class="rc_row_text1 quiz_ttl quiz_ttl_' . $row['id'] . '" id="' . $row['id'] . '">';
                $q_text .= $row['quiz_name'];
                $q_text .= '</div>';
                $q_text .= '<div class="rc_row_text2">';
                $q_text .= '<div class="rc_text2_num std_ans_quiz_" title="ממוצע טעויות בשאלון">';
                $q_text .= get_mistakes_quiz($conn, $row['id']);
                $q_text .= '</div>';
                $q_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
                $q_text .= '<span class="rc_prog_inside rpi_'.$id.'">';
                $q_text .= $prog_bar_text;
                $q_text .= '</span>';
                $q_text .= '</div>';
                $q_text .= '</div>';
                $q_text .= '</div>';
                $q_text .= '</div>';
            }

            // Print deleted quizzes
            if(mysqli_num_rows($query6) > 0)
            {
                while($row = mysqli_fetch_array($query6))
                {
                    $id = $row['id'];
                    
                    $q_text .= '<div class="rc_row rc_row_del" id="rcrow_id_' . $id . '">';
                    $q_text .= '<div class="rc_row_pic quiz_pic_fill">';
                    $q_text .= $quiz_pic_html;
                    $q_text .= '</div>';
                    $q_text .= '<div class="rc_row_text">';
                    $q_text .= '<div class="edit-split" style="justify-content:center;">';
                    $q_text .= '<div class="edit-click-quiz ds_recover_quiz_' . $id . ' del_quiz_recover" id="' . $id . '"';
                    $q_text .= ' quiz-id="' . $id . '">שחזור</div>';
                    $q_text .= '</div>';
                    $q_text .= '<div class="rc_row_text1 quiz_ttl quiz_ttl_' . $id . '" id="' . $id . '" style="color:#fff;">';
                    $q_text .= $row['quiz_name'];
                    $q_text .= '</div>';
                    $q_text .= '<div class="rc_row_text2">';
                    $q_text .= '<div class="rc_text2_num std_ans_quiz_" title="ממוצע טעויות בשאלון">';
                    $q_text .= get_mistakes_quiz($conn, $id);
                    $q_text .= '</div>';
                    $q_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
                    $q_text .= '<span class="rc_prog_inside rpi_'.$id.'">';
                    $q_text .= $prog_bar_text;
                    $q_text .= '</span>';
                    $q_text .= '</div>';
                    $q_text .= '</div>';
                    $q_text .= '</div>';
                    $q_text .= '</div>';
                }
            }
        }
        else
        {
            $q_text = "<span style='padding:10px;'>עדיין אין שאלונים בקורס הזה.</span>";
        }
        echo $q_text;
        

        

        ?>
</div>