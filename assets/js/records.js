$(document).ready(function()
{
    var u_id;

    $("#popup-ok").click(function()
    {
        var t_name = "";
        u_id = $(this).attr("class");
        get_teacher_first_name(u_id, function(tfn)
        {
            t_name += tfn;
            get_teacher_last_name(u_id, function(tln)
            {
                t_name += " ";
                t_name += tln;
                get_user_field(u_id, "rank", function(r)
                { 
                    if(r == 't')
                    {
                        deleteTeacher(u_id);
                    }
                    if(r == 's')
                    {
                        deleteStudent(u_id);
                    }
                });
                
            });
        });
        hidePopup();
    });

    $("#edit-student-form").submit(function(e)
    {
        e.preventDefault();
        var f_first_name = $("#f_st_f_name").val();
        var f_last_name = $("#f_st_l_name").val();
        var f_username = $("#f_st_username").val();
        var f_password = $("#f_st_password").val();
        var f_email = $("#f_st_email").val();
        var f_address = $("#f_st_address").val();
        var f_country = $("#f_st_country").val();
        var f_school = $("#f_st_school").val();
        var f_phone = $("#f_st_phone").val();
        var f_mom = $("#f_st_mom_name").val();
        var f_mom_phone = $("#f_st_mom_phone").val();
        var f_id = $("#f_st_id").val();
        
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: 
                { 
                    action: 'edit-student',  
                    first_name: f_first_name, 
                    last_name: f_last_name, 
                    user_name: f_username, 
                    password: f_password, 
                    email: f_email, 
                    address: f_address, 
                    country: f_country, 
                    school: f_school, 
                    phone: f_phone, 
                    st_mom: f_mom, 
                    st_mom_phone: f_mom_phone, 
                    user_id: f_id, 
                    uid: u_id
                },
                success: function(response) 
                {
                    if(response == "12131")
                    {
                        showGreenAlert("התלמיד עודכן בהצלחה!");
                    }
                    else
                    {
                        showRedAlert("שגיאה בעדכון הנתונים");
                    }
                    update_admin_dash_cols();
                    close_edit_std_popup();
                }
            });
    });

    function close_edit_std_popup()
    {
        $("#popup-edit-student").css("top", "-10000px");
        $("#popup-edit-student").css("opacity", "0");
        $("#popup-es-fill").css("top", "-10000px");
        $("#popup-es-fill").css("opacity", "0");
    }

    window.close_edit_t_popup = function()
    {
        $("#popup-et-fill").css("top", "-10000px");
        $("#popup-et-fill").css("opacity", "0");
        $("#popup-edit-teacher").css("top", "-10000px");
        $("#popup-edit-teacher").css("opacity", "0");
        $('body').css("overflow-y", "auto");
        update_admin_dash_cols();
    }

    $("#close-popup-edit").click(function()
    {
        close_edit_t_popup();
    });

    window.close_edit_s_popup = function()
    {
        $("#popup-es-fill").css("top", "-10000px");
        $("#popup-es-fill").css("opacity", "0");
        $("#popup-edit-student").css("top", "-10000px");
        $("#popup-edit-student").css("opacity", "0");
    }

    $("#close-st-popup-edit").click(function()
    {
        close_edit_s_popup();
    });

    window.load_edit_teacher_btns = function()
    {
        $(".edit-click").off("click");
        $(".edit-click").click(function()
        {
            var t_id4 = $(this).attr('id');
            edit_teacher(t_id4);
            u_id = t_id4;
            load_et_layout(u_id);
        });
    }
    
    load_edit_teacher_btns();

    window.load_et_layout = function(u_id)
    {
        $(".edit_teacher_layout_fill").load("layout/rec/edit_teacher.php?teacher_id="+u_id);
        load_edit_teacher_btns();
    }

    window.load_edit_std_fnc = function()
    {
        $(".edit-click-student").click(function()
        {
            var s_id = $(this).attr('id');
            edit_student(s_id);
            u_id = s_id;
        });
    }

    load_edit_std_fnc();

    $("#popup-cancel").click(function()
    {
        hidePopup();
    });

    $(".delete-teacher").click(function()
    {
        var t_id2 = $(this).attr('id');
        showPopup(t_id2);
    });

    window.load_del_std_func = function()
    {
        $(".delete-student").click(function()
        {
            var s_id1 = $(this).attr('id');
            showPopup(s_id1);
        });
    }

    load_del_std_func();

    $("#add-teacher").click(function()
    {
        $("#popup-window").css("top", "0");
        $("#popup-window").css("opacity", "1");
        $("#popup-new-teacher").css("top", "0");
        $("#popup-new-teacher").css("opacity", "1");

        $("#tch_f_name").val("");
        $("#tch_l_name").val("");
        $("#tch_username").val("");
        $("#tch_password").val("");
        $("#tch_email").val("");
        $("#tch_address").val("");
        $("#tch_country").val("");
        $("#tch_school").val("");
        $("#tch_phone").val("");
        $("#tch_id").val("");
    });

    window.close_add_t_popup = function()
    {
        $("#popup-window").css("top", "-10000px");
        $("#popup-window").css("opacity", "0");
        $("#popup-new-teacher").css("top", "-10000px");
        $("#popup-new-teacher").css("opacity", "0");
    }

    $("#close-popup-fill").click(function()
    {
        close_add_t_popup();
    });

    window.close_add_s_popup = function()
    {
        $("#popup-window").css("top", "-10000px");
        $("#popup-window").css("opacity", "0");
        $("#popup-new-student").css("top", "-10000px");
        $("#popup-new-student").css("opacity", "0");
    }

    $("#close-st-popup").click(function()
    {
        close_add_s_popup();
    });

    $("#add-teacher-form").submit(function(e)
    {
        e.preventDefault();
        var first_name = $("#tch_f_name").val();
        var last_name = $("#tch_l_name").val();
        var username = $("#tch_username").val();
        var password = $("#tch_password").val();
        var email = $("#tch_email").val();
        var address = $("#tch_address").val();
        var country = $("#tch_country").val();
        var school = $("#tch_school").val();
        var phone = $("#tch_phone").val();
        var user_id = $("#tch_id").val();
        
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: 
                { 
                    action: 'add-teacher',  
                    first_name: first_name, 
                    last_name: last_name, 
                    user_name: username, 
                    password: password, 
                    email: email, 
                    address: address, 
                    country: country, 
                    school: school, 
                    phone: phone, 
                    user_id: user_id
                },
                success: function(response) 
                {
                    showGreenAlert("המורה נוסף בהצלחה!");
                    $("#close-popup-fill").click();
                    update_admin_dash_cols();
                }
            });
    });

    $("#alert-close").click(function()
    {
        $("#alert").css("top", "-250vh");
        $("#alert").css("opacity", "0");
    });

    $("#alert-err-close i, #alert-err-close svg").click(function()
    {
        $("#alert-err").css("top", "-250vh");
        $("#alert-err").css("opacity", "0");
    });

    window.load_add_std_func = function()
    {
        $("#add-student").click(function()
        {
            // $("#st_f_name").val("");
            // $("#st_l_name").val("");
            // $("#st_username").val("");
            // $("#st_password").val("");
            // $("#st_email").val("");
            // $("#st_address").val("");
            // $("#st_country").val("");
            // $("#st_school").val("");
            // $("#st_phone").val("");
            // $("#st_mom_name").val("");
            // $("#st_mom_phone").val("");
            // $("#st_id").val("");
            
            // $("#popup-window").css("top", "0");
            // $("#popup-window").css("opacity", "1");
            // $("#popup-new-student").css("top", "0");
            // $("#popup-new-student").css("opacity", "1");

            open_add_std_popup();
        });
    }

    load_add_std_func();

    function open_add_std_popup()
    {
        $.get("layout/popups/add_student.php", (res) => 
        {
            $('body').append('<div class="adst_popup_filll">'+res+'</div>');
        });
    }

    window.get_num_of_users = function(callback)
    {
        $.get("app/actions/action.php?action=get_num_of_users", (res) => { callback(res) });
    }

    function close_add_std_popup()
    {
        $(".adst_popup_filll").remove();
    }
    
    $("#add-student-form").submit(function(e)
    {
        e.preventDefault();
        var first_name = $("#st_f_name").val();
        var last_name = $("#st_l_name").val();
        var username = $("#st_username").val();
        var password = $("#st_password").val();
        var email = $("#st_email").val();
        var address = $("#st_address").val();
        var country = $("#st_country").val();
        var school = $("#st_school").val();
        var phone = $("#st_phone").val();
        var st_mom = $("#st_mom_name").val();
        var st_mom_phone = $("#st_mom_phone").val();
        var user_id = $("#st_id").val();
        
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: 
                { 
                    action: 'add-student',  
                    first_name: first_name, 
                    last_name: last_name, 
                    user_name: username, 
                    password: password, 
                    email: email, 
                    address: address, 
                    country: country, 
                    school: school, 
                    phone: phone, 
                    st_mom: st_mom, 
                    st_mom_phone: st_mom_phone, 
                    user_id: user_id
                },
                success: function(response) 
                {
                    if(response == "321322")
                    {
                        $("#popup-window").css("top", "-10000px");
                        $("#popup-window").css("opacity", "0");
                        $("#popup-new-student").css("top", "-10000px");
                        $("#popup-new-student").css("opacity", "0");
                        showGreenAlert("התלמיד נוסף בהצלחה!");
                        updateStudentsList();
                    }
                }
            });
    });

    $("#cnt").click(function()
    {
        $("#add-teacher-form").submit();
    });

    $("#cnst").click(function()
    {
        $("#add-student-form").submit();
    });

    $("#esu").click(function()
    {
        $("#edit-student-form").submit();
    });

    function load_slct_crs_clk()
    {
        $(".courses_list_fill .slct_crs").click(function()
        {
            var crs_id = $(this).attr("id");
            $(".slct_crs").removeClass("chosen");
            $(".courses_list_fill .slct_crs_"+crs_id).addClass("chosen");
        });
    }

    load_slct_crs_clk();

    function open_add_course_popup()
    {
        $(".popup_add_course_fill").css("top", "0");
        $(".popup_add_course_fill").css("display", "flex");
        $(".popup_add_course_fill").show();
        $("body").css("overflow-y", "hidden");
    }
    
    window.mark_current_course = function()
    {
        get_current_course(function(res)
        {
            if(res != '-1')
            {
                var crs_id = res;
                $(".slct_crs").removeClass("chosen");
                $(".courses_list_fill .slct_crs_"+crs_id).addClass("chosen");
            }
        });
    }

    window.close_add_course_popup = function()
    {
        $(".popup_add_course_fill").css("top", "-10000px");
        $(".popup_add_course_fill").css("display", "none");
        $(".popup_add_course_fill").hide();
        update_courses_in_dash();
        mark_current_course();
    }

    function get_courses_dash(callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/course-action.php",
            data: { action: 'get_courses_dash' },
            success: function(response)
            {
                callback(response);
            }
        });
    }

    window.update_courses_in_dash = function()
    {
        get_courses_dash(function(res)
        {
            $(".courses_list_fill").html(res);
            load_crs_clk();
            load_slct_crs_clk();
        });
    }

    // Update the courses on load
    update_courses_in_dash();

    $("#add_course_btn").click(function()
    {
        open_add_course_popup();
    });

    $(".popup_add_course").load('layout/rec/add_course.php');

    window.get_num_of_courses = function(callback)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/course-action.php",
                data: 
                { 
                    action: 'get_num_of_courses' 
                },
                success: function (response) 
                {
                    callback(response);
                }, 
                error: function(err1, err2, err3)
                {
                    showRedAlert("שגיאה");
                }
            });
    }

    window.set_course = function(course_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/course-action.php",
                data: 
                { 
                    action: 'set_course', 
                    course_id: course_id 
                },
                success: function (response) 
                {
                    if(response != '1')
                    {
                        showRedAlert("שגיאה בהגדרת הקורס");
                    }
                    else
                    {
                        mark_current_course();
                        update_admin_dash_cols();
                    }
                }
            });
    }

    window.update_admin_dash_cols = function()
    {
        get_current_course((current_course) => 
        {
            $.get("layout/rec/cols/quiz.php?course_id="+current_course, (res) => 
            {
                $(".rc_col_quiz").html(res);
                load_add_quiz_btn();
                load_edit_quiz_funclty();
            });

            $.get("layout/rec/cols/teachers.php?course_id="+current_course, (res) => 
            {
                $(".rc_col_teachers").html(res);
                load_add_teacher_btn();
            });

            $.get("layout/rec/cols/students.php?course_id="+current_course, (res) => 
            {
                $(".rc_col_students").html(res);
                load_del_std_func();
                load_edit_std_fnc();
                load_add_std_func();
            });

            $.get("layout/rec/cols/classes.php?course_id="+current_course, (res) => 
            {
                $(".rc_col_classes").html(res);
            });
        });
    }

    function load_add_teacher_btn()
    {
        $("#add-teacher").click(function()
        {
            $("#popup-window").css("top", "0");
            $("#popup-window").css("opacity", "1");
            $("#popup-new-teacher").css("top", "0");
            $("#popup-new-teacher").css("opacity", "1");
    
            $("#tch_f_name").val("");
            $("#tch_l_name").val("");
            $("#tch_username").val("");
            $("#tch_password").val("");
            $("#tch_email").val("");
            $("#tch_address").val("");
            $("#tch_country").val("");
            $("#tch_school").val("");
            $("#tch_phone").val("");
            $("#tch_id").val("");
        });
    }

    window.get_num_of_quizzes = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_num_of_quizzes' }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה");
                }
            });
    }

    window.get_num_of_classes = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_num_of_classes' }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה");
                }
            });
    }

    window.get_current_course = function(callback=()=>{})
    {
        var cur_cour = '';
        $.ajax(
            {
                type: "GET",
                url: "app/actions/course-action.php",
                data: 
                { 
                    action: 'get_current_course'
                },
                success: function (response) 
                {
                    cur_cour = response;
                    callback(response);
                }
            });
        return cur_cour;
    }

    function load_crs_clk()
    {
        get_num_of_courses(function(res)
        {
            var noccc = parseInt(res);
            for(var i = 0; i <= noccc; i++)
            {
                $(".slct_crs_"+i).click(function()
                {
                    var course_id = $(this).attr("id");
                    set_course(course_id);
                });
            }
        });
    }

    // Set 0 as default to show all the content
    set_course("0");

    window.load_run_quiz_btn_funct = function()
    {
        get_num_of_quizzes(function(res)
        {
            var noq = parseInt(res);
            for(var i = 0; i<= noq; i++)
            {
                $(".quiz_ttl_"+i).off("click");
                $(".quiz_ttl_"+i).click(function()
                {
                    var quiz_id = $(this).attr("id");
                    run_quiz(quiz_id);
                });
            }
        });
    }

    load_run_quiz_btn_funct();
    
    setTimeout(() => {
        load_run_quiz_btn_funct();
    }, 500);

    $(".close_quiz_app_btn").click(function()
    {
        close_quiz_popup();
    });

    window.close_homework_popup = function()
    {
        $(".add_homework_fillll").remove();
        update_teacher_dash_cols();
    }

    var enableEscapeKey = true;

    $(document).keydown(function(event) 
    {
        if(event.key === 'Escape' && enableEscapeKey)
        {
            close_quiz_popup();
            close_add_course_popup();
            closeQuizPopup();
            close_edit_t_popup();
            close_add_t_popup();
            close_edit_s_popup();
            close_add_s_popup();
            $(".edit_quiz_popup_append_fill").remove();
            remove_edit_class_popup();
            remove_add_class_popup();
            close_add_student_popup();
            $(".ask_for_quiz_del_fillll").remove();
            hidePopup();
            $(".add_homework_fillll").remove();
            hide_tch_card();
            
            get_user_rank((rank) => 
            {
                if(rank == 'a'){ update_admin_dash_cols(); }
                if(rank == 't'){ update_teacher_dash_cols(); }
            });
        }
    });

    window.setEscapeKeyEnabled = function(enabled)
    {
        enableEscapeKey = enabled;
    }

    window.load_edit_quiz_funclty = function()
    {
        get_num_of_quizzes((noq) => 
        {
            noq = parseInt(noq);
            for(var i = 0; i <= noq; i++)
            {
                // Edit button
                $(".ds_edit_quiz_"+i).off("click");
                $(".ds_edit_quiz_"+i).click(function()
                {
                    var quiz_id = $(this).attr("quiz-id");
                    
                    $.get("layout/popups/edit_quiz.php?quiz_id="+quiz_id, (res) => 
                    {
                        $('body').append('<div class="edit_quiz_popup_append_fill">' + res + '</div>');
                        load_close_eqp_pop_func();
                    });
                });

                // Delete button
                $(".del_quiz_"+i).off("click");
                $(".del_quiz_"+i).click(function()
                {
                    var quiz_id = $(this).attr("id");
                    ask_for_del_quiz(quiz_id);
                });

                // Recover button
                $(".ds_recover_quiz_"+i).off("click");
                $(".ds_recover_quiz_"+i).click(function()
                {
                    var quiz_id = $(this).attr("quiz-id");
                    recover_deleted_quiz(quiz_id);
                });
            }
        });
    }

    function recover_deleted_quiz(quiz_id)
    {
        $.get("layout/popups/recover_quiz.php?quiz_id="+quiz_id, (res) => 
        {
            update_admin_dash_cols();
            showGreenAlert("השאלון שוחזר בהצלחה");
        });
    }

    function ask_for_del_quiz(quiz_id)
    {
        $.get("layout/popups/del_quiz.php?quiz_id="+quiz_id, (res) => 
        {
            $('body').append('<div class="ask_for_quiz_del_fillll">'+res+'</div>');
        });
    }

    window.load_close_eqp_pop_func = function()
    {
        $("#close_eqp_btn").off("click");
        $("#close_eqp_btn").click(function()
        {
            $(".edit_quiz_popup_append_fill").remove();
            update_admin_dash_cols();
        });
    }

    window.close_add_student_popup = function()
    {
        $(".adst_popup_filll").remove();
        update_admin_dash_cols();
    }

    function show_tch_card(tch_id)
    {
        $("body").append("<div class='tch_card_back'></div>");
        $(".tch_card_back").load("layout/popups/teacher_card.php?tch_id="+tch_id);
        $("body").css("overflow", "hidden");
        setTimeout(() => {
            $(".close_tch_card").off("click");
            $(".close_tch_card").click(() => { hide_tch_card() });
        }, 500);
    }

    function tch_card_click()
    {
        $(".tch_profile_pic, .tch_name").off("click");
        $(".tch_profile_pic, .tch_name").click(function()
        {
            var tch_id = $(this).attr("id");
            show_tch_card(tch_id);
        });
    }

    function hide_tch_card()
    {
        $("body").css("overflow", "auto");
        $(".tch_card_back").remove();
        tch_card_click();
    }

    setTimeout(() => {
        load_edit_quiz_funclty();
        tch_card_click();
    }, 500);
});