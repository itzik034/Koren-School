$(document).ready(function()
{
    var profile = $("#menu-profile");
    var menu = $("#profile-menu");
    var p_position = profile.offset();

    profile.mouseenter(function()
    {
        p_position = $(this).offset();
        var menu_width = menu.outerWidth();
        var menu_top = p_position.top + $(this).outerHeight() + 5;
        var pr_width = profile.outerWidth();
        var menu_left = p_position.left;

        menu.css('top', menu_top);
        menu.css('left', menu_left);
        menu.css('width', pr_width);
        menu.show();
    });

    (profile, menu).mouseleave(function()
    {
        menu.hide();
    });
    
    
});