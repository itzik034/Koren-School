$(document).ready(function()
{
    function showQuizPopup()
    {
        $(".add_quiz_popup_fill").css("top", "0");
        $(".add_quiz_popup_fill").css("display", "flex");
        $(".quiz_tab_1").click();
        $("body").css("overflow-y", "hidden");
    }

    window.closeQuizPopup = function()
    {
        $(".add_quiz_popup_fill").css("top", "-10000");
        $(".add_quiz_popup_fill").css("display", "none");
        $("body").css("overflow-y", "auto");
        $(".add_quiz_popup_fill").remove();
        update_admin_dash_cols();
    }

    window.load_add_quiz_btn = function()
    {
        $("#add_quiz").click(function()
        {
            showQuizPopup();
        });
    }

    load_add_quiz_btn();

    $("#close_quiz_popup_btn").click(function()
    {
        closeQuizPopup();
    });

    var tab_ajax_counter = 0;

    if(tab_ajax_counter === 0)
    {
        tab_ajax_counter++;

        $(".quiz_tab_1").click(function()
        {
            $.ajax(
                {
                    url: 'layout/rec/quiz/add_quiz.php',
                    type: 'GET',
                    data: {  },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").addClass("quiz_tab_choosed");
                        $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_4").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_6").removeClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        add_quiz_update_course_list();
                        add_quiz_load_quizzes_list();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        });

        window.load_subjects_card = function(quiz_id=0)
        {
            var quiz_id_to_send = '';
            if(quiz_id != 0)
            {
                quiz_id_to_send = quiz_id;
            }
            $.ajax(
                {
                    url: 'layout/rec/quiz/add_subject.php',
                    type: 'GET',
                    data: { quiz_id: quiz_id_to_send },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_2").addClass("quiz_tab_choosed");
                        $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_4").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_6").removeClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        add_subject_load_quizzes_list();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        }

        $(".quiz_tab_2").click(function()
        {
            load_subjects_card();
        });

        $(".quiz_tab_3").click(function()
        {
            $.ajax(
                {
                    url: 'layout/rec/quiz/add_question.php',
                    type: 'GET',
                    data: {  },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_3").addClass("quiz_tab_choosed");
                        $(".quiz_tab_4").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_6").removeClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        update_the_bins_list('1');
                        add_que_load_quiz_list();
                        add_que_load_subs_list();
                        add_que_load_ques_list();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        });

        window.get_quiz_id_by_sub_id = function(sub_id, callback)
        {
            $.ajax(
                {
                    url: 'action/quiz-action.php', 
                    type: 'GET', 
                    data: 
                    { 
                        action: 'get_quiz_id_by_sub_id', 
                        sub_id: sub_id 
                    }, 
                    success: function(response) 
                    {
                        callback(response);
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בקבלת פרטי השאלון");
                    }
                });
        }

        window.get_sub_by_que_id = function(que_id, callback)
        {
            $.ajax(
                {
                    url: 'action/quiz-action.php', 
                    type: 'GET', 
                    data: 
                    { 
                        action: 'get_sub_by_que_id', 
                        que_id: que_id 
                    }, 
                    success: function(response) 
                    {
                        callback(response);
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בקבלת פרטי השאלון");
                    }
                });
        }

        window.load_ques_and_ans_card = function(que_id, callback=function(){}, sub_id) 
        {
            $.ajax(
                {
                    url: 'layout/rec/quiz/add_answear.php',
                    type: 'GET',
                    data: { que_id: que_id, sub_id: sub_id },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_4").addClass("quiz_tab_choosed");
                        $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_6").removeClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        add_ans_update_ques_list(function(response)
                        {
                            $("#select_quest").html(response);
                        });
                        add_que_load_quiz_list();
                        add_que_load_subs_list(function()
                        {
                            var sub_id = $("#select-sub").val();
                            update_the_bins_list(sub_id);
                        });
                        add_que_load_ques_list();
                        callback();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        }

        
        $(".quiz_tab_4").click(function()
        {
            load_ques_and_ans_card('', function(){}, '');
        });

        $(".quiz_tab_5").click(function()
        {
            $.ajax(
                {
                    url: 'layout/rec/quiz/upload_excel.php',
                    type: 'GET',
                    data: {  },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_4").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_5").addClass("quiz_tab_choosed");
                        $(".quiz_tab_6").removeClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        });

        $(".quiz_tab_6").click(function()
        {
            $.ajax(
                {
                    url: 'layout/rec/quiz/upload_sub_excel.php',
                    type: 'GET',
                    data: {  },
                    success: function(response) 
                    {
                        $("#quiz_popup_current_tab_content").html(response);
                        $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_4").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                        $(".quiz_tab_6").addClass("quiz_tab_choosed");
                        tab_ajax_counter--;
                        
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בטעינת הטאב");
                        tab_ajax_counter--;
                    }
                });
        });


    }

    window.update_the_bins_list = function(sub_id, callback=function(){})
    {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: { action: 'update_bin_list', sub_id: sub_id },
                success: function(response) 
                {
                    $("#select_bin").html(response);
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הבינים.");
                }
            });
    }

    function add_quiz_update_course_list()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_quiz_update_course_list' }, 
                success: function(response)
                {
                    $("#select_course").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הקורסים.");
                }
            });
    }

    window.get_bin_by_que = function(que_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_bin_by_que', 
                    que_id: que_id 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בבחירת הבין");
                }
            });
    }

    window.add_quiz_load_quizzes_list = function()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_quiz_load_quizzes_list' }, 
                success: function(response)
                {
                    $(".add_quiz_list").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלונים.");
                }
            });
    }

    window.add_subject_load_quizzes_list = function()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_subject_load_quizzes_list' }, 
                success: function(response)
                {
                    $(".new_subject_select_quiz_fill #select_quiz").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלונים.");
                }
            });
    }

    window.load_all_quizzes_list = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_subject_load_quizzes_list' }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלונים.");
                }
            });
    }

    window.add_subject_load_subjects_list = function()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_subject_load_subjects_list' }, 
                success: function(response)
                {
                    $(".add_subject_list").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הנושאים.");
                }
            });
    }

    function add_que_load_quiz_list()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_subject_load_quizzes_list' }, 
                success: function(response)
                {
                    $(".new_question_select_quiz_fill #select_quiz").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלונים.");
                }
            });
    }

    window.add_que_load_subs_list = function(callback=function(){})
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_que_load_subs_list' }, 
                success: function(response)
                {
                    $(".new_question_select_sub_fill #select-sub").html(response);
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הנושאים.");
                }
            });
    }

    window.load_subs_list = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_que_load_subs_list' }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הנושאים.");
                }
            });
    }

    window.load_subs_list_by_quiz_id = function(quiz_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_subs_list_by_quiz_id', 
                    quiz_id: quiz_id
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת הנושאים.");
                }
            });
    }

    window.add_que_load_ques_list = function()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_que_load_ques_list' }, 
                success: function(response)
                {
                    $(".add_question_list").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלות.");
                }
            });
    }

    window.load_que_list_by_sub = function(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_que_list_by_sub', 
                    sub_id: sub_id 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלות.");
                }
            });
    }
    
    window.load_que_list_by_bin = function(sub_id, bin, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_que_list_by_bin', 
                    sub_id: sub_id, 
                    bin: bin 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלות.");
                }
            });
    }
    
    window.add_ans_update_ques_list = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_ans_update_ques_list' }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת השאלות.");
                }
            });
    }

    window.add_ans_load_ans_list = function()
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'add_ans_load_ans_list' }, 
                success: function(response)
                {
                    $(".add_answear_list").html(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת רשימת התשובות.");
                }
            });
    }

    window.get_num_of_courses3 = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_num_of_courses' 
                }, 
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

    window.get_num_of_courses = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_num_of_courses' 
                }, 
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

    window.get_course_name_by_id = function(course_id, callback=()=>{}, i=0)
    {
        var course_name = '';
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_course_name_by_id', 
                    course_id: course_id 
                }, 
                success: function(response)
                {
                    course_name = response;
                    $(".quizt_col_course_name_"+i).text(response);
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שמות הקורסים");
                }
            });
        return course_name;
    }

    window.get_course_name2 = function(course_id)
    {
        var course_name = '';
        if(course_id == '' || typeof(course_id) == 'undefined'){ return; }
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_course_name_by_id3', 
                    course_id: course_id
                }, 
                success: function(response)
                {
                    $(".qt_course_id_"+course_id).text(response);
                    course_name = response;
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שמות הקורסים");
                }
            });
        return course_name;
    }

    window.get_quiz_name_by_id = function(quiz_id, callback=function(){})
    {
        var quiz_name = '';
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_quiz_name_by_id', 
                    quiz_id: quiz_id
                }, 
                success: function(response)
                {
                    quiz_name = response;
                    $(".quiz_id_"+quiz_id).text(response);
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שמות השאלונים");
                }
            });
        return quiz_name;
    }

    window.get_quiz_name_by_id2 = function(quiz_id, callback)
    {
        var quiz_name = '';
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_quiz_name_by_id', 
                    quiz_id: quiz_id
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שמות השאלונים");
                }
            });
        return quiz_name;
    }

    window.get_num_of_subjects = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_num_of_subjects' }, 
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

    window.get_num_of_questions = function(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_num_of_questions' }, 
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

    window.load_subjects_table = function(callback)
    {
        var table_element = $("#subs_table");
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_subjects_table'
                }, 
                success: function(response)
                {
                    table_element.html(response);
                    callback();
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הטבלה");
                }
            });
    }

    window.get_que_text_by_id = function(que_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_que_text_by_id', que_id: que_id }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת השאלה");
                }
            });
    }

    window.get_sub_text_by_id = function(sub_id, callback)
    {
        if(sub_id == '' || typeof(sub_id) == 'undefined'){ return; }
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: { action: 'get_sub_text_by_id', sub_id: sub_id }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הנושא");
                }
            });
    }

    load_run_quiz_btn_funct();

});