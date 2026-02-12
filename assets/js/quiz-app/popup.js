$(document).ready(function() 
{
    window.run_quiz = function(quiz_id)
    {
        load_quiz(quiz_id);
        open_quiz_popup();
    }

    window.open_quiz_popup = function()
    {
        $(".qa_back").css("top", "0");
        $(".qa_back").css("display", "flex");
        $(".qa_back").show();
        $("body").css("overflow-y", "hidden");
    }

    window.close_quiz_popup = function()
    {
        $(".qa_back").css("top", "-10000");
        $(".qa_back").css("display", "none");
        $(".qa_back").hide();
        $("body").css("overflow-y", "auto");
        load_run_quiz_btn_funct();
        get_user_rank((rank) => 
        {
            if(rank == 'a'){ update_admin_dash_cols(); }
            if(rank == 't'){ update_teacher_dash_cols(); }
            if(rank == 's'){ update_student_dash_cols(); }
        });
    }

    window.apply_responsive_styles = function()
    {
        return;

        var windowWidth = $(window).width();

        if(windowWidth < 1200 && windowWidth > 680)
        {
            $(".qa_fill").css(
                {
                    'width': '90%', 
                    'height': '95vh'
                });
            
            $(".qa_fl2").css({"width": "550px"});
        }
        else if(windowWidth < 680)
        {
            $(".qa_fill").css(
                {
                    'width': '95%', 
                    'height': '95vh'
                });
            
            $(".qa_fl2").css({"width": "90%"});
        }
        else
        {
            $(".qa_fill").css(
                {
                    'width': '60%', 
                    'height': '95vh'
                });
            
            $(".qa_fl2").css({"width": "450px"});
        }
    }

    setTimeout(() => {
        apply_responsive_styles();
    }, 1000);

    $(window).resize(function()
    { 
        apply_responsive_styles();
    });

});