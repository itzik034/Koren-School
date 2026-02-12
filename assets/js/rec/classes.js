$(document).ready(function()
{
    function load_edit_funclty()
    {
        get_num_of_classes((res) => 
        {
            for(var i = 1; i <= res; i++)
            {
                $(".edit_class_"+i).click(function()
                {
                    var class_id = $(this).attr("id");
                    edit_class(class_id);
                });

                $(".del_class_"+i).click(function()
                {
                    var class_id = $(this).attr("id");
                    ask_for_del_class(class_id);
                });

                $(".hw_set_"+i).click(function()
                {
                    var class_id = $(this).attr("id");
                    give_homework(class_id);
                });
            }
        });
    }

    function give_homework(class_id)
    {
        $.get("layout/popups/homework.php?class_id="+class_id, (res) => 
        {
            $('body').append('<div class="add_homework_fillll">'+res+'</div>');
        });
    }

    function ask_for_del_class(class_id)
    {
        $.get("layout/popups/del_class.php?class_id="+class_id, (res) => 
        {
            $('body').append('<div class="ask_for_del_class_fillll">'+res+'</div>');
        });
    }

    function load_add_class_btn()
    {
        $("#add_class").click(function()
        {
            $.get("layout/popups/add_class.php", (res) => 
            {
                $('body').append("<div class='add_class_popup_fill'>" + res + "</div>");
            });
        });
    }

    window.remove_add_class_popup = function()
    {
        $(".add_class_popup_fill").remove();
        update_admin_dash_cols();
    }

    function edit_class(class_id)
    {
        show_class_popup(class_id);
    }

    function show_class_popup(class_id)
    {
        $.get("layout/popups/edit_class.php?class_id="+class_id, (res) => 
        {
            $('body').append("<div class='edit_class_popup_fill'>" + res + "</div>");
            $('body').css("overflow-y", "hidden");
            setTimeout(() => {
                $('.ec_popup_fill').append("");
            }, 200);
        });
    }

    window.remove_edit_class_popup = function()
    {
        $(".edit_class_popup_fill").remove();
        get_current_user_rank((res) => 
        {
            if(res == 'a')
            {
                update_admin_dash_cols();
            }
            else if(res == 't')
            {
                update_teacher_dash_cols();
            }
        });
        $('body').css("overflow-y", "auto");
    }


    load_add_class_btn();
    load_edit_funclty();
});