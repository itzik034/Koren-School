$(document).ready(function()
{
    $(".tc_et_edit_btn").off("click");
    $(".tc_et_edit_btn").click(function()
    {
        var t_id = $(this).attr("id");
        load_et_layout(t_id);
        edit_teacher(t_id);
        $(".close_tch_card").click();
    });
});