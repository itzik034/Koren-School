$(document).ready(function()
{
    var pic = 1;
    var element = $("#pic-slider");
    var left = $("#slider-right");
    var right = $("#slider-left");
    var pic_limit = 3;
    var right2 = $("#left-arrow2");
    var left2 = $("#right-arrow2");
    var t_num = 1;
    var t_limit = 4;
    var ot = $("#ot");

    $.ajax(
        {
            url: 'action/get_teacher_count.php', 
            type: 'GET', 
            data: {  }, 
            success: function(response) 
            {
                t_limit = response;
            }
        });

    left.click(function()
    {
        pic++;
        if(pic > pic_limit)
        {
            pic = 1;
        }
        element.html('<img class="slider-images-class" src="img/slider/pic' + pic + '.jpg">');
    });
    
    right.click(function()
    {
        pic--;
        if(pic <= 0)
        {
            pic = pic_limit;
        }
        element.html('<img class="slider-images-class" src="img/slider/pic' + pic + '.jpg">');
    });

    right2.click(function()
    {
        t_num++;
        if(t_num > t_limit)
        {
            t_num = 1;
        }

        $.ajax(
        {
            url: 'action/get_teacher_info.php',
            type: 'GET',
            data: { t_id: t_num },
            success: function(response) 
            {
                if(response != "")
                {
                    ot.html(response);
                }
                else
                {
                    alert(t_num);
                }
            }
        });
    });

    left2.click(function()
    {
        t_num--;
        if(t_num <= 0)
        {
            t_num = t_limit;
        }
        
        $.ajax(
            {
                url: 'action/get_teacher_info.php',
                type: 'GET',
                data: { t_id: t_num },
                success: function(response) 
                {
                    if(response != "")
                    {
                        ot.html(response);
                    }
                    else
                    {
                        alert(t_num);
                    }
                }
            });
    });


});