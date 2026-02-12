$(document).ready(function()
{
    function get_num_of_users(callback)
    {
        $.get("app/actions/action.php?action=get_num_of_users", (res) => { callback(res) });
    }

    function get_user_pack(user_id, callback)
    {
        $.get("app/actions/action.php?action=get_user_pack&user_id="+user_id, (res) => { callback(res) });
    }

    function update_admin_edit_user_data(user_id, f_name, l_name, rank, email, phone)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'update_admin_edit_user_data', 
                user_id: user_id, 
                f_name: f_name, 
                l_name: l_name, 
                rank: rank, 
                email: email, 
                phone: phone
            },
            success: function (response)
            {
                showGreenAlert("הנתונים עודכנו בהצלחה");
            }
        });
    }

    function load_edit_usr_fun()
    {
        get_num_of_users((nou) => 
        {
                for(var i = 1; i <= nou; i++)
                {
                    $(".edit_user_"+i).off("click");
                    $(".edit_user_"+i).click(function()
                    {
                        var user_id = $(this).attr("id");
                        get_user_field(user_id, 'user-first_name', (user_first_name) => {
                            $(".col_user_f_name_"+user_id).html('<input type="text" class="edit_field" value="'+user_first_name+'">');
                        });
                        get_user_field(user_id, 'user-last_name', (user_last_name) => {
                            $(".col_user_l_name_"+user_id).html('<input type="text" class="edit_field" value="'+user_last_name+'">');
                        });
                        get_user_field(user_id, 'email', (email) => {
                            $(".col_user_email_"+user_id).html('<input type="text" class="edit_field" value="'+email+'">');
                        });
                        get_user_field(user_id, 'user-phone', (phone) => {
                            $(".col_user_phone_"+user_id).html('<input type="text" class="edit_field" value="'+phone+'">');
                        });
                        get_user_field(user_id, 'rank', (user_rank) => {
                            $(".col_user_rank_"+user_id).html
                            (
                                '<select class="select_the_user_rank" id="select_user_rank_'+user_id+'">' + 
                                    '<option value="s">תלמיד</option>' + 
                                    '<option value="t">מורה</option>' + 
                                    '<option value="a">מנהל</option>' + 
                                '</select>'
                            );
                            $("#select_user_rank_"+user_id).val(user_rank);
                        });
                        get_user_pack(user_id, (user_package) => 
                        {
                            if(user_package == '')
                            {
                                $(".col_user_pack_"+user_id).html("<button class='add_pack_to_user_btn' id='add_pack_to_user_"+user_id+"'>הוספת חבילה</button>");
                                $("#add_pack_to_user_"+user_id).click(function()
                                {
                                    $.get("layout/popups/add_pack_to_user.php?user_id="+user_id, (res) => 
                                    {
                                        $('body').append("<div class='add_pack_to_user_popup_filllll'>"+res+"</div>");
                                        $('body').css("overflow-y", "hidden");
                                    });
                                });
        
                            }
                            else
                            {
                                $(".col_user_pack_"+user_id).html("<button class='add_pack_to_user_btn' id='edit_pack_of_user_"+user_id+"'>עריכת חבילה</button>");
                                $("#edit_pack_of_user_"+user_id).click(function()
                                {
                                    $.get("layout/popups/edit_pack_of_user.php?user_id="+user_id, (res) => 
                                    {
                                        $('body').append("<div class='edit_pack_of_user_popup_filllll'>"+res+"</div>");
                                        $('body').css("overflow-y", "hidden");
                                    });
                                });
                            }
                        });
        
                        $(this).text("שמירה");
                        $(this).off("click");
                        $(this).click(() => 
                        {
                            let f_name = $(".col_user_f_name_" + user_id + " .edit_field").val();
                            let l_name = $(".col_user_l_name_" + user_id + " .edit_field").val();
                            let email = $(".col_user_email_" + user_id + " .edit_field").val();
                            let phone = $(".col_user_phone_" + user_id + " .edit_field").val();
                            let rank = $("#select_user_rank_" + user_id).val();
                            
                            update_admin_edit_user_data(user_id, f_name, l_name, rank, email, phone);

                            get_user_field(user_id, 'user-first_name', (user_first_name) => {
                                $(".col_user_f_name_"+user_id).html(user_first_name);
                            });
                            get_user_field(user_id, 'user-last_name', (user_last_name) => {
                                $(".col_user_l_name_"+user_id).html(user_last_name);
                            });
                            get_user_field(user_id, 'email', (email) => {
                                $(".col_user_email_"+user_id).html(email);
                            });
                            get_user_field(user_id, 'user-phone', (phone) => {
                                $(".col_user_phone_"+user_id).html(phone);
                            });
                            get_user_field(user_id, 'rank', (user_rank) => {
                                rank_text(user_rank, (rank_text) => 
                                {
                                    $(".col_user_rank_"+user_id).html(rank_text);
                                });
                            });
                            get_user_pack(user_id, (user_package) => 
                            {
                                pack_text(user_package, (pack_text) => 
                                {
                                    $(".col_user_pack_"+user_id).html(pack_text);
                                });
                            });
                            $(this).text("עריכה");
                            $(this).off("click");
                            load_edit_usr_fun();
                        });
                    });

                    $(".delete_user_"+i).off("click");
                    $(".delete_user_"+i).click(function()
                    {
                        var user_id = $(this).attr("id");
                        delete_user(user_id);
                    });

                    $(".recy_user_"+i).off("click");
                    $(".recy_user_"+i).click(function()
                    {
                        var user_id = $(this).attr("id");
                        recycle_user(user_id);
                    });
                }
        });
    }

    load_edit_usr_fun();

    function delete_user(user_id)
    {
        $.get("app/actions/action.php?action=delete_user&user_id="+user_id, (res) => 
        {
            if(res == "1")
            {
                $(".user_row_"+user_id).removeClass("active_row");
                $(".user_row_"+user_id).addClass("deleted_row");
                $(".delete_user_"+user_id).off("click");
                $(".delete_user_"+user_id).click(() => 
                {
                    recycle_user(user_id);
                });
                $(".delete_user_"+user_id).text("שיחזור");
                $(".delete_user_"+user_id).addClass("recycle");
                $(".delete_user_"+user_id).removeClass("delete");
                $(".delete_user_"+user_id).addClass("recy_user_"+user_id);
                $(".recy_user_"+user_id).removeClass("delete_user_"+user_id);
            }
        });
    }

    function recycle_user(user_id)
    {
        $.get("app/actions/action.php?action=recycle_user&user_id="+user_id, (res) => 
        {
            if(res == "1")
                {
                    $(".user_row_"+user_id).addClass("active_row");
                    $(".user_row_"+user_id).removeClass("deleted_row");
                    $(".recy_user_"+user_id).off("click");
                    $(".recy_user_"+user_id).click(() => 
                    {
                        delete_user(user_id);
                    });
                    $(".recy_user_"+user_id).text("מחיקה");
                    $(".recy_user_"+user_id).removeClass("recycle");
                    $(".recy_user_"+user_id).addClass("delete");
                    $(".recy_user_"+user_id).addClass("delete_user_"+user_id);
                    $(".delete_user_"+user_id).removeClass("recy_user_"+user_id);
                }
        });
    }

    $("#users_btn").click(() => 
    {
        $('html, body').animate(
        {
            scrollTop: $('.users_title h2').offset().top - 50
        }, 700);
    });

    $("#packs_btn").click(() => 
    {
        $('html, body').animate(
        {
            scrollTop: $('.packs_title h2').offset().top - 50
        }, 1000);
    });

    $("#reset_bins_btn").click(() => 
    {
        $('html, body').animate(
        {
            scrollTop: $('.sm_rbb_title h2').offset().top - 50
        }, 1000);
    });

    $("#reset_all_bins_btn").click(() => 
    {
        $("#reset_all_bins_btn").text("אנא המתן...");
        
        reset_all_bins_of_ques();
        
        setTimeout(() => {
            $("#reset_all_bins_btn").text("איפוס בינים לכל השאלות באתר");
            alert("הבינים אופסו בהצלחה");
        }, 800);
        reset_all_bins();
    });

    function get_num_of_packs(callback)
    {
        $.get("app/actions/action.php?action=get_num_of_packs", (res) => { callback(res) });
    }

    function load_edit_pack_fun()
    {
        get_num_of_packs((nop) => 
        {
            for(var i = 1; i <= nop; i++)
            {
                $(".edit_pack_"+i).click(function()
                {
                    var user_id = $(this).attr("id");
                    $.get("layout/popups/edit_pack_of_user.php?user_id="+user_id, (res) => 
                    {
                        $('body').append("<div class='edit_pack_of_user_popup_filllll'>"+res+"</div>");
                        $('body').css("overflow-y", "hidden");
                    });
                });
            }
        });
    }

    load_edit_pack_fun();


});