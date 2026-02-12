$(document).ready(function()
{
    function load_tbl_btn_fnctnlty()
    {
        get_num_of_questions(function(response)
        {
            var num_of_questions = parseInt(response);
            
            for(var i = 1; i <= num_of_questions; i++)
            {
                $(".que_rb_recycle_"+i).click(function()
                {
                    var que_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/quiz-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'recycle_que', 
                                que_id: que_id 
                            }, 
                            success: function(response)
                            {
                                showGreenAlert("השאלה שוחזרה בהצלחה");
                                reload_que_rb_table();
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה בשיחזור השאלה");
                            }
                        });
                });
            }
        });
    }

    load_tbl_btn_fnctnlty();

    function reload_que_rb_table()
    {
        que_rb();
    }
});