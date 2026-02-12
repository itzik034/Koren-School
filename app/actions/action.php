<?php

include("connection.php");
include("function.php");

if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    die("syntax error");
}

if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}


if($action == "get_user_rank")
{
    if(isset($_SESSION['user_rank'])){ echo $_SESSION['user_rank']; }
    else{ echo 'no session'; }
}

if($action == "t_f_name")
{
    $id = $_GET['t_id'];
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-first_name'];
        }
    }
    die();
}

if($action == "t_l_name")
{
    $id = $_GET['t_id'];
    $sql = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-last_name'];
        }
    }
    die();
}

if($action == "add-teacher")
{
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $user_name = $_GET['user_name'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $address = $_GET['address'];
    $country = $_GET['country'];
    $school = $_GET['school'];
    $phone = $_GET['phone'];
    $user_id = $_GET['user_id'];
    $sql = "INSERT INTO users (`id`, `username`, `password`, `email`, `email-confirm`, `user-register_date`, `rank`, `user-status`, `user-pic`, `user-first_name`, `user-last_name`, `user-birthday`, `user-address`, `user-country`, `user-school`, `user-phone`, `user-mom_name`, `user-mom_phone`, `user-id`) 
                         VALUES (NULL,'$user_name','$password','$email','0',CURRENT_TIMESTAMP,'t', 'active', '','$first_name','$last_name','','$address','$country','$school','$phone','','','$user_id')";
    mysqli_query($conn, $sql) or die("mysql error");
    echo 1;
}

if($action == "add-student")
{
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $user_name = $_GET['user_name'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $address = $_GET['address'];
    $country = $_GET['country'];
    $school = $_GET['school'];
    $phone = $_GET['phone'];
    $st_mom = $_GET['st_mom'];
    $st_mom_phone = $_GET['st_mom_phone'];
    $user_id = $_GET['user_id'];
    $sql = "INSERT INTO users (`id`, `username`, `password`, `email`, `email-confirm`, `user-register_date`, `rank`, `user-status`, `user-pic`, `user-first_name`, `user-last_name`, `user-birthday`, `user-address`, `user-country`, `user-school`, `user-phone`, `user-mom_name`, `user-mom_phone`, `user-id`) 
                         VALUES (NULL,'$user_name','$password','$email','0',CURRENT_TIMESTAMP,'s', 'active', '','$first_name','$last_name','','$address','$country','$school','$phone','$st_mom','$st_mom_phone','$user_id')";
    mysqli_query($conn, $sql) or die("mysql error");
    echo "321322";
    die();
}

if($action == "delete-teacher")
{
    $t_id = $_GET['t_id'];
    $sql = "UPDATE users SET `user-status` = 'disabled' WHERE `id` = '$t_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
    die();
}

if($action == "delete-student")
{
    $s_id = $_GET['s_id'];
    $sql = "UPDATE users SET `user-status` = 'disabled' WHERE `id` = '$s_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
    die();
}

if($action == "edit-teacher")
{
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $user_name = $_GET['user_name'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $address = $_GET['address'];
    $country = $_GET['country'];
    $school = $_GET['school'];
    $phone = $_GET['phone'];
    $uid = $_GET['uid'];
    $sql = "UPDATE users SET 
                             `user-first_name` = '$first_name', 
                             `user-last_name` = '$last_name', 
                             `username` = '$user_name', 
                             `password` = '$password', 
                             `email` = '$email', 
                             `user-address` = '$address', 
                             `user-country` = '$country', 
                             `user-school` = '$school', 
                             `user-phone` = '$phone', 
                         WHERE `id` = '$uid'";
    mysqli_query($conn, $sql) or die("mysql error");
    echo "1112223";
    die();
}

if($action == "update_et_data")
{
    $teacher_id = $_GET['teacher_id'];
    $f_name = $_GET['f_name'];
    $l_name = $_GET['l_name'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $address = $_GET['address'];
    $country = $_GET['country'];
    $school = $_GET['school'];
    $phone = $_GET['phone'];
    $user_id = $_GET['user_id'];
    
    $sql = "UPDATE users SET `email`           = '$email', 
                             `password`        = '$password', 
                             `user-first_name` = '$f_name', 
                             `user-last_name`  = '$l_name', 
                             `user-address`    = '$address', 
                             `user-country`    = '$country', 
                             `user-school` = '$school', 
                             `user-phone` = '$phone', 
                             `user-id` = '$user_id' 
            WHERE id = '$teacher_id'";
    mysqli_query($conn, $sql) or die("sql error");
    echo 'success';
}

if($action == "edit-student")
{
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $user_name = $_GET['user_name'];
    $password = $_GET['password'];
    $email = $_GET['email'];
    $address = $_GET['address'];
    $country = $_GET['country'];
    $school = $_GET['school'];
    $phone = $_GET['phone'];
    $st_mom = $_GET['st_mom'];
    $st_mom_phone = $_GET['st_mom_phone'];
    $user_id = $_GET['user_id'];
    $uid = $_GET['uid'];
    $sql = "UPDATE users SET 
                             `user-first_name` = '$first_name', 
                             `user-last_name` = '$last_name', 
                             `username` = '$user_name', 
                             `password` = '$password', 
                             `email` = '$email', 
                             `user-address` = '$address', 
                             `user-country` = '$country', 
                             `user-school` = '$school', 
                             `user-phone` = '$phone', 
                             `user-mom_name` = '$st_mom', 
                             `user-mom_phone` = '$st_mom_phone', 
                             `user-id` = '$user_id' 
                         WHERE `id` = '$uid'";
    mysqli_query($conn, $sql) or die("mysql error");
    echo "12131";
    die();
}

if($action == "get_user_field")
{
    $uid = $_GET['uid'];
    $field = $_GET['field'];
    $sql = "SELECT * FROM users WHERE id = '$uid' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row[$field];
        }
    }
    die();
}

if($action == "pack_text")
{
    echo pack_text($_GET['pack']);
}

if($action == "rank_text")
{
    echo rank_text($_GET['rank']);
}

if($action == "get_pack_field")
{
    $uid = $_GET['uid'];
    $field = $_GET['field'];
    $sql = "SELECT * FROM user_pack WHERE user_id = '$uid' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row[$field];
        }
    }
    die();
}

