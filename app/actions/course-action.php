<?php

include("../config/connection.php");
include("../helpers/function.php");

if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];
}
else
{
    die('error');
}



if($action == "get_course_table")
{
    ?>
    
    <tr class="ct_row ct_first_row">
        <th class="ct_col ct_fr_col">ID</th>
        <th class="ct_col ct_fr_col">קורס</th>
        <th class="ct_col ct_fr_col">רמה</th>
        <th class="ct_col ct_fr_col">פעולות</th>
    </tr>
    
    <?php  
    $sql = "SELECT * FROM courses WHERE `course_status` = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            ?>
            
            <tr class="ct_row">
                <td class="ct_col ct_col_id"><?php echo $row['id']; ?></td>
                <td class="ct_col ct_col_course_name ct_col_course_name_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>"><?php echo $row['course_name']; ?></td>
                <td class="ct_col ct_col_course_level ct_col_course_level_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>"><?php echo get_level_name($row['course_level']); ?></td>
                <td class="ct_col ct_col_actions">
                    <div class="ct_edit_btn_fill ct_edit_btn_fill_<?php echo $row['id']; ?>">
                        <span class="ct_btn_edit ct_btn_edit_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">עריכה</span>
                    </div>
                    &nbsp;-&nbsp;
                    <span class="ct_btn_delete ct_btn_delete_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">מחיקה</span>
                    &nbsp;-&nbsp;
                    <span class="ct_btn_manage ct_btn_manage_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">ניהול קורס</span>
                </td>
            </tr>
            
            <?php
        }
    }
}

if($action == "get_num_of_courses")
{
    $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['id'];
        }
    }
}

if($action == "delete_course")
{
    $course_id = $_GET['course_id'];
    $sql = "UPDATE `courses` SET `course_status` = 'deleted' WHERE `id` = '$course_id'";
    mysqli_query($conn, $sql) or die("error");
    echo 1;
}

if($action == "get_course_name_by_id")
{
    $course_id = $_GET['course_id'];
    $sql = "SELECT * FROM courses WHERE `id` = '$course_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['course_name'];
        }
    }
}

if($action == "save_ct_data")
{
    $course_id = $_GET['course_id'];
    $course_name_field = $_GET['course_name_field'];
    $level_field = $_GET['level_field'];
    $sql = "UPDATE courses SET `course_name` = '$course_name_field', `course_level` = '$level_field' WHERE `id` = '$course_id'";
    mysqli_query($conn, $sql) or die('error');
    echo 1;
}

if($action == "upload_new_course")
{
    $course_name_field = $_GET['course_name_field'];
    $course_level1 = (int)$_GET['course_level1'];
    $course_level2 = (int)$_GET['course_level2'];
    if($course_level1 < $course_level2 || $course_level1 == $course_level2)
    {
        for($i = $course_level1; $i <= $course_level2; $i++)
        {
            $course_level = $i;
            $sql = "INSERT INTO `courses` (`id`, `course_name`, `course_level`, `course_status`) VALUES (NULL, '{$course_name_field}', '{$course_level}', 'publish')";
            mysqli_query($conn, $sql) or die('error');
        }
    }
    else
    {
        die('error2');
    }
    
    echo 1;
}

if($action == "set_course")
{
    $course_id = $_GET['course_id'];
    $_SESSION['c_id'] = $course_id;
    echo 1;
}

if($action == "set_class")
{
    $class_id = $_GET['class_id'];
    $_SESSION['cl_id'] = $class_id;
    echo 1;
}

if($action == "get_current_course")
{
    if(isset($_SESSION['c_id']) && !empty($_SESSION['c_id']))
    {
        echo $_SESSION['c_id'];
    }
    else
    {
        echo -1;
    }
}

if($action == "get_current_class")
{
    if(isset($_SESSION['cl_id']) && !empty($_SESSION['cl_id']))
    {
        echo $_SESSION['cl_id'];
    }
    else
    {
        echo -1;
    }
}

if($action == "get_courses_dash")
{
    $sql = "SELECT * FROM courses WHERE course_status = 'publish'";
    $query = mysqli_query($conn, $sql);
    echo '<span class="slct_crs slct_crs_0 chosen" id="0">הכל</span>';
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $ln = get_level_name($row['course_level']);
            echo "<span class='slct_crs slct_crs_{$row['id']}' id='{$row['id']}'>{$row['course_name']} | {$ln}</span>";
        }
    }
    else
    {
        echo 'עדיין אין קורסים.';
    }
}

if($action == "get_classes_dash")
{
    $sql = "SELECT * FROM classes WHERE class_status = 'publish' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    echo '<span class="slct_cls slct_cls_0 chosen" id="0">הכל</span>';
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo "<span class='slct_cls slct_cls_{$row['id']}' id='{$row['id']}'>{$row['class_text']}</span>";
        }
    }
    else
    {
        echo 'עדיין אין כיתות.';
    }
}

if($action == "get_classes_dash_by_t_id")
{
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM classes WHERE class_status = 'publish' AND teacher_id = '$teacher_id' ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    echo '<span class="slct_cls slct_cls_0 chosen" id="0">הכל</span>';
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo "<span class='slct_cls slct_cls_{$row['id']}' id='{$row['id']}'>{$row['class_text']}</span>";
        }
    }
    else
    {
        echo 'עדיין אין לך כיתות.';
    }
}

if($action == "get_courses_edit_teacher")
{
    $sql = "SELECT * FROM courses WHERE course_status = 'publish'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $ln = get_level_name($row['course_level']);
            echo "<option class='slct_crs_et slct_crs_et_{$row['id']}' id='{$row['id']}' value='{$row['id']}'>{$row['course_name']} | {$ln}</option>";
        }
    }
    else
    {
        echo '<option value="0">' . 'עדיין אין קורסים.' . '</option>';
    }
}

if($action == "get_course_level")
{
    $course_id = $_GET['course_id'];
    $sql = "SELECT * FROM courses WHERE `id` = '$course_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            echo $row['course_level'];
        }
    }
}

if($action == "recycle_course")
{
    $course_id = $_GET['course_id'];
    $sql = "UPDATE courses SET `course_status` = 'publish' WHERE id = '$course_id'";
    mysqli_query($conn, $sql) or die('error');
    echo 1;
}


?>