$(document).ready(function()
{
    var teacher_id;

    get_teacher_id_from_input();

    function load_check_click()
    {
        get_num_of_classes((res) => 
        {
            res = parseInt(res);
            for(var i = 0; i <= res; i++)
            {
                $(".actt_class_fill_"+i).click(function()
                {
                    var class_id = $(this).attr("id");
                    var my_check = $(".cckbx"+class_id);
                    if(my_check.is(":checked"))
                    {
                        my_check.prop("checked", false);
                    }
                    else
                    {
                        my_check.prop("checked", true);
                    }
                });
            }
        });
    }

    window.load_teacher_classes_list = function(teacher_id)
    {
        $.ajax(
        {
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_edit_teacher_classes_list', 
                teacher_id: teacher_id
            },
            success: function(response) 
            {
                $(".actt_fill").html(response);

                if(response != '0')
                {
                    load_check_click();
                }
                else
                {
                    showRedAlert("עדיין אין כיתות למורה");
                }
            }
        });
    }

    function get_teacher_id_from_input(callback=()=>{})
    {
        teacher_id = $("#teacher_id").val();
        callback(teacher_id);
    }

    function save_checked_classes()
    {
        get_num_of_classes((res) => 
        {
            for(var i = 1; i <= res; i++)
            {
                var checked = $(".actt_class_fill_"+i+" input[type='checkbox']").prop('checked');
                if(checked)
                {
                    get_teacher_id_from_input( (res) => 
                    {
                        class_is_check(i, res);
                    });
                }
                else
                {
                    get_teacher_id_from_input( (res) => 
                    {
                        class_is_not_check(i, res);
                    });
                }
            }
            showGreenAlert("הרשימה עודכנה בהצלחה!");
        });
    }

    function class_is_check(class_id, teacher_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'class_is_check', 
                    class_id: class_id, 
                    teacher_id: teacher_id
                },
                success: function(response) 
                {
                    
                }
            });
    }

    function class_is_not_check(class_id, teacher_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'class_is_not_check', 
                    class_id: class_id, 
                    teacher_id: teacher_id
                },
                success: function(response) 
                {
                    
                }
            });
    }
    
    function load_save_cls_btn_func()
    {
        $("#update_checked_classes_btn").click(() => 
        {
            save_checked_classes();
        });
    }

    function load_courses_to_slct_lst()
    {
        $.ajax({
            type: "GET",
            url: "app/actions/course-action.php",
            data: { action: 'get_courses_edit_teacher' }, 
            success: function (response) 
            {
                $("#cctt_crs").html(response);
            }
        });
    }

    $("#cctt_form").submit(function (e) 
    { 
        e.preventDefault();
    });

    $("#cctt_frm_subm").click(function()
    {
        var class_name_field = $("#cctt_name").val();
        var select_course_field = $("#cctt_crs").val();
        var class_loc_field = $("#cctt_loc").val();
        var class_year1_field = $("#cctt_year").val();
        var class_year2_field = $("#cctt_year2").val();

        if(class_name_field == '' || class_loc_field == '' || 
           class_year1_field == '' || class_year2_field == '')
        {
            showRedAlert("חובה למלא את כל השדות כדי ליצור כיתה");
            return;
        }

        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'save_et_new_cls_data', 
                class_name: class_name_field, 
                class_course: select_course_field, 
                class_loc: class_loc_field, 
                class_year1: class_year1_field, 
                class_year2: class_year2_field, 
                teacher_id: teacher_id
            },
            success: function(response)
            {
                showGreenAlert("המורה נוצר ונוסף בהצלחה");
                load_teacher_classes_list(teacher_id);
                $(".cctt_frm_inputs").val("");
            }
        });
    });

    function get_field_data1(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data1', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data2(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data2', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data3(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data3', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data4(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data4', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data5(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data5', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data6(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data6', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data7(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data7', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data8(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data8', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }
    function get_field_data9(teacher_id, callback)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            { 
                action: 'get_etf_field_data9', 
                teacher_id: teacher_id 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }

    function load_et_form_data()
    {
        get_teacher_id_from_input((t_id)=>
        {
            get_field_data1(t_id, (res) => 
            {
                $("#f_tch_f_name").val(res);
            });
            get_field_data2(t_id, (res) => 
            {
                $("#f_tch_l_name").val(res);
            });
            get_field_data3(t_id, (res) => 
            {
                $("#f_tch_email").val(res);
            });
            get_field_data4(t_id, (res) => 
            {
                $("#f_tch_password").val(res);
            });
            get_field_data5(t_id, (res) => 
            {
                $("#f_tch_address").val(res);
            });
            get_field_data6(t_id, (res) => 
            {
                $("#f_tch_country").val(res);
            });
            get_field_data7(t_id, (res) => 
            {
                $("#f_tch_school").val(res);
            });
            get_field_data8(t_id, (res) => 
            {
                $("#f_tch_phone").val(res);
            });
            get_field_data9(t_id, (res) => 
            {
                $("#f_tch_id").val(res);
            });
        });
    }

    $("#edit-teacher-form").submit(function(e)
    {
        e.preventDefault();
        var first_name = $("#f_tch_f_name").val();
        var last_name = $("#f_tch_l_name").val();
        var password = $("#f_tch_password").val();
        var email = $("#f_tch_email").val();
        var address = $("#f_tch_address").val();
        var country = $("#f_tch_country").val();
        var school = $("#f_tch_school").val();
        var phone = $("#f_tch_phone").val();
        var user_id = $("#f_tch_id").val();
        
        get_teacher_id_from_input((res)=>
        {
            $.ajax({
                type: "GET",
                url: "app/actions/action.php",
                data: 
                {
                    action: 'update_et_data', 
                    teacher_id: res, 
                    f_name: first_name, 
                    l_name: last_name, 
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
                    if(response == 'success')
                    {
                        showGreenAlert("הנתונים עודכנו בהצלחה");
                    }
                    else
                    {
                        showRedAlert("שגיאה בעדכון הנתונים");
                    }
                }
            });
        });
    });

    $("#etu").click(function()
    {
        $("#edit-teacher-form").submit();
    });





    load_check_click();
    get_teacher_id_from_input((res) => { load_teacher_classes_list(res) });
    load_save_cls_btn_func();
    load_courses_to_slct_lst();
    load_et_form_data();
});