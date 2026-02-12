$(document).ready(function()
{
    var cls_name_element = $("#class_name_field");
    var select_tch_element = $("#ec_select_teach");
    var select_crs_element = $("#ec_select_course");
    var cls_loc_element = $("#class_loc_field");
    var cls_date1_element = $("#class_date1");
    var cls_date2_element = $("#class_date2");
    var class_id = $("#class_id").val();

    $(".close_ec_btn").click(function()
    {
        remove_edit_class_popup();
    });

    $("#update_class_data_btn").click(function()
    {
        var name = cls_name_element.val();
        var loc = cls_loc_element.val();
        var course = select_crs_element.val();
        var teacher = select_tch_element.val();
        var date1 = cls_date1_element.val();
        var date2 = cls_date2_element.val();

        save_edit_class_form_data(class_id, name, teacher, course, loc, date1, date2);
        upload_class_image(class_id);
    });

    $("#edit_class_form").submit(function (e)
    { 
        e.preventDefault();
    });

    function save_edit_class_form_data(class_id, name, teacher, course, loc, date1, date2)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'save_edit_class_form_data', 
                class_id: class_id, 
                class_name: name, 
                class_teacher: teacher, 
                class_course: course, 
                class_loc: loc, 
                class_date1: date1, 
                class_date2: date2
            },
            success: function (response)
            {
                if(response == "1")
                {
                    showGreenAlert("פרטי הכיתה עודכנו בהצלחה!");
                }
                else
                {
                    showRedAlert("שגיאה בעדכון פרטי הכיתה");
                }
            }
        });
    }

    function get_ec_data_1(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_1&class_id="+class_id, (res) => { callback(res) });
    }
    function get_ec_data_2(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_2&class_id="+class_id, (res) => { callback(res) });
    }
    function get_ec_data_3(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_3&class_id="+class_id, (res) => { callback(res) });
    }
    function get_ec_data_4(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_4&class_id="+class_id, (res) => { callback(res) });
    }
    function get_ec_data_5(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_5&class_id="+class_id, (res) => { callback(res) });
    }
    function get_ec_data_6(callback)
    {
        $.get("app/actions/action.php?action=get_ec_data_6&class_id="+class_id, (res) => { callback(res) });
    }

    function load_ec_form_data()
    {
        get_ec_data_1( (res) => { cls_name_element.val(res) });
        get_ec_data_2( (res) => { select_crs_element.val(res) });
        get_ec_data_3( (res) => { select_tch_element.val(res) });
        get_ec_data_4( (res) => { cls_loc_element.val(res) });
        get_ec_data_5( (res) => { cls_date1_element.val(res) });
        get_ec_data_6( (res) => { cls_date2_element.val(res) });
    }

    function load_teachers_to_select()
    {
        $.get("app/actions/action.php?action=get_teachers_select_ac", (res) => 
        {
            select_tch_element.html(res);
        });
    }

    function load_classes_to_select()
    {
        $.get("app/actions/action.php?action=get_courses_select_ac", (res) => 
        {
            select_crs_element.html(res);
        });
    }

    function load_check_click()
    {
        get_num_of_users((res) => 
        {
            res = parseInt(res);
            for(var i = 0; i <= res; i++)
            {
                $(".std_fill_"+i).click(function()
                {
                    var std_id = $(this).attr("id");
                    var my_check = $(".chck_c_s_"+std_id);
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

    function load_tch_check_click()
    {
        get_num_of_users((res) => 
        {
            res = parseInt(res);
            for(var i = 0; i <= res; i++)
            {
                $(".tch_fill_"+i).click(function()
                {
                    var tch_id = $(this).attr("id");
                    var my_check = $(".chck_c_s_"+tch_id);
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

    function save_checked_teachers()
    {
        get_num_of_users((res) => 
        {
            res = parseInt(res);
            for(var i = 1; i <= res; i++)
            {
                var checked = $(".tch_fill_"+i+" input[type='checkbox']").prop('checked');
                if(checked)
                {
                    teacher_is_check(class_id, i);
                }
                else
                {
                    teacher_is_not_check(class_id, i);
                }
                $(".tch_fill_"+i).on("click", function() 
                {
                    $(this).find('input[type="checkbox"]').prop('checked', function(i, val) {
                        return !val;
                    });
                });
            }
            showGreenAlert("הרשימה עודכנה בהצלחה!");
        });
    }

    function teacher_is_check(class_id, teacher_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'teacher_is_check', 
                    class_id: class_id, 
                    teacher_id: teacher_id
                },
                success: function(response) { return response; }
            });
    }

    function teacher_is_not_check(class_id, teacher_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'teacher_is_not_check', 
                    class_id: class_id, 
                    teacher_id: teacher_id
                },
                success: function(response) { return response; }
            });
    }

    function save_checked_students()
    {
        get_num_of_users((res) => 
        {
            res = parseInt(res);
            for(var i = 1; i <= res; i++)
            {
                var checked = $(".std_fill_"+i+" input[type='checkbox']").prop('checked');
                if(checked)
                {
                    student_is_check(class_id, i);
                }
                else
                {
                    student_is_not_check(class_id, i);
                }
            }
            showGreenAlert("הרשימה עודכנה בהצלחה!");
        });
    }

    function student_is_check(class_id, student_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'student_is_check', 
                    class_id: class_id, 
                    student_id: student_id
                },
                success: function(response) {}
            });
    }

    function student_is_not_check(class_id, student_id)
    {
        $.ajax(
            {
                type: "GET",
                url: "app/actions/action.php",
                data: 
                { 
                    action: 'student_is_not_check', 
                    class_id: class_id, 
                    student_id: student_id
                },
                success: function(response) {}
            });
    }

    function load_cls_tch_checks()
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'load_cls_tch_checks', 
                class_id: class_id
            },
            success: function (response) 
            {
                $(".cls_tch_lst_fill").html(response);
            }
        });
    }

    $("#s_c_update_btn").click(() => 
    {
        save_checked_students();
    });

    $("#cls_tch_lst_update_btn").click(() => 
    {
        save_checked_teachers();
    });

    function load_students_checks()
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'load_students_checks', 
                class_id: class_id
            },
            success: function (response) 
            {
                $(".s_c_std_fill").html(response);
            }
        });
    }

    function upload_class_image(class_id)
    {
        var imageFile = $("#class_picture")[0].files[0];

        if (!imageFile) return;

        var formData = new FormData();
        formData.append("class_picture", imageFile);
        formData.append("class_id", class_id);

        $.ajax({
            type: "POST",
            url: "app/actions/upload_class_image.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) 
            {
                console.log("תשובת שרת להעלאת תמונה:", response);
            }
        });
    }

    

    load_classes_to_select();
    load_teachers_to_select();
    load_students_checks();
    load_cls_tch_checks();
    setTimeout(() => { load_ec_form_data() }, 200);
    setTimeout(() => { load_check_click() }, 200);
    setTimeout(() => { load_tch_check_click() }, 200);
});