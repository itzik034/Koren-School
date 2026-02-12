$(document).ready(function()
{
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    function check_login(email, password)
    {
        $.ajax({
            type: "POST",
            url: "app/actions/login-action.php",
            data: 
            { 
                action: 'check_login', 
                l_email: email, 
                l_pass: password
            },
            success: function(response)
            {
                if(response == '1')
                {
                    window.location.href = '?page=records';
                }
                else if(response == '0')
                {
                    $(".fail_login_text_fill").css("padding", "10px 0");
                    $(".fail_login_text").text("מייל או סיסמה אינם נכונים. אנה נסו שוב.");
                }
            }
        });
    }

    function check_if_user_ava(email, callback)
    {
        $.ajax({
            type: "POST",
            url: "app/actions/login-action.php",
            data: 
            { 
                action: 'check_user_ava', 
                s_email: email 
            },
            success: function(response)
            {
                callback(response);
            }
        });
    }

    function signup_user_frm()
    {
        var s_email = $("#s_email").val();
        var s_phone = $("#s_phone").val();
        var s_pass = $("#s_pass").val();
        var s_f_name = $("#s_f_name").val();
        var s_l_name = $("#s_l_name").val();

        $(".su_err_msg_text").css("direction", "rtl");

        if(s_email == '' || s_pass == '' || s_f_name == '' || s_l_name == '' || s_phone == '')
        {
            $(".su_err_msg_text").text('חובה למלא את כל הפרטים כדי להירשם.');
            return;
        }
        
        check_if_user_ava(s_email, function(res)
        {
            if(res == '1')
            {
                $.ajax({
                    type: "POST",
                    url: "app/actions/login-action.php",
                    data: 
                    { 
                        action: 'sign_up_user', 
                        s_email: s_email, 
                        s_phone: s_phone, 
                        s_pass: s_pass, 
                        s_f_name: s_f_name, 
                        s_l_name: s_l_name 
                    },
                    success: function(response)
                    {
                        if(response == '0')
                        {
                            $(".su_err_msg_text").text('שגיאה ביצירת המשתמש');
                            return;
                        }
                        else if(response == '1')
                        {
                            $(".su_err_msg_text").css("color", "#000");
                            $(".su_err_msg_text").html('המשתמש נוצר בהצלחה! <a href="?page=records" class="su_succ_kg">לחץ כאן אם הדפדפן אינו מעביר אותך אוטומטית</a>');
                            window.location.href = '?page=records';
                        }
                    }, 
                    error: function(err1, err2, err3)
                    {
                        $(".su_err_msg_text").text('שגיאה ביצירת המשתמש');
                    }
                });
            }
            else
            {
                $(".su_err_msg_text").text('כבר נרשמת בעבר עם מייל זה. נסה להתחבר.');
            }
        });
    }

    $("#li_form").submit(function(e) 
    { 
        e.preventDefault();
        var l_email = $("#l_email").val();
        var l_pass = $("#l_pass").val();
        check_login(l_email, l_pass);
    });

    $("#su_form").submit(function(e) 
    { 
        e.preventDefault();
        signup_user_frm();
    });

    $('#togglePassword').css(
        {
            'cursor': 'pointer', 
            'width': '24px', 
            'height': '24px'
        });

    $('#togglePassword').click(function() 
    {
        const pw = $('#l_pass');

        if(pw.attr('type') === 'password') 
        {
            pw.attr('type', 'text');
            $(this).attr('class', 'fa fa-eye-slash');
            this.offsetHeight;
        } 
        else 
        {
            pw.attr('type', 'password');
            $(this).attr('class', 'fa fa-eye');
            this.offsetHeight;
        }
    });
});