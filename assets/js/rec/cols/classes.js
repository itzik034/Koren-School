$(document).ready(function() {
    function load_cls_prog_bar() {
        get_num_of_classes((res) => {
            for (let i = 1; i <= res; i++) {
                // Set the progress bar of each class in admin panel
                $('#rc_prog_inside_'+i).html('');
            }
        });
    }
    load_cls_prog_bar();
});