$(document).ready(function()
{
    var class_id = $("#class_id").val();
    
    $(".ds_option2").click( () => 
    {
        $(".ask_for_del_class_fillll").remove();
    });

    $(".ds_option1").click( () => 
    {
        del_class(class_id);
    });

    function del_class(class_id)
    {
        $.get("app/actions/quiz-action.php?action=del_class&class_id="+class_id, (res) => 
        {
            if(res == '1')
            {
                showGreenAlert("הכיתה נמחקה בהצלחה");
            }
            else
            {
                showRedAlert("שגיאה במחיקת הכיתה");
            }
            update_admin_dash_cols();
            $(".ask_for_del_class_fillll").remove();
        });
    }
});