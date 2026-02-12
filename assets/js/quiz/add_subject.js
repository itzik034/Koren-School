$(document).ready(function()
{
    load_subjects_table(function()
    {
        load_quiz_names_in_table();
        load_edit_buttons_functionality_in_table();
    });

    $("#add_subject_form").submit(function(e)
    {
        e.preventDefault();
        var sub_name_type = $("#new_subject_name").val();
        var quiz_type = $("#select_quiz").val();
        var bin_count_type = $("#select_bins").val();
        var formOK = false;

        if(sub_name_type != "")
        {
            formOK = true;
        }
        else if(quiz_type == "")
        {
            formOK = false;
        }
        else if(bin_count_type == "")
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
                        action: 'add_subject_upload_new_subject', 
                        sub_name: sub_name_type, 
                        quiz_id: quiz_type, 
                        bin_num: bin_count_type
                    }, 
                    success: function(response)
                    {
                        if(response == '11')
                        {
                            showRedAlert("שגיאת SQL.");
                        }
                        else
                        {
                            showGreenAlert("הנושא הועלה בהצלחה!");
                            $("#new_subject_name").val("");
                            load_subjects_table(function()
                            {
                                load_quiz_names_in_table();
                                load_edit_buttons_functionality_in_table();
                            });
                        }
                        //add_subject_load_subjects_list();
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בהעלאת הנושא.");
                        //add_subject_load_subjects_list();
                    }
                });
        }
        else
        {
            showRedAlert("איך לקרוא לנושא?");
        }
    });

    function save_edit_sub_data(sub_id, sub_name, quiz_id, bin_count, sub_txt, sub_img, sub_video)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'save_edit_sub_data', 
                    sub_id: sub_id, 
                    sub_name: sub_name, 
                    quiz_id: quiz_id, 
                    bin_count: bin_count, 
                    sub_txt: sub_txt, 
                    sub_img: sub_img, 
                    sub_video: sub_video 
                }, 
                success: function(response)
                {
                    showGreenAlert("הנתונים עודכנו בהצלחה");
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בשמירת הנתונים");
                }
            });
    }

    function load_edit_sub_data1(sub_id)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_edit_sub_data1', 
                    sub_id: sub_id
                }, 
                success: function(response)
                {
                    var sub_name_field = $("#edit_sub_sub_name_field_"+sub_id);
                    var quiz_id_field = $("#edit_sub_quiz_name_field_"+sub_id);
                    var bin_count_field = $("#edit_sub_bin_count_"+sub_id);

                    sub_name_field.val(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הנתונים");
                }
            });
    }

    function load_edit_sub_data2(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_edit_sub_data2', 
                    sub_id: sub_id
                }, 
                success: function(response)
                {
                    var sub_name_field = $("#edit_sub_sub_name_field_"+sub_id);
                    var quiz_id_field = $("#edit_sub_quiz_name_field_"+sub_id);
                    var bin_count_field = $("#edit_sub_bin_count_"+sub_id);

                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הנתונים");
                }
            });
    }

    function load_edit_sub_data3(sub_id)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_edit_sub_data3', 
                    sub_id: sub_id
                }, 
                success: function(response)
                {
                    var sub_name_field = $("#edit_sub_sub_name_field_"+sub_id);
                    var quiz_id_field = $("#edit_sub_quiz_name_field_"+sub_id);
                    var bin_count_field = $("#edit_sub_bin_count_"+sub_id);

                    bin_count_field.val(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הנתונים");
                }
            });
    }

    function edit_sub_load_quizzes(callback)
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

    function edit_sub_load_sub_text(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'edit_sub_load_sub_text', 
                    sub_id: sub_id 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שם הנושא");
                }
            });
    }

    function edit_sub_load_quiz_text(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'edit_sub_load_quiz_text', 
                    sub_id: sub_id 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שם השאלון");
                }
            });
    }

    function edit_sub_load_bin_text(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'edit_sub_load_bin_text', 
                    sub_id: sub_id 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת כמות הבינים");
                }
            });
    }

    function get_quiz_name_by_id2(quiz_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_quiz_name_by_id', 
                    quiz_id: quiz_id
                }, 
                success: function(response2)
                {
                    callback(response2);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת שם השאלון");
                    callback(quiz_id);
                }
            });
    }

    function load_form_data_4(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_esub_txt', 
                    sub_id: sub_id
                }, 
                success: function(response2)
                {
                    callback(response2);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת ההסבר המילולי");
                }
            });
    }

    function load_form_data_5(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_esub_img', 
                    sub_id: sub_id
                }, 
                success: function(response2)
                {
                    callback(response2);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת התמונה");
                }
            });
    }

    function load_form_data_6(sub_id, callback)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'load_esub_vid', 
                    sub_id: sub_id
                }, 
                success: function(response2)
                {
                    callback(response2);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בטעינת הסרטון");
                }
            });
    }

    function load_edit_buttons_functionality_in_table()
    {
        get_num_of_subjects(function(response)
        {
            var num_of_subs = parseInt(response);
            for(var i = 0; i <= num_of_subs; i++)
            {
                $(".sub_edit_button_"+i).addClass("sub_edit");
                $(".sub_edit_button_"+i).removeClass("sub_edit_disabled");
                var edit_button_action = 1;
                $(".sub_edit_button_"+i).click(function()
                {
                    var my_id = $(this).attr("id");

                    if(edit_button_action === 1)
                    {
                        var sub_name_element = $("#col_sub_name_"+my_id);
                        var quiz_name_element = $("#col_quiz_name_"+my_id);
                        var bin_count_element = $("#col_bin_count_"+my_id);
                        var txt_element = $("#col_text_"+my_id);
                        var img_element = $("#col_img_"+my_id);
                        var vid_element = $("#col_vid_"+my_id);
                        sub_name_element.html('<input type="text" ' + 
                                                'id="edit_sub_sub_name_field_' + my_id + '" ' + 
                                                'placeholder="שם הנושא" ' + 
                                                'class="edit_sub_fields" ' + 
                                                'value="">');
                        quiz_name_element.html('<div class="edit_subject_select_quiz_fill">' + 
                                                '<select name="edit_sub_select_quiz" class="edit_sub_select_quiz" id="edit_sub_select_quiz_' + my_id + '">' + 
                                                '<option>טוען רשימת שאלונים...</option>' + 
                                                '</select>' + 
                                                '</div>');
                        bin_count_element.html('<select class="edit_sub_fields" ' + 
                                                'id="edit_sub_bin_count_' + my_id + '">' + 
                                                '<option value="1">1</option>' + 
                                                '<option value="2">2</option>' + 
                                                '<option value="3">3</option>' + 
                                                '<option value="4">4</option>' + 
                                                '<option value="5">5</option>' + 
                                                '<option value="6">6</option>' + 
                                                '<option value="7">7</option>' + 
                                                '<option value="8">8</option>' + 
                                                '<option value="9">9</option>' + 
                                                '<option value="10">10</option>' + 
                                                '</select>');
                        txt_element.html('<input type="text" ' + 
                                         'id="edit_sub_txt_' + my_id + '" ' + 
                                         'placeholder="הסבר מילולי" ' + 
                                         'class="edit_sub_fields" ' + 
                                         'value="">');
                        img_element.html('<input type="text" ' + 
                                         'id="edit_sub_img_' + my_id + '" ' + 
                                         'placeholder="לינק לתמונה" ' + 
                                         'class="edit_sub_fields" ' + 
                                         'value="">');
                        vid_element.html('<input type="text" ' + 
                                         'id="edit_sub_vid_' + my_id + '" ' + 
                                         'placeholder="iFrame של סרטון" ' + 
                                         'class="edit_sub_fields" ' + 
                                         'value="">');
                        load_edit_sub_data1(my_id);
                        load_edit_sub_data3(my_id);
                        load_form_data_4(my_id, function(res)
                        {
                            $("#edit_sub_txt_"+my_id).val(res);
                        });
                        load_form_data_5(my_id, function(res)
                        {
                            $("#edit_sub_img_"+my_id).val(res);
                        });
                        load_form_data_6(my_id, function(res)
                        {
                            $("#edit_sub_vid_"+my_id).val(res);
                        });
                        edit_sub_load_quizzes(function(response)
                        {
                            $("#edit_sub_select_quiz_"+my_id).html(response);
                            load_edit_sub_data2(my_id, function(response)
                            {
                                $("#edit_sub_select_quiz_"+my_id).val(response).prop("selected", true);
                            });
                        });

                        $(".edit_button_fill_"+my_id).html('<span ' + 
                                                           'id="' + my_id + '" ' + 
                                                           'class="sub_save_button sub_save_button_' + my_id + 
                                                           '">' + 
                                                           'שמירה' + 
                                                           '</span>');

                        $(".sub_save_button_"+my_id).click(function()
                        {
                            var sub_name = $("#edit_sub_sub_name_field_"+my_id).val();
                            var quiz_id = $("#edit_sub_select_quiz_"+my_id+" option:selected").val();
                            var bin_count = $("#edit_sub_bin_count_"+my_id+" option:selected").val();
                            var sub_txt = $("#edit_sub_txt_"+my_id).val();
                            var sub_img = $("#edit_sub_img_"+my_id).val();
                            var sub_video = $("#edit_sub_vid_"+my_id).val();
                            save_edit_sub_data(my_id, sub_name, quiz_id, bin_count, sub_txt, sub_img, sub_video);
                            $(".edit_button_fill_"+my_id).html('<span ' + 
                                                           'id="' + my_id + '" ' + 
                                                           'class="sub_edit sub_edit_button_' + my_id + 
                                                           '">' + 
                                                           'עריכה' + 
                                                           '</span>');
                            sub_name_element.html('');
                            edit_sub_load_sub_text(my_id, function(response)
                            {
                                sub_name_element.html(response);
                            });
                            quiz_name_element.html('');
                            edit_sub_load_quiz_text(my_id, function(response)
                            {
                                quiz_name_element.html(response);
                                get_quiz_name_by_id2(response, function(response2)
                                {
                                    quiz_name_element.html(response2);
                                });
                            });
                            bin_count_element.html('');
                            edit_sub_load_bin_text(my_id, function(response)
                            {
                                bin_count_element.html(response);
                            });
                            load_form_data_4(my_id, function(res)
                            {
                                txt_element.html(res);
                            });
                            load_form_data_5(my_id, function(res)
                            {
                                img_element.html("<img src='" + res + "' class='sutbl_img' />");
                            });
                            load_form_data_6(my_id, function(res)
                            {
                                vid_element.html(res);
                            });
                            load_edit_buttons_functionality_in_table();
                        });
                    }
                    
                    
                });
                
                $(".sub_add_que_"+i).click(function()
                {
                    var my_id = $(this).attr("id");
                    load_ques_and_ans_card('', function(response){}, my_id);
                });

                $(".sub_delete_"+i).click(function()
                {
                    var my_id = $(this).attr("id");
                    $.ajax(
                        {
                            url: 'action/quiz-action.php', 
                            type: 'GET', 
                            data: 
                            { 
                                action: 'st_delete_sub', 
                                sub_id: my_id
                            }, 
                            success: function(response)
                            {
                                if(response == 1)
                                {
                                    showGreenAlert("הנושא נמחק בהצלחה");
                                }
                                else if(response == 'error')
                                {
                                    showRedAlert("שגיאה במחיקת הנושא");
                                }

                                load_subjects_table(function()
                                {
                                    load_quiz_names_in_table();
                                    load_edit_buttons_functionality_in_table();
                                });
                            }, 
                            error: function(xhr, status, err)
                            {
                                showRedAlert("שגיאה במחיקת הנושא");
                            }
                        });
                });

            }
        });
    }

    function load_quiz_names_in_table()
    {
        get_num_of_quizzes(function(response)
        {
            var num_of_qu = parseInt(response);
            for(var i = 0; i <= num_of_qu; i++)
            {
                var quiz_name = get_quiz_name_by_id(i);
                $(".quiz_id_"+i).text(quiz_name);
            }
        });
    }

    function search_sub(value, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/quiz-action.php",
            data: 
            {
                action: 'search_sub', 
                value: value
            },
            success: function(response) 
            {
                callback(response);
            }
        });
    }

    $("#sub_search_value").on("input", function() 
    { 
        var value = $("#sub_search_value").val();
        
        if(value == '')
        {
            $(".no_res_s").text('');
            return;
        }

        search_sub(value, function(res)
        {
            if(res == '')
            {
                $(".no_res_s").text('אין תוצאות לחיפוש שלך. נסה לחפש ערך אחר.');
            }
            else
            {
                $(".no_res_s").text('');
                $("#subs_table").html(res);
                load_edit_buttons_functionality_in_table();
            }
        });
    });

    $("#sub_search_form").submit(function(e)
    { 
        e.preventDefault();
    });

    $("#sub_search_reset").click(function()
    {
        $("#sub_search_value").val('');
        $(".no_res_s").text('');
        load_subjects_table(function()
        {
            load_quiz_names_in_table();
            load_edit_buttons_functionality_in_table();
        });
    });

    window.subject_rb = function()
    {
        $("#subs_table").html("");
        $(".sub_search_fill").html("");
        $(".add_subject_form_fill").html("");
        $(".sub_tbl_spacer").hide();
        $(".add_subject_tb h2").text("מיחזור נושאים שנמחקו");
        $(".add_subject_form_fill").load("layout/rec/quiz/sub_rb.php");
        $(".add_subject_form_fill").css(
            {
                'display': 'flex', 
                'align-items': 'center', 
                'justify-content': 'center'
            });
        $(".subjects_rb").text("ניהול נושאים");
        $(".subjects_rb").off("click");
        $(".subjects_rb").click(function()
        {
            $(".quiz_tab_2").click();
        });
    }

    $(".subjects_rb").click(function()
    {
        subject_rb();
    });


});