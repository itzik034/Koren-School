$(document).ready(function()
{
    var quiz_id = $("#quiz_id").val();
    
    $(".ds_option2").click( () => 
    {
        $(".ask_for_quiz_del_fillll").remove();
    });

    $(".ds_option1").click( () => 
    {
        del_quiz(quiz_id);
    });

    function del_quiz(quiz_id)
    {
        $.get("app/actions/quiz-action.php?action=del_quiz&quiz_id="+quiz_id, (res) => 
        {
            if(res == '1')
            {
                showGreenAlert("השאלון נמחק בהצלחה");
            }
            else
            {
                showRedAlert("שגיאה במחיקת השאלון");
            }
            update_admin_dash_cols();
            $(".ask_for_quiz_del_fillll").remove();
        });
    }
});