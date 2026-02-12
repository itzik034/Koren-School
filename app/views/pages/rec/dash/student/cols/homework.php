<link rel="stylesheet" href="assets/css/quiz.css">
<script src="assets/js/quiz/quiz.js"></script>

<div class="rc_row rc_title" style="user-select:none;">שיעורי בית</div>

<div class="rc_scroll" style="user-select:none;">
    <?php 

    include_once("../../../../../../config/connection.php");
    include_once("../../../../../../helpers/function.php");

    if(session_status() === PHP_SESSION_NONE) 
    {
        session_start();
    }

    $user_id = $_SESSION['user_id'];

    if(isset($_GET['class_id']) && !empty($_GET['class_id']))
    {
        $hw_class_id = $_GET['class_id'];
    }

    $sql5 = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish' ORDER BY id DESC";
    $query5 = mysqli_query($conn, $sql5);

    if(mysqli_num_rows($query5) > 0)
    {
        $q_text = "";
        while($row = mysqli_fetch_array($query5))
        {
            $id = $row['id'];

            $quiz_pic_field = get_quiz_pic($conn, $id);
            $quiz_pic = $quiz_pic_field ? 'uploads/quiz_img/'.$quiz_pic_field : 'uploads/quiz_img/default.png';
            $quiz_pic_html = '<img src="'.$quiz_pic.'">';

            $sql2 = "SELECT * FROM homework WHERE quiz_id = '$id'";
            $query2 = mysqli_query($conn, $sql2) or die("Error");
            if(mysqli_num_rows($query2) > 0)
            {
                while($row2 = $query2 -> fetch_array())
                {
                    $cur_class = $row2['class_id'];
                    if(is_student_in_class($conn, $user_id, $cur_class))
                    {
                        if(isset($hw_class_id) && $hw_class_id != $cur_class)
                        {
                            continue;
                        }
                        
                        $prog_bar = 0;
                        $prog_bar_text = '';
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

                        $q_text .= '<div class="rc_row" id="rcrow_id_' . $id . '">';
                        $q_text .= '<div class="rc_row_pic quiz_pic_fill">';
                        $q_text .= $quiz_pic_html;
                        $q_text .= '</div>';
                        $q_text .= '<div class="rc_row_text">';
                        $q_text .= '<div class="rc_row_text1 quiz_ttl quiz_ttl_' . $id . '" id="' . $id . '">';
                        $q_text .= $row['quiz_name'];
                        $q_text .= '</div>';
                        $q_text .= '<div class="rc_row_text2">';
                        $q_text .= '<div class="rc_text2_num std_ans_quiz_">';
                        $q_text .= get_student_lowest_mistake($conn, $id, $user_id);
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
        }
        if($q_text == ''){echo "<span style='padding:10px;'>אין לך שיעורי בית כרגע.</span>";}
    }
    else
    {
        $q_text = "<span style='padding:10px;'>אין לך שיעורי בית כרגע.</span>";
    }
    echo $q_text;

    ?>
</div>