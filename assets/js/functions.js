$(document).ready(function()
{
    window.get_user_field = function(uid, field, callback)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'get_user_field', uid: uid, field: field },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.get_pack_field = function(uid, field, callback)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'get_pack_field', uid: uid, field: field },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.pack_text = function (pack, callback)
    {
        $.get("app/actions/action.php?action=pack_text&pack="+pack, (res) => { callback(res) });
    }

    window.rank_text = function (rank, callback)
    {
        $.get("app/actions/action.php?action=rank_text&rank="+rank, (res) => { callback(res) });
    }

    window.showPopup = function(t_id)
    {
        $("#popup-window").css("top", "0");
        $("#popup-window").css("opacity", "1");
        $("#popup-window-msg").css("top", "0");
        $("#popup-window-msg").css("opacity", "1");
        tid = t_id;
        var t_name = "";
        get_user_field(t_id, "user-first_name", function(r)
        { 
            t_name += r;
            get_user_field(t_id, "user-last_name", function(r)
            { 
                t_name += " ";
                t_name += r;
                $("#popup-split-top").html("למחוק את " + t_name + "?");
                $("#popup-split-top").css("direction", "rtl"); 
            }); 
        });
        $("#popup-ok").removeClass();
        $("#popup-ok").addClass(t_id);
    }

    window.hidePopup = function()
    {
        $("#popup-window").css("top", "-10000px");
        $("#popup-window").css("opacity", "0");
        $("#popup-window-msg").css("top", "-10000px");
        $("#popup-window-msg").css("opacity", "0");
    }

    window.get_user_rank = function(callback)
    {
        $.get("app/actions/action.php?action=get_user_rank", (res) => { callback(res) });
    }

    window.showGreenAlert = function(alert_text)
    {
        $("#alert-content").html(alert_text);
        $("#alert").css("top", "90vh");
        $("#alert").css("opacity", "1");
        setTimeout(function()
        {
            $("#alert").css("top", "-250vh");
            $("#alert").css("opacity", "0");
        }, 5000);
    }

    window.showRedAlert = function(alert_text)
    {
        $("#alert-err-content").html(alert_text);
        $("#alert-err").css("top", "90vh");
        $("#alert-err").css("opacity", "1");
        setTimeout(function()
        {
            $("#alert-err").css("top", "-250vh");
            $("#alert-err").css("opacity", "0");
        }, 5000);
    }

    window.edit_teacher = function(t_id)
    {
        var f_first_name = $("#f_tch_f_name");
        var f_last_name = $("#f_tch_l_name");
        var f_username = $("#f_username");
        var f_password = $("#f_tch_password");
        var f_email = $("#f_tch_email");
        var f_address = $("#f_tch_address");
        var f_country = $("#f_tch_country");
        var f_school = $("#f_tch_school");
        var f_phone = $("#f_tch_phone");
        var f_id = $("#f_tch_id");

        get_user_field(t_id, "user-first_name", function(r){ f_first_name.val(r); });
        get_user_field(t_id, "user-last_name", function(r){ f_last_name.val(r); });
        get_user_field(t_id, "username", function(r){ f_username.val(r); });
        get_user_field(t_id, "password", function(r){ f_password.val(r); });
        get_user_field(t_id, "email", function(r){ f_email.val(r); });
        get_user_field(t_id, "user-address", function(r){ f_address.val(r); });
        get_user_field(t_id, "user-country", function(r){ f_country.val(r); });
        get_user_field(t_id, "user-school", function(r){ f_school.val(r); });
        get_user_field(t_id, "user-phone", function(r){ f_phone.val(r); });
        get_user_field(t_id, "user-id", function(r){ f_id.val(r); });

        $("#popup-edit-teacher").css("top", "0");
        $("#popup-edit-teacher").css("opacity", "1");
        $("#popup-et-fill").css("top", "0");
        $("#popup-et-fill").css("opacity", "1");
        $('body').css("overflow-y", "hidden");
    }

    window.edit_student = function(s_id)
    {
        var f_first_name = $("#f_st_f_name");
        var f_last_name = $("#f_st_l_name");
        var f_username = $("#f_st_username");
        var f_password = $("#f_st_password");
        var f_email = $("#f_st_email");
        var f_address = $("#f_st_address");
        var f_country = $("#f_st_country");
        var f_school = $("#f_st_school");
        var f_phone = $("#f_st_phone");
        var f_mom = $("#f_st_mom_name");
        var f_mom_phone = $("#f_st_mom_phone");
        var f_id = $("#f_st_id");

        get_user_field(s_id, "user-first_name", function(r){ f_first_name.val(r); });
        get_user_field(s_id, "user-last_name", function(r){ f_last_name.val(r); });
        get_user_field(s_id, "username", function(r){ f_username.val(r); });
        get_user_field(s_id, "password", function(r){ f_password.val(r); });
        get_user_field(s_id, "email", function(r){ f_email.val(r); });
        get_user_field(s_id, "user-address", function(r){ f_address.val(r); });
        get_user_field(s_id, "user-country", function(r){ f_country.val(r); });
        get_user_field(s_id, "user-school", function(r){ f_school.val(r); });
        get_user_field(s_id, "user-phone", function(r){ f_phone.val(r); });
        get_user_field(s_id, "user-mom_name", function(r){ f_mom.val(r); });
        get_user_field(s_id, "user-mom_phone", function(r){ f_mom_phone.val(r); });
        get_user_field(s_id, "user-id", function(r){ f_id.val(r); });

        $("#popup-edit-student").css("top", "0");
        $("#popup-edit-student").css("opacity", "1");
        $("#popup-es-fill").css("top", "0");
        $("#popup-es-fill").css("opacity", "1");
        tid = s_id;
    }

    window.deleteTeacher = function(t_id2)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'delete-teacher', t_id: t_id2 },
                success: function(response) 
                {
                    if(response == 1)
                    {
                        $("#rcrow_id_"+t_id2).css("position", "fixed");
                        $("#rcrow_id_"+t_id2).css("top", "-10000px");
                        $("#rcrow_id_"+t_id2).css("opacity", "0");
                        showGreenAlert("המורה נמחק בהצלחה!");
                    }
                    else
                    {
                        showRedAlert("שגיאה בעדכון הנתונים.");
                    }

                    update_admin_dash_cols();
                    update_teacher_dash_cols();
                }
            });
    }

    window.deleteStudent = function(s_id2)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'delete-student', s_id: s_id2 },
                success: function(response) 
                {
                    if(response == 1)
                    {
                        $("#rcrow_id_"+s_id2).css("position", "fixed");
                        $("#rcrow_id_"+s_id2).css("top", "-10000px");
                        $("#rcrow_id_"+s_id2).css("opacity", "0");
                        showGreenAlert("התלמיד נמחק בהצלחה!");
                    }
                    else
                    {
                        showRedAlert("שגיאה בעדכון הנתונים.");
                    }

                    update_admin_dash_cols();
                    update_teacher_dash_cols();
                }
            });
    }

    window.get_teacher_first_name = function(t_id1, callback)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 't_f_name', t_id: t_id1 },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.get_teacher_last_name = function(t_id1, callback)
    {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 't_l_name', t_id: t_id1 },
                success: function(response) 
                {
                    callback(response);
                }
            });
    }

    window.updateStudentsList = function()
    {
        $.ajax(
            {
                url: 'layout/rec/students.php',
                type: 'GET',
                success: function(response) 
                {
                    $("#students-col").html(" ");
                    $("#students-col").html(response);
                }
            });
    }

    window.chkUsrnmAvlb = function(username_check)
    {
        // Function to check if specific username is available
        var ava;
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'check-username', username: username_check }, 
                success: function(response) 
                {
                    if(response == 'true')
                    {
                        ava = true;
                    }
                    else 
                    {
                        ava = false;
                    }
                }, 
                error: function(xhr, status, err)
                {
                    ava = false;
                    console.log(err);
                    alert(err);
                }
            });
            return ava;
    }

    window.get_current_user = function(callback)
    {
        $.post("app/actions/login-action.php", { action: 'get_current_user' }, (res) => { callback(res) });
    }

    window.get_current_user_rank = function(callback)
    {
        $.post("app/actions/login-action.php", { action: 'get_current_user_rank' }, (res) => { callback(res) });
    }
});