if($action == "check-username")
{
    $username_check = $_GET['username'];
    $sql = "SELECT * FROM users WHERE username = '$username_check'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) == 0)
    {
        echo 'true';
    }
    else
    {
        echo 'false';
    }
    die();
}

if($action == "get_edit_teacher_classes_list")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes WHERE class_status = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $my_id = $row['id'];
            $my_name = get_class_name_by_id($conn, $my_id);
            $checked = '';
            $sql2 = "SELECT * FROM classes_teachers WHERE teacher_id = '$teacher_id' AND class_id = '$my_id' LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            while($row2 = mysqli_fetch_array($query2))
            {
                if($row2['teacher_id'] == $teacher_id)
                {
                    $checked = 'checked';
                }
            }
            ?>
            <div class="actt_class_fill actt_class_fill_<?php echo $my_id; ?>" id="<?php echo $my_id; ?>">
                <input type="checkbox" class="cckbx<?php echo $my_id; ?>" <?php echo $checked; ?>>
                <span><?php echo $my_name; ?></span>
            </div>
            <?php 
            fix_class_teacher($conn, $my_id);
        }
    }
    else
    {
        echo 0;
    }
}

if($action == "class_is_check")
{
    $class_id = $_GET['class_id'];
    $teacher_id = $_GET['teacher_id'];

    if(empty($class_id) || empty($teacher_id))
    {
        echo "<script>alert('Class Id is: " . $class_id . " and Teacher Id is: " . $teacher_id . "');</script>";
    }

    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['id'];
        }
    }
    else
    {
        $sql2 = "INSERT INTO classes_teachers (`teacher_id`, `class_id`) VALUES ('$teacher_id', '$class_id')";
        mysqli_query($conn, $sql2) or die("sql error");
        fix_class_teacher($conn, $class_id);
        echo 999;
    }
}

if($action == "class_is_not_check")
{
    $class_id = $_GET['class_id'];
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $sql3 = "DELETE FROM classes_teachers WHERE teacher_id = '$teacher_id' AND class_id = '$class_id'";
        mysqli_query($conn, $sql3) or die("sql error 2");
        echo 777;
    }
    else
    {
        echo 888;
    }
}

if($action == "save_et_new_cls_data")
{
    $class_name = $_GET['class_name'];
    $class_course = $_GET['class_course'];
    $class_loc = $_GET['class_loc'];
    $class_year1 = $_GET['class_year1'];
    $class_year2 = $_GET['class_year2'];
    $teacher_id = $_GET['teacher_id'];

    $sql = "INSERT INTO classes (`course_id`, `teacher_id`, `class_location`, `class_year1`, `class_year2`, `class_text`) 
                         VALUES ('$class_course', '$teacher_id', '$class_loc', '$class_year1', '$class_year2', '$class_name')";
    mysqli_query($conn, $sql) or die('sql error');
    $sql3 = "SELECT * FROM classes ORDER BY id DESC LIMIT 1";
    $query3 = mysqli_query($conn, $sql3);
    while($row = mysqli_fetch_array($query3))
    {
        $class_id = $row['id'];
    }
    sleep(1);
    $sql2 = "INSERT INTO classes_teachers (`teacher_id`, `class_id`) VALUES ('$teacher_id', '$class_id')";
    mysqli_query($conn, $sql2) or die("sql2 error");
    fix_class_teacher($conn, $class_id);
    echo 1;
}

