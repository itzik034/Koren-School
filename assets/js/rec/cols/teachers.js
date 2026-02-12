$(document).ready(function () 
{
    load_edit_teacher_btns();
    
    $(".delete-teacher").click(function()
    {
        var t_id2 = $(this).attr('id');
        showPopup(t_id2);
    });

    function get_num_of_classes_of_teacher(teacher_id, callback) {
        $.ajax(
            {
                url: 'action/action.php',
                type: 'GET',
                data: { action: 'get_num_of_classes_of_teacher', teacher_id: teacher_id },
                success: function(response) {
                    callback(response);
                }
            }
        );
    }

    function get_num_of_teachers(callback) {
        $.ajax({
            url: 'action/action.php',
            type: 'GET',
            data: { action: 'get_num_of_teachers' },
            success: function(response) {
                callback(response);
            }
        });
    }

    function get_first_teacher_user_id(callback) {
        $.ajax({
            url: 'action/action.php',
            type: 'GET',
            data: { action: 'get_first_teacher_user_id' },
            success: function(response) {
                callback(response);
            }
        });
    }

    function get_last_teacher_user_id(callback) {
        $.ajax({
            url: 'action/action.php',
            type: 'GET',
            data: { action: 'get_last_teacher_user_id' },
            success: function(response) {
                callback(response);
            }
        });
    }

    function get_avg_prog_of_stds(teacher_id, callback) {
        get_num_of_classes_of_teacher(teacher_id, (num_of_cls) => { 
            let sum = 0;
            for(let i = 0; i <= num_of_cls; i++) {
                const class_id = '';
                if(class_id !== 0) {  }
            }
        });
    }
    
    function load_tch_prog_bar() {
        get_last_teacher_user_id((res) => {
            get_first_teacher_user_id((num_of_fst_tch) => { 
                for (let i = num_of_fst_tch; i <= res; i++) {
                    const teacher_id = $('.tch_rc_prog_inside_'+i).attr('id');
                    
                    get_avg_prog_of_stds(teacher_id, (avg_prog) => {
                        $('.tch_rc_prog_inside_'+teacher_id).css('width', avg_prog+'%');
                    });
                }
            });
        });
    }
    load_tch_prog_bar();
});