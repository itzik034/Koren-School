$(document).ready(function () 
{
    var table_element = $("#course_table");

    load_course_table(function(response)
    {
        table_element.html(response);
        load_btns_fnclty_in_tbl();
    });

    $(".popup_add_course_close_btn").click(function()
    {
        close_add_course_popup();
        $("body").css("overflow-y", "auto");
    });

    $("#add_course_form").submit(function(e) 
    { 
        e.preventDefault();
        var course_name_field = $("#course_name_field").val();
        var course_level_field = $("#create_course_select_level").val();
        var course_level2_field = $("#create_course_select_level2").val();
        if(course_name_field != '')
        {
            create_new_course(course_name_field, course_level_field, course_level2_field, function(res)
            {
                if(res == 1)
                {
                    showGreenAlert("הקורס נוצר בהצלחה!");
                    $("#course_name_field").val("");
                    load_course_table(function(response)
                    {
                        table_element.html(response);
                        load_btns_fnclty_in_tbl();
                    });
                }
                else if(res == 'error')
                {
                    showRedAlert("שגיאה ביצירת הקורס");
                }
                else if(res == 'error2')
                {
                    showRedAlert("רמת התחלה חייבת להיות זהה או גבוהה יותר לרמת סיום.");
                }
            });
        }
        else
        {
            showRedAlert("צריך לתת שם לקורס");
        }
    });

    function load_course_table(callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_course_table' 
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

    function get_num_of_courses(callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
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

    function get_course_name(course_id, callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_course_name_by_id', 
                    course_id: course_id 
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

    function get_course_level(course_id, callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'get_course_level', 
                    course_id: course_id 
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

    function save_ct_data(course_id, course_name_field, level_field, callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'save_ct_data', 
                    course_id: course_id, 
                    course_name_field: course_name_field, 
                    level_field: level_field 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בעדכון הנתונים");
                }
            });
    }

    function create_new_course(course_name, course_level1, course_level2, callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'upload_new_course', 
                    course_name_field: course_name, 
                    course_level1: course_level1, 
                    course_level2: course_level2 
                }, 
                success: function(response)
                {
                    callback(response);
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה ביצירת הקורס");
                }
            });
    }
    
    function load_btns_fnclty_in_tbl()
    {
        // Load button functionallity in the courses table
        get_num_of_courses(function(noc)
        {
            for(var i = 0; i <= noc; i++)
            {
                $(".ct_btn_edit_"+i).click(function()
                {
                    var course_id = $(this).attr("id");

                    var save_btn_html = '<span ' 
                                      + 'class="ct_save_btn ct_save_btn_'
                                      + course_id
                                      + '" '
                                      + 'id="'
                                      + course_id
                                      + '">'
                                      + 'שמירה'
                                      + '</span>';
                    $(".ct_edit_btn_fill_"+course_id).html(save_btn_html);
                    
                    get_course_name(course_id, function(course_name)
                    {
                        var edit_course_field_html = '<input ' 
                                                   + 'type="text" '
                                                   + 'class="basic_field ct_crs_nm_field ct_crs_nm_field_'
                                                   + course_id
                                                   + '" '
                                                   + 'placeholder="שם הקורס" '
                                                   + 'value="'
                                                   + course_name
                                                   + '" '
                                                   + 'id="'
                                                   + course_id
                                                   + '">';
                        
                        $(".ct_col_course_name_"+course_id).html(edit_course_field_html);
                    });

                    get_course_level(course_id, (res) => 
                    {
                        var html = '<select id="edit_course_select_level_' + course_id + '" class="basic_field pointer">' + 
                                        "<option value='1'>כיתה א'</option>" + 
                                        "<option value='2'>כיתה ב'</option>" + 
                                        "<option value='3'>כיתה ג'</option>" + 
                                        "<option value='4'>כיתה ד'</option>" + 
                                        "<option value='5'>כיתה ה'</option>" + 
                                        "<option value='6'>כיתה ו'</option>" + 
                                        "<option value='7'>כיתה ז'</option>" + 
                                        "<option value='8'>כיתה ח'</option>" + 
                                        "<option value='9'>כיתה ט'</option>" + 
                                        "<option value='10'>כיתה י'</option>" + 
                                        '<option value="11">כיתה י"א</option>' + 
                                        '<option value="12">כיתה י"ב</option>' + 
                                    '</select>';
                        
                        $(".ct_col_course_level_"+course_id).html(html);
                        $("#edit_course_select_level_"+course_id).val(res);
                    });

                    $(".ct_save_btn_"+course_id).click(function()
                    {
                        var cn_field = $(".ct_crs_nm_field_"+course_id).val();
                        var lvl_field = $("#edit_course_select_level_"+course_id).val();
                        save_ct_data(course_id, cn_field, lvl_field, function()
                        {
                            get_course_name(course_id, function(course_name)
                            {
                                $(".ct_col_course_name_"+course_id).html(course_name);
                            });
                            get_course_level(course_id, (course_level) => 
                            {
                                var level_name = get_level_name(course_level);
                                $(".ct_col_course_level_"+course_id).html(level_name);
                            });
                            var edit_btn_html = '<span class="ct_btn_edit ct_btn_edit_'+course_id+'" id="'+course_id+'">עריכה</span>';
                            $(".ct_edit_btn_fill_"+course_id).html(edit_btn_html);
                            showGreenAlert("הנתונים עודכנו בהצלחה");
                            load_btns_fnclty_in_tbl();
                        });
                    });
                    
                });

                $(".ct_btn_delete_"+i).click(function()
                {
                    var course_id = $(this).attr("id");
                    delete_course(course_id, function(res)
                    {
                        if(res == 1)
                        {
                            showGreenAlert("הקורס נמחק בהצלחה");
                        }
                        load_course_table(function(response)
                        {
                            table_element.html(response);
                            load_btns_fnclty_in_tbl();
                        });
                    });
                });

                $(".ct_btn_manage_"+i).click(function()
                {
                    var course_id = $(this).attr("id");
                    set_course(course_id);
                    $(".slct_crs").removeClass("chosen");
                    $(".courses_list_fill .slct_crs_"+course_id).addClass("chosen");
                    showGreenAlert("הקורס הוגדר בהצלחה!");
                });
            }
        });
    }

    function delete_course(course_id, callback)
    {
        $.ajax(
            {
                url: 'action/course-action.php', 
                type: 'GET', 
                data: 
                { 
                    action: 'delete_course', 
                    course_id: course_id 
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

    function get_level_name(level)
    {
        if(level == '1')
        {
            return "כיתה א'";
        }
        else if(level == '2')
        {
            return "כיתה ב'";
        }
        else if(level == '3')
        {
            return "כיתה ג'";
        }
        else if(level == '4')
        {
            return "כיתה ד'";
        }
        else if(level == '5')
        {
            return "כיתה ה'";
        }
        else if(level == '6')
        {
            return "כיתה ו'";
        }
        else if(level == '7')
        {
            return "כיתה ז'";
        }
        else if(level == '8')
        {
            return "כיתה ח'";
        }
        else if(level == '9')
        {
            return "כיתה ט'";
        }
        else if(level == '10')
        {
            return "כיתה י'";
        }
        else if(level == '11')
        {
            return 'כיתה י"א';
        }
        else if(level == '12')
        {
            return 'כיתה י"ב';
        }
    }

    function course_rb()
    {
        $(".course_table_fill").html("");
        $(".add_course_fill").html("");
        $("#course_name_field").html("");
        $(".add_course_tb h2").text("מיחזור קורסים שנמחקו");
        $(".course_table_fill").load("layout/rec/course_rb.php");
        $(".course_table_fill").css(
            {
                'display': 'flex', 
                'align-items': 'center', 
                'justify-content': 'center', 
                'flex-direction': 'column'
            });
        $(".course_rb").text("ניהול קורסים");
        $(".course_rb").off("click");
        $(".course_rb").click(function()
        {
            $(".popup_add_course").load("layout/rec/add_course.php");
        });
    }

    $(".course_rb").click(function()
    {
        course_rb();
    });

});