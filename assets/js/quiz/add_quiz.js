$(document).ready(function()
{
    var table_element = $("#quizzes_table");

    $("#add_quiz_form").submit(function(e)
    {
        e.preventDefault();
        var quiz_name_type = $("#new_quiz_name").val();
        var course_id = $("#select_course").val();
        var formOK = false;
        
        if(quiz_name_type != "")
        {
            formOK = true;
        }
        else if(course_id == "")
        {
            formOK = false;
        }
        
        if(formOK)
        {
            $.ajax(
                {
                    url: 'action/quiz-action.php', 
                    type: 'GET', 
                    data: 
                    { 
                        action: 'add_quiz_upload_new_quiz', 
                        quiz_name: quiz_name_type, 
                        course_id: course_id
                    }, 
                    success: function(response)
                    {
                        if(response == '11')
                        {
                            showRedAlert("שגיאת SQL.");
                        }
                        else
                        {
                            showGreenAlert("השאלון עלה בהצלחה!");
                            $("#new_quiz_name").val("");
                        }
                        add_quiz_load_quizzes_list();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בהעלאת השאלון.");
                        add_quiz_load_quizzes_list();
                    }
                });
        }
        else
        {
            showRedAlert("איך לקרוא לשאלון?");
        }

        refresh_quiz_table();
    });

    window.refresh_quiz_table = function()
    {
        load_quizzes_table(function(response)
        {
            table_element.html(response);
            load_quiz_tbl_btns_fnctnlty();
        });
    }

    $("#create_quiz_button").click(function()
    {
        refresh_quiz_table();
    });

    function load_quizzes_table(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_quizzes_table'
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הטבלה");
                }
            });
    }

    function save_qt_data(quiz_id, quiz_name_field, quiz_course, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'save_qt_data', 
                    quiz_id: quiz_id, 
                    quiz_name_field: quiz_name_field, 
                    quiz_course: quiz_course 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בשמירת הנתונים");
                }
            });
    }

    function get_quiz_course(quiz_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_quiz_course', 
                    quiz_id: quiz_id
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

    function get_qt_edit_crs_list(callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_qt_edit_crs_list' 
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

    function load_quiz_tbl_btns_fnctnlty()
    {
        get_num_of_quizzes(function(response)
        {
            var num_of_quizzes = parseInt(response);
            for(var i = 0; i <= num_of_quizzes; i++)
            {
                $(".quizt_edit_"+i).click(function()
                {
                    var my_id = $(this).attr("id");
                    get_quiz_name_by_id(my_id, function(response)
                    {
                        var quiz_name_value = response;
                        $(".quizt_col_quiz_name_"+my_id).html('<input type="text" id="qt_quiz_name_field_' + my_id + '" class="qt_fields" value="' + quiz_name_value + '">');
                    });
                    get_qt_edit_crs_list((res2) => 
                    {
                        $(".qt_crs_col_"+my_id).html(res2);
                        get_quiz_course(my_id, (res) => 
                        {
                            $(".qt_crs_col_"+my_id+" #edit_quiz_select_course").val(res);
                        });
                    });
                    
                    $(".qt_edit_btn_fill_"+my_id).html('<span class="qt_save_btn qt_save_btn_' + my_id + '">שמירה</span>');

                    $(".qt_save_btn_"+my_id).click(function()
                    {
                        var quiz_name_field = $("#qt_quiz_name_field_"+my_id).val();
                        var quiz_course = $(".qt_crs_col_" + my_id + " #edit_quiz_select_course").val();
                        save_qt_data(my_id, quiz_name_field, quiz_course, function(response)
                        {
                            if(response == 1)
                            {
                                showGreenAlert("הנתונים עודכנו בהצלחה");
                                load_quizzes_table(function(response)
                                {
                                    table_element.html(response);
                                    load_quiz_tbl_btns_fnctnlty();
                                });
                            }
                            else if(response == 'error')
                            {
                                showRedAlert("שגיאה בשמירת הנתונים");
                            }
                            get_quiz_name_by_id(my_id, function(response)
                            {
                                $(".quizt_col_quiz_name_"+my_id).html(response);
                            });
                        });
                        $(".qt_edit_btn_fill_"+my_id).html('<span class="quizt_edit quizt_edit_' + my_id + '" id="' + my_id + '">עריכה</span>');
                        load_quiz_tbl_btns_fnctnlty();
                    });

                    var edit_pic_text = 'עריכת תמונה';
                    var is_default = false;
                    if($(".quizt_col_quiz_img_"+my_id+" img").attr("src") == 'uploads/quiz_img/default.png')
                    { edit_pic_text = 'הוספת תמונה'; $(".quizt_col_quiz_img_"+my_id).html(""); is_default = true; }
                    else{ edit_pic_text = 'עריכת תמונה' }

                    $(".quizt_col_quiz_img_"+my_id).append("<div class='edit_quiz_img_btn'>" + 
                                                    "<span class='qt_edit_q_pic_btn qt_edit_q_pic_btn_"+my_id+"'>"+edit_pic_text+"</span>" + 
                                                    "<input type='file' id='quiz_img_upload_" + my_id + "' class='quiz_img_upload' style='display: none;'>" + 
                                                    "</div>");
                    
                    
                    $(".qt_edit_q_pic_btn_"+my_id).click(function() {
                        $("#quiz_img_upload_"+my_id).click();
                    });

                    $("#quiz_img_upload_" + my_id).change(function() 
                    {
                        var fileInput = this;
                        if (fileInput.files.length > 0) 
                        {
                            var formData = new FormData();
                            formData.append("quiz_img", fileInput.files[0]);
                            formData.append("quiz_id", my_id);
                
                            $.ajax({
                                url: "app/actions/upload_quiz_image.php",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) 
                                {
                                    console.log(response);
                                    response = JSON.parse(response);
                                    if (response.status == "success") 
                                    {
                                        showGreenAlert("תמונה הועלתה בהצלחה");
                                        if (!is_default) 
                                        {
                                            $(".quizt_col_quiz_img_" + my_id + " img").attr("src", "uploads/quiz_img/" + response.filename);
                                        } 
                                        else 
                                        {
                                            $(".quizt_col_quiz_img_" + my_id).html('<img src="uploads/quiz_img/' + response.filename + '" class="quiz_table_quiz_img">');
                                        }

                                        $(".edit_quiz_img_btn").remove();
                                    } 
                                    else 
                                    {
                                        showRedAlert("שגיאה בהעלאת התמונה");
                                    }
                                },
                                error: function()
                                {
                                    showRedAlert("שגיאה בהעלאת התמונה");
                                }
                            });
                        }
                    });
                });

                $(".quizt_delete_"+i).click(function()
                {
                    var my_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/quiz-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'qt_delete_quiz', 
                                quiz_id: my_id 
                            }, 
                            success: function(response)
                            {
                                if(response == 1)
                                {
                                    load_quizzes_table(function(response)
                                    {
                                        table_element.html(response);
                                        load_quiz_tbl_btns_fnctnlty();
                                    });
                                    showGreenAlert("השאלון נמחק בהצלחה");
                                }
                                else if(response == 'error')
                                {
                                    showRedAlert("שגיאה במחיקת השאלון");
                                }
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה במחיקת השאלון");
                            }
                        });
                });

                $(".quizt_add_subs_"+i).click(function()
                {
                    var my_id = $(this).attr("id");
                    load_subjects_card(my_id);
                });

                
            }
        });

        setTimeout(() => {
            load_course_names_in_table();
        }, 200);
    }

    load_quizzes_table(function(response)
    {
        table_element.html(response);
        load_quiz_tbl_btns_fnctnlty();
    });

    mark_current_course();

    function quiz_rb()
    {
        $(".quiz_table_fill").html("");
        $("#add_quiz_form").html("");
        $(".quiz_search_fill").html("");
        $(".quiz_tbl_spacer").hide();
        $(".add_quiz_tb h2").text("מיחזור שאלונים שנמחקו");
        $(".quiz_table_fill").load("layout/rec/quiz/quiz_rb.php");

        $(".quiz_rb").text("ניהול שאלונים");
        $(".quiz_rb").off("click");
        $(".quiz_rb").click(function()
        {
            $(".quiz_tab_1").click();
        });
    }

    $(".quiz_rb").click(function()
    {
        quiz_rb();
    });

    function search_quiz(value, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/quiz-action.php",
            data: 
            {
                action: 'search_quiz', 
                value: value
            },
            success: function(response) 
            {
                callback(response);
            }
        });
    }

    $("#quiz_search_value").on("input", function() 
    { 
        var value = $("#quiz_search_value").val();
        
        if(value == '')
        {
            $(".no_res_quiz").text('');
            refresh_quiz_table();
            return;
        }

        search_quiz(value, function(res)
        {
            if(res == '')
            {
                $(".no_res_quiz").text('אין תוצאות לחיפוש שלך. נסה לחפש ערך אחר.');
            }
            else
            {
                $(".no_res_quiz").text('');
                table_element.html(res);
                load_quiz_tbl_btns_fnctnlty();
            }
        });
    });

    function load_course_names_in_table()
    {
        // Find all course name cells in the table (they have class starting with quizt_col_course_name_)
        $("[class*='quizt_col_course_name_']").each(function()
        {
            var course_id = $(this).attr("id");
            if(course_id && course_id != '')
            {
                // get_course_name2 is async and updates the DOM internally
                get_course_name2(course_id);
            }
        });
    }

    $("#quiz_search_form").submit(function(e)
    { 
        e.preventDefault();
    });

    $("#quiz_search_reset").click(function()
    {
        $("#quiz_search_value").val('');
        $(".no_res_quiz").text('');
        refresh_quiz_table();
    });
    
});