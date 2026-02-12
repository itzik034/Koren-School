// std_prog_in_tch_dash_<user-id>

$(document).ready(function () {
    function get_num_of_students(callback) {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: { action: 'get_num_of_students' },
            success: function (response) { callback(response) }
        });
    }

    function get_student_avg_prog(student_id, callback) {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: { action: 'get_student_avg_prog', student_id: student_id },
            success: function (response) { callback(response) }
        });
    }

    function get_student_unfinished_quizzes(student_id, callback) {
        $.ajax({
            type: "GET",
            url: "app/actions/action.php",
            data: { action: 'get_student_unfinished_quizzes', student_id: student_id },
            success: function (response) { callback(response) }
        });
    }

    get_num_of_students(nos => {
        for(let i = 1; i <= nos; i++) {
            const progElement = $(".std_prog_in_tch_dash_"+i);
            get_student_avg_prog(i, res => {
                progElement.html(res+'%');
                progElement.css('width', res);
            });

            const numElement = $("std_num_"+i);
            get_student_unfinished_quizzes(i, res => {});
        }
    });
});