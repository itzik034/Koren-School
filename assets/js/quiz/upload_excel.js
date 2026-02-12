$(document).ready(function() 
{
    var file_element = $("#excel_file");

    function download_format()
    {
        var fileUrl = 'uploads/format.xlsx';
        var downloadLink = $('<a>');
        downloadLink.attr(
        {
            href: fileUrl,
            download: 'format.xlsx'
        });
        $('body').append(downloadLink);
        downloadLink[0].click();
        downloadLink.remove();
    }

    $("#download_excel_format").click(function()
    {
        download_format();
    });

    $("#ue_form").submit(function(e) 
    { 
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        var file_choosed = false;
        var ok_to_upload = 0;

        if(file_element.get(0).files.length === 0)
        {
            file_choosed = false;
        }
        else
        {
            file_choosed = true;
            ok_to_upload += 1;
        }

        if(ok_to_upload == 1)
        {
            $.ajax(
                {
                    url: 'action/upload_excel.php', 
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) 
                    {
                        $("#excel_output").html(response);
                        $("#excel_output").css("margin-top", "10px");
                        showGreenAlert("הועלה בהצלחה");
                        $('table tr').each(function() 
                        {
                            if($(this).children().length === 0) 
                            {
                                $(this).remove();
                            }
                        });
                    }, 
                    error: function(xhr, status, err)
                    {
                        showRedAlert("שגיאה בהעלאת הקובץ");
                    }
                });
        }
        else if(!file_choosed)
        {
            showRedAlert("נא לבחור קובץ");
        }
        else
        {
            showRedAlert("נא למלא את כל הפרטים כדי להעלות את הקובץ");
        }
    });
});