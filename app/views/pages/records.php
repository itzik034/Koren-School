<link rel="stylesheet" href="assets/css/records.css" type="text/css">
<script src="assets/js/functions.js"></script>
<script src="assets/js/quiz-app/popup.js"></script>

<?php

include_once("app/helpers/function.php");
include_once("app/config/connection.php");
include_once("app/views/pages/popups.php");
include_once("app/views/pages/quiz-app/popup.php");

// Start session if hasn't started yet
if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

//Check if user has logged in
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
{
    echo '<script>window.location.href="?page=login";</script>';
    die();
}
$rank = $_SESSION['user_rank'];

if($rank == 'a')
{
    echo '<script src="assets/js/records.js"></script>';
}
else if($rank == 't')
{
    echo '<script src="assets/js/rec/dash/teacher/records.js"></script>';
}
else
{
    echo '<script src="assets/js/rec/dash/student/records.js"></script>';
}

$admin = is_admin_login();
$teacher = is_teacher_login();
$student = is_student_login();

?>

<div class="rc_main">
    <div class="rc_grades">
        <div class="courses_list_fill"></div>
        <?php if($admin) {?>
            <div class="rc_plus" id="add_course_btn"><i class="fa-solid fa-plus"></i>&nbsp;ניהול קורסים</div>
        <?php } ?>
    </div>
    <div class="homework">
        <?php
        
        if($admin)
        {
            // Admin dashboard
            ?>
            <div class="rc_col rc_col_classes">
                <?php include(__DIR__."/rec/classes.php"); ?>
            </div>
            
            <div class="rc_col rc_col_teachers">
                <?php include(__DIR__."/rec/teachers.php"); ?>
            </div>
        
            <div class="rc_col rc_col_quiz">
                <?php include(__DIR__."/rec/quiz.php"); ?>
            </div>

            <div class="rc_col rc_col_students" id="students-col">
                <?php include(__DIR__."/rec/students.php"); ?>
            </div>

            <link rel="stylesheet" href="assets/css/res/records.css">
            <?php 
        }
        else if($teacher)
        {
            // Teacher dashboard
            ?>
            <div class="rc_col rc_col_classes">
                <?php include(__DIR__."/rec/dash/teacher/classes.php"); ?>
            </div>
        
            <div class="rc_col rc_col_quiz">
                <?php include(__DIR__."/rec/dash/teacher/quizzes.php"); ?>
            </div>

            <div class="rc_col rc_col_students" id="students-col">
                <?php include(__DIR__."/rec/dash/teacher/students.php"); ?>
            </div>
            <?php 
        }
        else
        {
            // Student dashboard
            ?>
            
            <div style="width:100%;display:flex;justify-content:center;">
                <div class="rc_col rc_col_homework" id="homework-col">
                    <?php include(__DIR__."/rec/dash/student/homework.php"); ?>
                </div>
            </div>

            <link rel="stylesheet" href="assets/css/res/student/records.css">

            <?php
        }

        ?>
    </div>
</div>