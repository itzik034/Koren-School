$(document).ready(function()
{
    var quiz_id = $("#quiz_id").val();

    function load_quiz_slct(quiz_id)
    {
        get_quiz_course(quiz_id, function(res)
        {
            $("#eqp_select_course").val(res);
        });
    }

    function get_quiz_course(quiz_id, callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-action.php",
                data: 
                { 
                    action: 'get_quiz_course', 
                    quiz_id: quiz_id
                },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    $("#eqp_form").submit(function (e) 
    { 
        e.preventDefault();

        var new_quiz_name = $("#quiz_name_field").val();
        var new_quiz_course = $("#eqp_select_course").val();

        save_qdit_quiz_data(quiz_id, new_quiz_name, new_quiz_course);
    });

    function save_qdit_quiz_data(quiz_id, quiz_name, quiz_course)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/quiz-action.php",
            data: 
            {
                action: 'save_qdit_quiz_data', 
                quiz_id: quiz_id, 
                quiz_name: quiz_name, 
                quiz_course: quiz_course
            },
            success: function (response) 
            {
                if(response == "1")
                {
                    showGreenAlert("הנתונים עודכנו בהצלחה");
                    $("#close_eqp_btn").click();
                }
            }
        });
    }


    load_quiz_slct(quiz_id);
    load_close_eqp_pop_func();
});