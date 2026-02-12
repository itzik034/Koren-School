$(document).ready(function () 
{
    function load_tbl_btn_fnctnlty()
    {
        get_num_of_subjects(function(response)
        {
            var num_of_subjects = parseInt(response);
            
            for(var i = 1; i <= num_of_subjects; i++)
            {
                $(".subject_rb_recycle_"+i).click(function()
                {
                    var sub_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/quiz-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'recycle_subjects', 
                                sub_id: sub_id 
                            }, 
                            success: function(response)
                            {
                                showGreenAlert("הנושא שוחזר בהצלחה");
                                subject_rb();
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה בשיחזור הנושא");
                            }
                        });
                });
            }
        });
    }

    load_tbl_btn_fnctnlty();
});