if($action == "get_etf_field_data1")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-first_name'];
        }
    }
}

if($action == "get_etf_field_data2")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-last_name'];
        }
    }
}

if($action == "get_etf_field_data3")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['email'];
        }
    }
}

if($action == "get_etf_field_data4")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['password'];
        }
    }
}

if($action == "get_etf_field_data5")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-address'];
        }
    }
}

if($action == "get_etf_field_data6")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-country'];
        }
    }
}

if($action == "get_etf_field_data7")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-school'];
        }
    }
}

if($action == "get_etf_field_data8")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-phone'];
        }
    }
}

if($action == "get_etf_field_data9")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM users WHERE id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['user-id'];
        }
    }
}

if($action == "get_teachers_select_ac")
{
    $sql = "SELECT * FROM users WHERE rank = 't' AND `user-status` = 'active'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $full_name = $row['user-first_name'].' '.$row['user-last_name'];
            echo '<option value="' . $row['id'] . '">' . $full_name . '</option>';
        }
    }
    else
    {
        echo '<option value="0"><i>אין מורה לכיתה</i></option>';
    }
}

if($action == "get_courses_select_ac")
{
    $sql = "SELECT * FROM courses WHERE `course_status` = 'publish'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $ln = get_level_name($row['course_level']);
            echo '<option value="' . $row['id'] . '">' . $row['course_name'] . ' | ' . $ln .'</option>';
        }
    }
}

if($action == "save_add_class_form_data")
{
    $class_name = $_GET['class_name'];
    $class_teacher = $_GET['class_teacher'];
    $class_course = $_GET['class_course'];
    $class_loc = $_GET['class_loc'];
    $class_date1 = $_GET['class_date1'];
    $class_date2 = $_GET['class_date2'];

    $sql = "INSERT INTO classes (`course_id`, `teacher_id`, `class_location`, `class_year1`, `class_year2`, `class_text`) 
                         VALUES ('$class_course', '$class_teacher', '$class_loc', '$class_date1', '$class_date2', '$class_name')";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if($action == "save_edit_class_form_data")
{
    $class_id = $_GET['class_id'];
    $class_name = $_GET['class_name'];
    $class_teacher = $_GET['class_teacher'];
    $class_course = $_GET['class_course'];
    $class_loc = $_GET['class_loc'];
    $class_date1 = $_GET['class_date1'];
    $class_date2 = $_GET['class_date2'];

    $sql = "UPDATE classes SET `class_text` = '$class_name', 
                               `teacher_id` = '$class_teacher', 
                               `course_id` = '$class_course', 
                               `class_location` = '$class_loc', 
                               `class_year1` = '$class_date1', 
                               `class_year2` = '$class_date2' 
                             WHERE id = '$class_id'";
    
    $sql2 = "SELECT * FROM classes_teachers WHERE class_id = '$class_id'";
    $query2 = mysqli_query($conn, $sql2);
    $row = $query2 -> fetch_assoc();
    $cls_tch_is_ext = $row['teacher_id'];
    if($cls_tch_is_ext != '')
    {
        $sql3 = "INSERT INTO classes_teachers (`teacher_id`, `class_id`) VALUES ('$class_teacher', '$class_id')";
        mysqli_query($conn, $sql3) or die('sql error');
    }
    else
    {
        $sql3 = "INSERT INTO classes_teachers (`teacher_id`, `class_id`) VALUES ('$class_teacher 6', '$class_id')";
        mysqli_query($conn, $sql3) or die('sql error');
    }

    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if($action == "get_ec_data_1")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['class_text'];
        }
    }
}

if($action == "get_ec_data_2")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['course_id'];
        }
    }
}

if($action == "get_ec_data_3")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['teacher_id'];
        }
    }
}

if($action == "get_ec_data_4")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['class_location'];
        }
    }
}

if($action == "get_ec_data_5")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['class_year1'];
        }
    }
}

if($action == "get_ec_data_6")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM classes WHERE `id` = '$class_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['class_year2'];
        }
    }
}

if($action == "get_num_of_users")
{
    $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['id'];
        }
    }
}

