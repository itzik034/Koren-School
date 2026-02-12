$(document).ready(function () {
    var que_id_element = $("#select_quest");
    var que_id = que_id_element.val();
    var que_loaded = false;
    var slct_sub_id = 0;
    var slct_bin_id = 0;
    var quiz_element = $("#new_question_select_quiz");
    var sub_element = $("#select-sub");
    var bin_element = $("#select_bin");
    var que_element = $("#select_quest");
    var edit_que_element = $("#mn_edit_que_button");


    update_quiz_list(function (response) {
        quiz_element.html('<option value="0">כל השאלונים</option>');
        quiz_element.append(response);
        $(".que_mang_split_bottom input").attr('disabled', 'disabled');
        $(".que_mang_split_bottom input:text").attr('placeholder', 'יש לבחור שאלון כדי ליצור שאלה');
        $(".que_mang_split_bottom input:submit").css('cursor', 'default');
    });

    load_ques_table();

    /*
    setInterval(function()
    {
        if(!que_loaded && $("#new_answear_0").val() == "")
        {
            que_id = que_id_element.val();
            add_ans_load_ans_fields(que_id);
            add_ans_load_ans_fields_correct(que_id);
            
            get_subject_by_que_id(que_id, function()
            {
                if(slct_sub_id != 0)
                {
                    $("#select-sub option#"+slct_sub_id).prop('selected', true);
                }
                else
                {
                    showRedAlert("שגיאה בטעינת הנושא");
                }
            });
            slct_sub_id = sub_element.val();
            get_bin_by_que_id(que_id, function()
            {
                if(slct_bin_id != 0)
                {
                    update_the_bins_list(slct_sub_id, function()
                    {
                        $("#select_bin option#"+slct_bin_id).prop('selected', true);
                    });
                }
                else
                {
                    showRedAlert("שגיאה בטעינת הבין");
                }
            });
            
            get_quiz_by_que_id(que_id, function(the_quiz_id)
            {
                $("#new_question_select_quiz option#"+the_quiz_id).prop('selected', true);
                load_subs_list_by_quiz_id(the_quiz_id, function(response)
                {
                    sub_element.html(response);
                    var num_of_subs = $('#select-sub option').length;
                    if(num_of_subs == 1 && sub_element.val() == '0')
                    {
                        bin_element.html("<option value='0'>בחר נושא...</option>");
                    }
                    else
                    {
                        update_the_bins_list(sub_element.val());
                    }
                });
            });
            que_loaded = true;
        }
    }, 100);
    */
    $("#add_ans_form").submit(function (e) {
        e.preventDefault();
        var ans0 = $("#new_answear_0").val();
        var ans1 = $("#new_answear_1").val();
        var ans2 = $("#new_answear_2").val();
        var ans3 = $("#new_answear_3").val();
        var ans4 = $("#new_answear_4").val();
        var ans5 = $("#new_answear_5").val();
        var ans6 = $("#new_answear_6").val();
        que_id = que_id_element.val();
        var formOK = false;

        if (ans2 != "" || ans2 == "") { formOK = true; }
        if (ans3 != "" || ans3 == "") { formOK = true; }
        if (ans4 != "" || ans4 == "") { formOK = true; }
        if (ans5 != "" || ans5 == "") { formOK = true; }
        if (ans6 != "" || ans6 == "") { formOK = true; }
        if (ans1 != "") { formOK = true; }
        if (ans0 != "") { formOK = true; }

        else {
            formOK = false;
            showRedAlert("חובה לכתוב תשובה נכונה");
        }

        if (formOK) {
            $.ajax(
                {
                    url: 'action/quiz-action.php',
                    type: 'GET',
                    data: {
                        action: 'add_ans_upload_new',
                        que_id: que_id,
                        ans0: ans0,
                        ans1: ans1,
                        ans2: ans2,
                        ans3: ans3,
                        ans4: ans4,
                        ans5: ans5,
                        ans6: ans6
                    },
                    success: function (response) {
                        if (response == '11') {
                            showRedAlert("שגיאת SQL.");
                        }
                        else if (response == '000' || response == '111' ||
                            response == '222' || response == '333' ||
                            response == '444' || response == '555' ||
                            response == '6666') {
                            showRedAlert('שגיאה');
                        }

                        else {
                            showGreenAlert("התשובות הועלו בהצלחה!");
                        }
                        //add_ans_load_ans_list();
                    },
                    error: function (xhr, status, err) {
                        showRedAlert("שגיאה בהעלאת התשובות");
                        //add_ans_load_ans_list();
                    }
                });
        }
    });

    function add_ans_load_ans_fields(que_id) {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'add_ans_load_ans_fields',
                    que_id: que_id
                },
                success: function (response) {
                    var i = 1;
                    response.forEach(function (item) {
                        $("#new_answear_" + i).val(item);
                        i++;
                    });
                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה במשיכת התשובות מהמסד נתונים");
                }
            });
    }

    function add_ans_load_ans_fields_correct(que_id) {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'add_ans_load_ans_fields_correct',
                    que_id: que_id
                },
                success: function (response) {
                    $("#new_answear_0").val(response);

                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה במשיכת התשובות מהמסד נתונים");
                }
            });
    }

    function get_subject_by_que_id(que_id, callback) {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'get_subject_by_que_id',
                    que_id: que_id
                },
                success: function (response) {
                    slct_sub_id = response;
                    callback();
                },
                error: function (xhr, status, err) {
                    slct_sub_id = 0;
                    callback();
                }
            });
    }

    function get_bin_by_que_id(que_id, callback) {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'get_bin_by_que_id',
                    que_id: que_id
                },
                success: function (response) {
                    slct_bin_id = response;
                    callback();
                },
                error: function (xhr, status, err) {
                    slct_bin_id = 0;
                    callback();
                }
            });
    }

    function get_quiz_by_que_id(que_id, callback) {
        get_sub_by_que_id(que_id, function (response) {
            get_quiz_id_by_sub_id(response, function (response2) {
                callback(response2);
            });
        });
    }

    que_element.change(function () {
        for (var i = 0; i <= 6; i++) {
            $("#new_answear_" + i).val("");
        }
        que_id = $(this).val();
        add_ans_load_ans_fields_correct(que_id);
        add_ans_load_ans_fields(que_id);
        /*
        get_subject_by_que_id(que_id, function()
        {
            if(slct_sub_id != 0)
            {
                $("#select-sub option#"+slct_sub_id).prop('selected', true);
            }
            else
            {
                showRedAlert("שגיאה בטעינת הנושא");
            }
        });
        get_bin_by_que_id(que_id, function()
        {
            if(slct_bin_id != 0)
            {
                update_the_bins_list(slct_sub_id, function()
                {
                    $("#select_bin option#"+slct_bin_id).prop('selected', true);
                });
            }
            else
            {
                showRedAlert("שגיאה בטעינת הבין");
            }
        });

        get_quiz_by_que_id(que_id, function(the_quiz_id)
        {
            $("#new_question_select_quiz option#"+the_quiz_id).prop('selected', true);
        });
        */
    });

    function update_quiz_list(callback) {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'update_quiz_list'
                },
                success: function (response) {
                    callback(response);
                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה בטעינת רשימת השאלונים");
                }
            });
    }

    quiz_element.change(function () {
        sub_element.html("<option value='0'>בחר נושא...</option>");
        bin_element.html("<option value='0'>בחר בין...</option>");
        que_element.html("<option value='0'>אין שאלות בבין זה</option>");
        for (var i = 0; i <= 6; i++) {
            $("#new_answear_" + i).val("");
        }
        var selected_quiz = $(this).val();
        get_quiz_name_by_id2(selected_quiz, function (response) {
            quiz_name = response;
            if (selected_quiz != "0") {
                load_subs_list_by_quiz_id(selected_quiz, function (response) {
                    sub_element.html(response);
                    var num_of_subs = $('#select-sub option').length;
                    if (num_of_subs == 1 && sub_element.val() == '0') {
                        bin_element.html("<option value='0'>בחר נושא...</option>");
                    }

                    else {
                        update_the_bins_list(sub_element.val(), function () {
                            load_que_list_by_bin(sub_element.val(), bin_element.val(), function (response) {
                                que_element.html(response);
                                for (var i = 0; i <= 6; i++) {
                                    $("#new_answear_" + i).val("");
                                }
                                if (response != '<option value="0">אין שאלות בבין זה</option>') {
                                    que_id = que_element.val();
                                    add_ans_load_ans_fields(que_id);
                                    add_ans_load_ans_fields_correct(que_id);
                                }
                            });
                        });
                    }
                });
                $(".que_mang_split_bottom input").removeAttr('disabled');
                $(".que_mang_split_bottom input:text").attr('placeholder', '');
                $(".que_mang_split_bottom input:submit").css('cursor', 'pointer');
            }


            // If the user choosed 'all quizzes'
            else {
                load_subs_list(function (response) {
                    sub_element.html(response);
                    var num_of_subs = $('#select-sub option').length;
                    if (num_of_subs == 1 && sub_element.val() == '0') {
                        bin_element.html("<option value='0'>בחר נושא...</option>");
                        que_element.html("<option value='0'>בחר בין...</option>");
                    }

                    else {
                        update_the_bins_list(sub_element.val(), function () {
                            que_element.html("<option value='0'>בחר בין...</option>");
                        });
                    }
                });
                add_ans_update_ques_list(function (response) {
                    que_element.html(response);
                    add_ans_load_ans_fields(que_element.val());
                    add_ans_load_ans_fields_correct(que_element.val());
                });

                $(".que_mang_split_bottom input").attr('disabled', 'disabled');
                $(".que_mang_split_bottom input:text").attr('placeholder', 'יש לבחור שאלון כדי ליצור שאלה');
                $(".que_mang_split_bottom input:submit").css('cursor', 'default');
            }
        });
    });

    bin_element.change(function () {
        var selected_bin = $(this).val();
        var selected_sub = sub_element.val();
        load_que_list_by_bin(selected_sub, selected_bin, function (response) {
            // Load the questions list for this bin
            que_element.html(response);

            // Empty the answear fields
            for (var i = 0; i <= 6; i++) {
                $("#new_answear_" + i).val("");
            }

            // Set the answears for this question (if exists)
            if (response != '<option value="0">אין שאלות בבין זה</option>') {
                que_id = que_element.val();
                add_ans_load_ans_fields(que_id);
                add_ans_load_ans_fields_correct(que_id);
            }
        });
    });

    sub_element.change(function () {
        var sub_id = $(this).val();
        update_the_bins_list(sub_id, function () {
            var bin = bin_element.val();
            load_que_list_by_bin(sub_id, bin, function (response) {
                que_element.html(response);
                if (response == '<option value="0">אין שאלות בבין זה</option>') {
                    // Empty the answears fields
                    for (var i = 0; i <= 6; i++) {
                        $("#new_answear_" + i).val("");
                    }
                }

                else {
                    que_id = que_element.val();
                    add_ans_load_ans_fields(que_id);
                    add_ans_load_ans_fields_correct(que_id);
                }
            });
        });
    });

    function edit_question(que_id, sub_id, callback) {
        $.ajax(
            {
                url: 'layout/rec/quiz/edit_question.php',
                type: 'GET',
                data: { que_id: que_id, sub_id: sub_id },
                success: function (response) {
                    $(".quiz_tab_1").removeClass("quiz_tab_choosed");
                    $(".quiz_tab_2").removeClass("quiz_tab_choosed");
                    $(".quiz_tab_3").removeClass("quiz_tab_choosed");
                    $(".quiz_tab_4").addClass("quiz_tab_choosed");
                    $(".quiz_tab_4").text("עריכת שאלה");
                    $(".quiz_tab_5").removeClass("quiz_tab_choosed");
                    callback(response);
                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה בעריכת השאלה");
                }
            });
    }

    edit_que_element.click(function () {
        que_id = que_element.val();
        sub_id = sub_element.val();
        edit_question(que_id, sub_id, function (response) {
            $("#quiz_popup_current_tab_content").html(response);
        });
    });

    setTimeout(function () {
        load_que_list_by_bin(sub_element.val(), bin_element.val(), function (response) {
            que_element.html(response);
        });
    }, 500);

    $("#add_que_form").submit(function (e) {
        e.preventDefault();
        var que_content = $("#new_question_name").val();
        var que_quiz = $("#select_quiz").val();
        var que_sub = $("#select-sub").val();
        var que_bin = $("#select_bin").val();
        var formOK = false;

        if (que_content != "") {
            formOK = true;
        }
        else if (que_sub == "") {
            formOK = false;
        }
        else if (que_bin == "") {
            formOK = false;
        }

        if (formOK) {
            $.ajax(
                {
                    url: 'action/quiz-action.php',
                    type: 'GET',
                    data: {
                        action: 'add_que_upload_new',
                        que_content: que_content,
                        que_quiz: que_quiz,
                        que_sub: que_sub,
                        que_bin: que_bin
                    },
                    success: function (response) {
                        if (response == '11') {
                            showRedAlert("שגיאת SQL.");
                        }

                        else {
                            showGreenAlert("השאלה הועלתה בהצלחה!");
                            $("#new_question_name").val("");
                            load_que_list_by_bin(sub_element.val(), bin_element.val(), function (response) {
                                que_element.html(response);
                                $('#select_quest option:contains(' + que_content + ')').prop('selected', true);
                                for (var i = 0; i <= 6; i++) {
                                    $("#new_answear_" + i).val("");
                                }
                            });

                        }
                    },
                    error: function (xhr, status, err) {
                        showRedAlert("שגיאה בהעלאת השאלה.");
                    }
                });
        }

        else {
            showRedAlert("נא למלא את תוכן השאלה.");
        }
    });

    function load_quiz_name_in_ques_table() {
        get_num_of_questions(function (response) {
            var num_of_ques = parseInt(response);
            for (var i = 0; i <= num_of_ques; i++) {
                var sub_id = $(".qet_col qet_col_sub_" + i);
                get_quiz_id_by_sub_id(sub_id, function (response2) {
                    $(".qet_col_quiz_" + i).html('quiz_id: ' + response2);
                });
            }
        });
    }

    function load_subs_names_in_ques_table() {
        get_num_of_questions(function (res) {
            var num_of_ques = parseInt(res);
            for (var i = 1; i <= num_of_ques; i++) {
                (function (index) {
                    var sub_id = $(".qet_col_sub_" + index).text();
                    get_sub_text_by_id(sub_id, function (resp) {
                        $(".qet_col_sub_" + index).text(resp);

                    });
                })(i);
            }
        });
    }

    function load_ques_table() {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'load_ques_table'
                },
                success: function (response) {
                    $("#ques_table").html(response);
                    load_subs_names_in_ques_table();
                    load_btns_fnclty_in_tbl();
                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה בטעינת טבלת השאלות");
                }
            });
    }

    function save_qet_data(que_id, callback) {
        var typed_que_name = $(".qet_edit_que_name_" + que_id).val();
        var typed_sub = $(".qet_edit_slct_sub_" + que_id).val();
        var typed_bin = $(".qet_edit_slct_bin_" + que_id).val();;

        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: {
                    action: 'save_qet_edit_data',
                    que_id: que_id,
                    typed_que_name: typed_que_name,
                    typed_sub: typed_sub,
                    typed_bin: typed_bin
                },
                success: function (response) {
                    callback(response);
                },
                error: function (xhr, status, err) {
                    showRedAlert("שגיאה בטעינת טבלת השאלות");
                }
            });
    }

    function load_btns_fnclty_in_tbl() {
        get_num_of_questions(function (noq1) {
            var noq2 = parseInt(noq1);
            for (var i = 0; i <= noq2; i++) {
                $(".qet_edit_btn_" + i).click(function () {
                    var que_id = $(this).attr("id");
                    var que_text_col = $(".col_que_text_" + que_id);
                    var que_sub_col = $(".qet_col_sub_" + que_id);
                    var que_bin_col = $(".qet_col_bin_" + que_id);
                    var edit_button_fill = $(".que_edt_btn_fill_" + que_id);
                    get_que_text_by_id(que_id, function (res) {
                        que_text_col.html('<input type="text" value="' + res + '" class="qet_edit_fields qet_edit_que_name_' + que_id + '">');
                    });
                    que_sub_col.html('<div class="qet_edit_slct_sub_fill">'
                        + '<select class="qet_edit_fields qet_edit_slct_sub_'
                        + que_id
                        + '">'
                        + '<option val="0" id="0">בחר נושא...</option>'
                        + '</select>'
                        + '</div>');
                    que_bin_col.html('<div class="qet_edit_slct_bin_fill">'
                        + '<select class="qet_edit_fields qet_edit_slct_bin_'
                        + que_id
                        + '">'
                        + '<option val="0" id="0">בחר בין...</option>'
                        + '</select>'
                        + '</div>');

                    edit_button_fill.html('<span '
                        + 'class="qet_edit_save_btn qet_edit_save_btn_'
                        + que_id
                        + '"'
                        + '>'
                        + 'שמירה'
                        + '</span>');

                    add_que_load_subs_list(function (respo) {
                        $(".qet_edit_slct_sub_" + que_id).html(respo);
                        get_sub_by_que_id(que_id, function (re) {
                            $(".qet_edit_slct_sub_" + que_id).val(re);
                        });
                    });

                    get_sub_by_que_id(que_id, function (re) {
                        update_the_bins_list(re, function (response) {
                            $(".qet_edit_slct_bin_" + que_id).html(response);
                            get_bin_by_que(que_id, function (res) {
                                $(".qet_edit_slct_bin_" + que_id).val(res);
                            });
                        });
                    });

                    $(".qet_edit_slct_sub_" + que_id).change(function () {
                        var sub_id = $(this).val();
                        update_the_bins_list(sub_id, function (response) {
                            $(".qet_edit_slct_bin_" + que_id).html(response);
                        });
                    });

                    $(".qet_edit_save_btn_" + que_id).click(function () {
                        save_qet_data(que_id, function (res) {
                            if (res == 1) {
                                showGreenAlert('הנתונים עודכנו בהצלחה');
                            }
                            else if (res == 'error') {
                                showRedAlert("שגיאה בשמירת הנתונים");
                            }
                        });

                        edit_button_fill.html('<span id="'
                            + que_id
                            + '" class="qet_action_span qet_edit_btn qet_edit_btn_'
                            + que_id
                            + '">עריכה</span>');

                        get_que_text_by_id(que_id, function (res) {
                            que_text_col.html(res);
                        });
                        get_sub_by_que_id(que_id, function (res) {
                            get_sub_text_by_id(res, function (res2) {
                                que_sub_col.html(res2);
                            });
                        });
                        get_bin_by_que(que_id, function (res3) {
                            que_bin_col.html(res3);
                        });

                        load_btns_fnclty_in_tbl();
                    });

                });
            }
        });
    }


});
