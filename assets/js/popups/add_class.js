$(document).ready(function()
{
    var cls_name_element = $("#ac_class_name_field");
    var select_tch_element = $("#ac_select_teach");
    var select_crs_element = $("#ac_select_course");
    var cls_loc_element = $("#ac_class_loc_field");
    var cls_date1_element = $("#ac_class_date1");
    var cls_date2_element = $("#ac_class_date2");

    function save_add_class_form_data(name, teacher, course, loc, date1, date2)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'save_add_class_form_data', 
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
                    showGreenAlert("הכיתה נוצרה בהצלחה!");
                    $(".close_ac_btn").click();
                }
                else
                {
                    showRedAlert("שגיאה ביצירת הכיתה");
                }
            }
        });
    }

    function upload_class_image()
    {
        var imageFile = $("#class_picture")[0].files[0];

        if (!imageFile) return;

        var formData = new FormData();
        formData.append("class_picture", imageFile);

        $.ajax({
            type: "POST",
            url: "app/actions/upload_class_image.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("תשובת שרת להעלאת תמונה:", response);
            }
        });
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

    $(".close_ac_btn").click(function()
    {
        remove_add_class_popup();
    });

    $("#ac_update_class_data_btn").click(function()
    {
        var name = cls_name_element.val();
        var loc = cls_loc_element.val();
        var course = select_crs_element.val();
        var teacher = select_tch_element.val();
        var date1 = cls_date1_element.val();
        var date2 = cls_date2_element.val();

        if(name != '')
        {
            save_add_class_form_data(name, teacher, course, loc, date1, date2);
            upload_class_image();
        }
        else
        {
            showRedAlert("חייב לתת לפחות שם לכיתה");
        }
    });

    $("#add_class_form").submit(function (e)
    { 
        e.preventDefault();
    });

    // function loadScript(url, callback) 
    // {
    //     let script = document.createElement("script");
    //     script.type = "text/javascript";
    //     script.src = url;
    //     script.onload = callback;
    //     document.head.appendChild(script);
    // }

    // loadScript("https://code.jquery.com/ui/1.12.1/jquery-ui.min.js", function () 
    // {
    //     console.log("jQuery UI נטען!");

    //     let cities = [];

    //     $.ajax({
    //         url: "app/actions/class_city.php",
    //         type: "GET",
    //         dataType: "json",
    //         success: function (data) 
    //         {
    //             cities = data;
    //         },
    //         error: function () 
    //         {
    //             console.error("שגיאה בטעינת רשימת הערים");
    //         }
    //     });

    //     $("#ac_class_loc_field").autocomplete({
    //         source: function (request, response) 
    //         {
    //             let results = $.grep(cities, function (city) 
    //             {
    //                 return city.indexOf(request.term) !== -1;
    //             });
    //             response(results);
    //         },
    //         minLength: 1 
    //     });
    // });

    


    load_teachers_to_select();
    load_classes_to_select();
});