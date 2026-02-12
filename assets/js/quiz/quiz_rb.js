$(document).ready(function()
{
    function load_tbl_btn_fnctnlty()
    {
        get_num_of_quizzes(function(response)
        {
            var num_of_quizzes = parseInt(response);
            
            for(var i = 1; i <= num_of_quizzes; i++)
            {
                $(".quiz_rb_recycle_"+i).click(function()
                {
                    var quiz_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/quiz-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'recycle_quiz', 
                                quiz_id: quiz_id 
                            }, 
                            success: function(response)
                            {
                                showGreenAlert("השאלון שוחזר בהצלחה");
                                reload_quiz_rb_table();
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה בשיחזור השאלון");
                            }
                        });
                });
            }
        });
    }

    load_tbl_btn_fnctnlty();

    function reload_quiz_rb_table()
    {
        var element = $(".quiz_rb_tbl");
        $.ajax(
            {
                type: "GET",
                url: "app/actions/quiz-action.php",
                data: 
                {
                    action: 'load_quiz_rb_table'
                },
                success: function(response)
                {
                    element.html(response);
                    $(".add_quiz_content").css("overflow-y", "hidden");
                    load_tbl_btn_fnctnlty();
                }, 
                error: function(err1, err2, err3)
                {
                    showRedAlert("שגיאה בטעינת הטבלה");
                }
            });
    }
});