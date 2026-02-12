$(document).ready(function()
{
    var class_id = $("#class_id").val();

    $(".close_hw_btn").click(function()
    {
        $(".add_homework_fillll").remove();
        update_teacher_dash_cols();
    });

    function load_check_click()
    {
        get_num_of_quizzes((res) => 
        {
            res = parseInt(res);
            for(var i = 0; i <= res; i++)
            {
                $(".hwtc_"+i).click(function()
                {
                    var quiz_id = $(this).attr("id");
                    var my_check = $(".chck_hwtc_"+quiz_id);
                    if(my_check.is(":checked"))
                    {
                        my_check.prop("checked", false);
                    }
                    else
                    {
                        my_check.prop("checked", true);
                    }
                });
            }
        });
    }

    function save_checked_quizzes()
    {
        get_num_of_quizzes((res) => 
        {
            res = parseInt(res);
            for(var i = 1; i <= res; i++)
            {
                var checked = $(".hwtc_"+i+" input[type='checkbox']").prop('checked');
                if(checked)
                {
                    quiz_is_check(class_id, i);
                }
                else
                {
                    quiz_is_not_check(class_id, i);
                }
            }
            showGreenAlert("הרשימה עודכנה בהצלחה!");
            $(".add_homework_fillll").remove();
            update_teacher_dash_cols();
        });
    }

    function quiz_is_check(class_id, quiz_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-action.php",
                data: 
                { 
                    action: 'quiz_is_check', 
                    class_id: class_id, 
                    quiz_id: quiz_id
                },
                success: function(response) {}
            });
    }

    function quiz_is_not_check(class_id, quiz_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-action.php",
                data: 
                { 
                    action: 'quiz_is_not_check', 
                    class_id: class_id, 
                    quiz_id: quiz_id
                },
                success: function(response) {}
            });
    }

    $("#hwtc_update_btn").click(() => 
    {
        save_checked_quizzes();
    });



    load_check_click();
});