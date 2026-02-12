$(document).ready(function()
{
    $(".close_ast_popup_btn").click( () => { close_add_student_popup() } );

    var fi_f_name = $("#std_f_name");
    var fi_l_name = $("#std_l_name");
    var fi_email = $("#std_email");
    var fi_password = $("#std_password");
    var fi_birthday = $("#std_birthday");
    var fi_address = $("#std_address");
    var fi_country = $("#std_country");
    var fi_school = $("#std_school");
    var fi_phone = $("#std_phone");
    var fi_mom_name = $("#std_mom_name");
    var fi_mom_phone = $("#std_mom_phone");
    var fi_id = $("#std_id");
    var create_student_button = $("#create_std_btn");

    function create_student(f_name, l_name, email, password, birthday, address, country, school, 
                            phone, mom_name, mom_phone, id)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'create_student', 
                f_name: f_name, 
                l_name: l_name, 
                email: email, 
                password: password, 
                birthday: birthday, 
                address: address, 
                country: country, 
                school: school, 
                phone: phone, 
                mom_name: mom_name, 
                mom_phone: mom_phone, 
                id: id
            },
            success: function (response) 
            {
                if(response == '1')
                {
                    showGreenAlert("התלמיד נוצר בהצלחה!");
                }
                else
                {
                    showRedAlert("שגיאה ביצירת התלמיד");
                }
                close_add_student_popup();
            }
        });
    }

    create_student_button.click( () => 
    { 
        create_student(fi_f_name.val(), fi_l_name.val(), fi_email.val(), fi_password.val(), fi_birthday.val(), 
                        fi_address.val(), fi_country.val(), fi_school.val(), fi_phone.val(), fi_mom_name.val(), 
                        fi_mom_phone.val(), fi_id.val());
    } );
});