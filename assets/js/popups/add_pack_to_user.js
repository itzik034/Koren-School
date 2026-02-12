$(document).ready(function () 
{
    var user_id = $("#user_id").val();

    function remove_add_pack_to_user_popup()
    {
        $(".add_pack_to_user_popup_filllll").remove();
        $('body').css("overflow-y", "auto");
    }
    
    $(".close_aptu_popup_btn").click(() => 
    {
        remove_add_pack_to_user_popup();
    });

    function remove_edit_pack_of_user_popup()
    {
        $(".edit_pack_of_user_popup_filllll").remove();
        $('body').css("overflow-y", "auto");
    }
    
    $(".close_eptu_popup_btn").click(() => 
    {
        remove_edit_pack_of_user_popup();
    });

    function add_pack_to_user(user_id, pack_id, start_time, end_time, pay_method, price)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'add_pack_to_user', 
                user_id: user_id, 
                pack: pack_id, 
                start_time: start_time, 
                end_time: end_time, 
                pay_method: pay_method, 
                price: price
            },
            success: function (response)
            {
                if(response == '1'){ showGreenAlert("החבילה נוספה בהצלחה") }
                else{ showRedAlert("שגיאה בהוספת החבילה") }
                remove_add_pack_to_user_popup();
                location.reload();
            }
        });
    }

    function edit_pack_of_user(user_id, pack_id, start_time, end_time, pay_method, price)
    {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: 
            {
                action: 'edit_pack_of_user', 
                user_id: user_id, 
                pack: pack_id, 
                start_time: start_time, 
                end_time: end_time, 
                pay_method: pay_method, 
                price: price
            },
            success: function (response)
            {
                if(response == '1'){ showGreenAlert("החבילה עודכנה בהצלחה") }
                else{ showRedAlert("שגיאה בעדכון החבילה"); }
                remove_edit_pack_of_user_popup();
                location.reload();
            }
        });
    }

    $(".delete_user_pack_btn").click(() => 
    {
        $(".delete_user_pack_fill").append(
            "<div class='areyousurediv'>" + 
            "<b><span>האם למחוק את החבילה?</span></b>" + 
            "<br>" + 
            "<span class='sureyes'>כן</span>" + 
            "<span class='sureno'>לא</span>" + 
            "</div>");
        
        $(".sureno").click(() => 
        {
            $(".areyousurediv").remove();
        });
        $(".sureyes").click(() => 
        {
            $.get("app/actions/action.php?action=delete_user_pack&user_id="+user_id, (res) => 
            { 
                if(res == '1')
                {
                    location.reload();
                    showGreenAlert("החבילה נמחקה בהצלחה");
                }
                else
                {
                    showRedAlert("שגיאה במחיקת החבילה");
                }
            });
        });
    });

    $("#aptu_submit").click(() => 
    {
        var pack_id = $("#select_this_user_package").val();
        var start_time = $("#aptu_start_date").val();
        var end_time = $("#aptu_end_date").val();
        var paid_amount = $("#paid_amount").val();
        var pay_method = $("#aptu_select_pay_method").val();

        add_pack_to_user(user_id, pack_id, start_time, end_time, pay_method, paid_amount);
    });

    $("#eptu_submit").click(() => 
    {
        var pack_id = $("#select_this_user_package").val();
        var start_time = $("#aptu_start_date").val();
        var end_time = $("#aptu_end_date").val();
        var paid_amount = $("#paid_amount").val();
        var pay_method = $("#aptu_select_pay_method").val();

        edit_pack_of_user(user_id, pack_id, start_time, end_time, pay_method, paid_amount);
    });

    $("#aptu_form, #eptu_form").submit(function (e) 
    { 
        e.preventDefault();
    });
    
});