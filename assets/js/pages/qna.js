$(document).ready(function () 
{
    $('.answer').hide();

    $('.question').click(function() 
    {
        var answer = $(this).next('.answer');
        answer.slideToggle();
    });

});