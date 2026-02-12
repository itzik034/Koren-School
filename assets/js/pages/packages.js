$(document).ready(function()
{
    $(".plan_button").click(function()
    {
        var pack_id = $(this).attr("id");
        $.get("layout/popups/buy_pack.php?pack_id="+pack_id, (res) => { $(".t3p2").html(res) });
    });
});