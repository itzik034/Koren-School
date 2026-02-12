<?php

function get_class_name_by_id($conn, $class_id)
{
    $sql = "SELECT * FROM classes WHERE id = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) == 1)
    {
        while($row = mysqli_fetch_array($query))
        {
            return $row['class_text'];
        }
    }
}

function get_root_dir()
{
    $rootUrl = "http://$_SERVER[HTTP_HOST]/ks/";
    return $rootUrl;
}

function get_quiz_by_id($quiz_id, $conn)
{
    $output = "";
    include_once("connection.php");
    $sql = "SELECT * FROM quizzes WHERE id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($query))
    {
        $output .= $row['quiz_name'];
    }
    return $output;
}

function get_sub_name_by_id($sub_id, $conn)
{
    $output = "";
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($query))
    {
        $output = $row['sub_name'];
    }
    return $output;
}

function get_quiz_by_sub_id($sub_id, $conn)
{
    $output = "";
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($query))
    {
        $output = $row['sub_quiz_id'];
    }
    return $output;
}

function get_num_of_bins_by_sub_id($sub_id, $conn)
{
    $output = "";
    $sql = "SELECT * FROM subjects WHERE id = '$sub_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($query))
    {
        $output = $row['sub_bin_num'];
    }
    return $output;
}

function clear_value($conn, $value)
{
    $value = mysqli_real_escape_string($conn, $value);
    $value = strip_tags($value);

    return $value;
}

function get_user_first_name($conn, $user_id)
{
    $output = "";
    $sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $output = $row['user-first_name'];
        }
    }
    return $output;
}

function get_user_last_name($conn, $user_id)
{
    $output = "";
    $sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $output = $row['user-last_name'];
        }
    }
    return $output;
}

function get_user_field($conn, $user_id, $field)
{
    $output = "";
    $sql = "SELECT * FROM users WHERE id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $output = $row[$field];
        }
    }
    return $output;
}

function get_pack_field($conn, $user_id, $field)
{
    $output = "";
    $sql = "SELECT * FROM user_pack WHERE user_id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $output = $row[$field];
        }
    }
    return $output;
}

function get_user_full_name($conn, $user_id)
{
    return get_user_first_name($conn, $user_id) . ' ' . get_user_last_name($conn, $user_id);
}

function get_class_teacher($conn, $class_id)
{
    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            return $row['teacher_id'];
        }
    }
    else
    {
        return 0;
    }
}

function fix_class_teacher($conn, $class_id)
{
    $class_teacher = get_class_teacher($conn, $class_id);
    $sql = "UPDATE classes SET `teacher_id` = '$class_teacher' WHERE id = '$class_id'";
    mysqli_query($conn, $sql);
}

function get_level_name($level)
{
    if($level == '1')
        {
            return "כיתה א'";
        }
        else if($level == '2')
        {
            return "כיתה ב'";
        }
        else if($level == '3')
        {
            return "כיתה ג'";
        }
        else if($level == '4')
        {
            return "כיתה ד'";
        }
        else if($level == '5')
        {
            return "כיתה ה'";
        }
        else if($level == '6')
        {
            return "כיתה ו'";
        }
        else if($level == '7')
        {
            return "כיתה ז'";
        }
        else if($level == '8')
        {
            return "כיתה ח'";
        }
        else if($level == '9')
        {
            return "כיתה ט'";
        }
        else if($level == '10')
        {
            return "כיתה י'";
        }
        else if($level == '11')
        {
            return 'כיתה י"א';
        }
        else if($level == '12')
        {
            return 'כיתה י"ב';
        }
}

function pack_text($pack)
{
    switch($pack) 
    {
        case '1':
            return 'קורס פרונטלי';
            break;
        
        case '2':
            return 'קורס דיגיטלי';
            break;
        
        case '3':
            return 'שיעורים פרטיים';
            break;
        
        default:
            break;
    }
}

function rank_text($rank)
{
    switch($rank) 
    {
        case 'a':
            return 'מנהל';
            break;
        
        case 't':
            return 'מורה';
            break;
        
        case 's':
            return 'תלמיד';
            break;
        
        default:
            break;
    }
}

function pay_text($method)
{
    switch($method) 
    {
        case 'credit':
            return 'כרטיס אשראי';
            break;
        
        case 'cash':
            return 'מזומן';
            break;
        
        case 'bit':
            return 'bit';
            break;
        
        default:
            break;
    }
}

function get_user_pack($conn, $user_id)
{
    $sql = "SELECT * FROM user_pack WHERE user_id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql) or die();
    if(mysqli_num_rows($query) > 0)
    {
        $row = $query -> fetch_assoc();
        return $row['pack_name'];
    }
}

function get_pack_name($conn, $pack_id)
{
    $sql = "SELECT * FROM user_pack WHERE id = '$pack_id' LIMIT 1";
    $query = mysqli_query($conn, $sql) or die();
    if(mysqli_num_rows($query) > 0)
    {
        $row = $query -> fetch_assoc();
        return pack_text($row['pack_name']);
    }
}

