$(document).ready(function () 
{
    function load_tbl_btn_fnctnlty()
    {
        get_num_of_courses(function(response)
        {
            var num_of_courses = parseInt(response);
            
            for(var i = 1; i <= num_of_courses; i++)
            {
                $(".course_rb_recycle_"+i).click(function()
                {
                    var course_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/course-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'recycle_course', 
                                course_id: course_id 
                            }, 
                            success: function(response)
                            {
                                if(response == '1')
                                {
                                    showGreenAlert("הקורס שוחזר בהצלחה");
                                }
                                reload_course_rb_table();
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה בשיחזור הקורס");
                            }
                        });
                });
            }
        });
    }

    load_tbl_btn_fnctnlty();

    function reload_course_rb_table()
    {
        $(".course_table_fill").load("layout/rec/course_rb.php");
    }

});