if($action == "get_num_of_packs")
{
    $sql = "SELECT * FROM user_pack ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['id'];
        }
    }
}

if($action == "student_is_check")
{
    $class_id = $_GET['class_id'];
    $student_id = $_GET['student_id'];
    $sql = "SELECT * FROM classes_students WHERE class_id = '$class_id' AND student_id = '$student_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) === 0)
    {
        $sql2 = "INSERT INTO classes_students (`class_id`, `student_id`) VALUES ('$class_id', '$student_id')";
        mysqli_query($conn, $sql2) or die("sql error");
        echo 999;
    }
}

if($action == "student_is_not_check")
{
    $class_id = $_GET['class_id'];
    $student_id = $_GET['student_id'];
    $sql = "SELECT * FROM classes_students WHERE class_id = '$class_id' AND student_id = '$student_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $sql3 = "DELETE FROM classes_students WHERE student_id = '$student_id' AND class_id = '$class_id'";
        mysqli_query($conn, $sql3) or die("sql error 2");
        echo 777;
    }
    else
    {
        echo 888;
    }
}

if($action == "load_cls_tch_checks")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM users WHERE `rank` = 't' AND `user-status` = 'active' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $my_id = $row['id'];
            $my_name = get_user_full_name($conn, $my_id);
            $checked = '';
            $sql2 = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$my_id' LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            while($row2 = mysqli_fetch_array($query2))
            {
                if($row2['class_id'] == $class_id)
                {
                    $checked = 'checked';
                }
            }
            ?>
            <div class="std_fill tch_fill_<?php echo $my_id; ?>" id="<?php echo $my_id; ?>">
                <input type="checkbox" class="chck_c_s_<?php echo $my_id; ?>" <?php echo $checked; ?>>
                <span><?php echo $my_name; ?></span>
            </div>
            <?php 
        }
    }
    else
    {
        echo 0;
    }
}

if($action == "teacher_is_check")
{
    $class_id = $_GET['class_id'];
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) === 0)
    {
        $sql2 = "INSERT INTO classes_teachers (`class_id`, `teacher_id`) VALUES ('$class_id', '$teacher_id')";
        mysqli_query($conn, $sql2) or die("sql error");
        echo 999;
    }
}

if($action == "teacher_is_not_check")
{
    $class_id = $_GET['class_id'];
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$teacher_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        $sql3 = "DELETE FROM classes_teachers WHERE teacher_id = '$teacher_id' AND class_id = '$class_id'";
        mysqli_query($conn, $sql3) or die("sql error 2");
        echo 777;
    }
    else
    {
        echo 888;
    }
}

if($action == "load_students_checks")
{
    $class_id = $_GET['class_id'];
    $sql = "SELECT * FROM users WHERE `rank` = 's' AND `user-status` = 'active' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $my_id = $row['id'];
            $my_name = get_user_full_name($conn, $my_id);
            $checked = '';
            $sql2 = "SELECT * FROM classes_students WHERE class_id = '$class_id' AND student_id = '$my_id' LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            while($row2 = mysqli_fetch_array($query2))
            {
                if($row2['class_id'] == $class_id)
                {
                    $checked = 'checked';
                }
            }
            ?>
            <div class="std_fill std_fill_<?php echo $my_id; ?>" id="<?php echo $my_id; ?>">
                <input type="checkbox" class="chck_c_s_<?php echo $my_id; ?>" <?php echo $checked; ?>>
                <span><?php echo $my_name; ?></span>
            </div>
            <?php 
        }
    }
    else
    {
        echo 0;
    }
}

if($action == "create_student")
{
    $std_f_name = $_GET['f_name'];
    $std_l_name = $_GET['l_name'];
    $std_email = $_GET['email'];
    $std_password = $_GET['password'];
    $std_birthday = $_GET['birthday'];
    $std_address = $_GET['address'];
    $std_country = $_GET['country'];
    $std_school = $_GET['school'];
    $std_phone = $_GET['phone'];
    $std_mom_name = $_GET['mom_name'];
    $std_mom_phone = $_GET['mom_phone'];
    $std_id = $_GET['id'];
    
    $sql = "INSERT INTO `users`(`username`, `password`, `email`, `email-confirm`, `user-register_date`, `rank`, `user-status`, `user-pic`, `user-first_name`, `user-last_name`, `user-birthday`, `user-address`, `user-country`, `user-school`, `user-phone`, `user-mom_name`, `user-mom_phone`, `user-id`) 
                        VALUES ('','$std_password','$std_email','0',CURRENT_TIMESTAMP,'s','active','','$std_f_name','$std_l_name','$std_birthday','$std_address','$std_country','$std_school','$std_phone','$std_mom_name','$std_mom_phone','$std_id')";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
}