function is_user_login()
{
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_rank'])){ return true; }
    else{ return false; }
}

function is_admin_login()
{
    if($_SESSION['user_rank'] == 'a'){ return true; }
    else{ return false; }
}

function is_teacher_login()
{
    if($_SESSION['user_rank'] == 't'){ return true; }
    else{ return false; }
}

function is_student_login()
{
    if($_SESSION['user_rank'] == 's'){ return true; }
    else{ return false; }
}

function is_student_in_class($conn, $student_id, $class_id)
{
    $output = 0;
    $sql = "SELECT * FROM classes_students WHERE student_id = '$student_id' AND class_id = '$class_id'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = $query -> fetch_array())
        {
            $output += 1;
        }
    }
    if($output > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function get_teacher_name_by_id($conn, $teacher_id)
{
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $output = $row['user-first_name'];
            $output .= " ";
            $output .= $row['user-last_name'];
            return $output;
        }
    }
}

function get_mistakes_quiz($conn, $quiz_id)
{
    $sql = "SELECT * FROM quiz_run WHERE quiz_id = '$quiz_id'";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0)
    {
        $mis = 0;
        $runs = 0;

        while($row = mysqli_fetch_array($query))
        {
            $run_mis = (int)$row['run_mistakes'];

            if($run_mis > 0)
            {
                $mis += $run_mis;
                $runs += 1;
            }
        }

        if($runs === 0){ $runs = 1; }
        
        $avarge = $mis / $runs;

        if(is_float($avarge))
        {
            $avarge = number_format((float)$avarge, 2, '.', '');
        }
    }
    else
    {
        $avarge = '-';
    }

    return $avarge;
}

function get_student_lowest_mistake($conn, $quiz_id, $student_id)
{
    $sql = "SELECT * FROM quiz_run WHERE quiz_id = '$quiz_id' AND user_id = '$student_id'";
    $query = mysqli_query($conn, $sql);

    $lowest_mistake = PHP_INT_MAX;

    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $mis = (int)$row['run_mistakes'];
            if($mis < $lowest_mistake)
            {
                $lowest_mistake = $mis;
            }
        }
    }
    else
    {
        $lowest_mistake = '-';
    }

    return $lowest_mistake;
}

function get_quiz_pic($conn, $quiz_id)
{
    $sql = "SELECT quiz_pic FROM quizzes WHERE id = '$quiz_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $row = $query -> fetch_assoc();
        return $row['quiz_pic'];
    }
}

function get_user_pic($conn, $user_id)
{
    $sql = "SELECT `user-pic` FROM users WHERE id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $row = $query -> fetch_assoc();
        return $row['user-pic'];
    }
}

function get_class_course($conn, $class_id)
{
    $sql = "SELECT `course_id` FROM classes WHERE id = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $row = $query -> fetch_assoc();
        return $row['course_id'];
    }
}

function is_teacher_in_class($conn, $teacher_id, $class_id)
{
    $sql = "SELECT * FROM classes_teachers WHERE `teacher_id` = '$teacher_id' AND `class_id` = '$class_id'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

// function get_class_by_quiz_id($conn, $quiz_id)
// {
//     $output = '';
//     $sql = "SELECT `quiz_course_id` FROM quizzes WHERE id = '$quiz_id' LIMIT 1";
//     $query = mysqli_query($conn, $sql);
//     if(mysqli_num_rows($query) > 0)
//     {
//         $row = $query -> fetch_assoc();
//         $course_id = $row['quiz_course_id'];

//         $sql2 = "SELECT * FROM classes WHERE course_id = '$course_id'";
//         $query2 = mysqli_query($conn, $sql2);
//         if(mysqli_num_rows($query2) > 0)
//         {
//             while($row2 = $query2 -> fetch_array())
//             {
//                 $output = $row2['id'];
//             }
//         }
//     }
//     return $output;
// }



function get_class_by_quiz_id($conn, $quiz_id)
{
    // בודק את הקורס של ה-quiz
    $sql = "SELECT quiz_course_id FROM quizzes WHERE id = '$quiz_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0)
    {
        $row = $query->fetch_assoc();
        $course_id = $row['quiz_course_id'];

        // בודק את כל הכיתות של הקורס
        $sql2 = "SELECT id FROM classes WHERE course_id = '$course_id'";
        $query2 = mysqli_query($conn, $sql2);

        $last_id = null;
        while($row2 = $query2->fetch_assoc())
        {
            $last_id = $row2['id']; // שומר כל פעם את ה-ID, בסוף נשאר האחרון
        }

        return $last_id; // מחזיר את ה-ID האחרון
    }

    return null; // אם לא נמצא quiz
}

function existing_student($conn, $student_id)
{
    $sql = "SELECT * FROM users WHERE `id` = '$student_id' AND `user-status` = 'active' AND `rank` = 's'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0) { return true; }
    else{ return false; }
}

function get_student_classes($conn, $student_id) 
{
    $sql = "SELECT * FROM classes_students WHERE student_id = '$student_id'";
    $query = mysqli_query($conn, $sql);
    
}


?>