$(document).ready(function()
{
    var que_id = $("#que_id").val();
    var sub_id = $("#sub_id").val();

    $("#back_to_que_mana").click(function()
    {
        load_ques_and_ans_card(que_id, function(){}, sub_id);
    });

    get_que_text_by_id(que_id, function(response)
    {
        $("#edit_que_que_text").val(response);
    });

    function update_que_data(que_id, que_text)
    {
        $.ajax(
            {
                url: 'action/quiz-action.php',
                type: 'GET',
                data: 
                { 
                    action: 'update_que_data', 
                    que_id: que_id, 
                    que_text: que_text
                },
                success: function(response) 
                {
                    showGreenAlert("השאלה עודכנה בהצלחה!");
                    $("#back_to_que_mana").click();
                }, 
                error: function(xhr, status, err)
                {
                    showRedAlert("שגיאה בעדכון הנתונים");
                }
            });
    }

    $("#edit_que_form").submit(function(e)
    {
        e.preventDefault();
        var que_text = $("#edit_que_que_text").val();
        if(que_text != '')
        {
            update_que_data(que_id, que_text);
        }
        else
        {
            showRedAlert("חובה למלא תוכן השאלה");
        }
    });

});