if($action == "get_user_pack")
{
    $user_id = $_GET['user_id'];
    echo get_user_pack($conn, $user_id);
}

if($action == "add_pack_to_user")
{
    $user_id = $_GET['user_id'];
    $pack = $_GET['pack'];
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $pay_method = $_GET['pay_method'];
    $price = $_GET['price'];
    $sql = "INSERT INTO `user_pack`(`user_id`, `pack_name`, `pack_pay_method`, `pack_pay_price`, `pack_status`, `pack_start_date`, `pack_end_date`) 
            VALUES ('$user_id','$pack','$pay_method','$price','active','$start_time','$end_time')";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
}

if($action == "edit_pack_of_user")
{
    $user_id = $_GET['user_id'];
    $pack = $_GET['pack'];
    $start_time = $_GET['start_time'];
    $end_time = $_GET['end_time'];
    $pay_method = $_GET['pay_method'];
    $price = $_GET['price'];
    $sql = "UPDATE user_pack SET   `pack_name`       = '$pack', 
                                   `pack_pay_method` = '$pay_method', 
                                   `pack_pay_price`  = '$price', 
                                   `pack_start_date` = '$start_time', 
                                   `pack_end_date`   = '$end_time' 
                                   WHERE `user_id`   = '$user_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
}

if($action == "delete_user_pack")
{
    $user_id = $_GET['user_id'];
    $sql = "DELETE FROM user_pack WHERE user_id = '$user_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
}

if($action == "update_admin_edit_user_data")
{
    $user_id = $_GET['user_id'];
    $f_name = $_GET['f_name'];
    $l_name = $_GET['l_name'];
    $rank = $_GET['rank'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];

    $sql = "UPDATE users SET `user-first_name` = '$f_name', 
                             `user-last_name` = '$l_name', 
                             `rank` = '$rank', 
                             `email` = '$email', 
                             `user-phone` = '$phone' 
                            WHERE id = '$user_id'";
    mysqli_query($conn, $sql) or die("sql error");
    echo 1;
}

if($action == "delete_user")
{
    $user_id = $_GET['user_id'];
    $sql = "UPDATE users SET `user-status` = 'disabled' WHERE `id` = '$user_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
    die();
}

if($action == "recycle_user")
{
    $user_id = $_GET['user_id'];
    $sql = "UPDATE users SET `user-status` = 'active' WHERE `id` = '$user_id'";
    mysqli_query($conn, $sql) or die('sql error');
    echo 1;
    die();
}

if($action == "get_num_of_classes_of_teacher")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes_teachers WHERE teacher_id = '$teacher_id'";
    $query = mysqli_query($conn, $sql);
    echo mysqli_num_rows($query);
}

if($action == "get_num_of_teachers")
{
    $sql = "SELECT * FROM users WHERE rank = 't'";
    $query = mysqli_query($conn, $sql);
    echo mysqli_num_rows($query);
}

if($action == "get_first_teacher_user_id")
{
    $sql = "SELECT id FROM users WHERE rank = 't' AND `user-status` = 'active' ORDER BY id ASC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($query)) {
        echo $row['id'];
    } else {
        echo "";
    }
    die();
}

if($action == "get_last_teacher_user_id")
{
    $sql = "SELECT id FROM users WHERE rank = 't' AND `user-status` = 'active' ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($query)) {
        echo $row['id'];
    } else {
        echo "";
    }
    die();
}

if($action == "get_num_of_students")
{
    $sql = "SELECT * FROM users WHERE rank = 's' AND `user-status` = 'active' ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    echo $result['id'];
}

if($action == "get_student_avg_prog")
{
    $student_id = $_GET['student_id'];
    if(!existing_student($conn, $student_id)) { die; }
    $sql = "SELECT `run_progress_bar` FROM user_quiz_run WHERE `user_id` = $student_id";
    $query = mysqli_query($conn, $sql);
    $avg = 0;
    $count = 0;
    while($row = mysqli_fetch_array($query))
    {
        $progress_bar = $row['run_progress_bar'];
        $avg += $progress_bar;
        $count += 1;
    }
    $avg = $avg / $count;
    $avg = number_format($avg, 2);
    echo $avg;
}

if($action == "get_student_unfinished_quizzes")
{
    $student_id = $_GET['student_id'];
    if(!existing_student($conn, $student_id)) { die; }
    get_student_classes($conn, $student_id);
}

?>