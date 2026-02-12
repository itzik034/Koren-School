$(document).ready(function () {
  var file_element = $("#excel_file");

  function download_format() {
    var fileUrl = 'uploads/new_format.xlsx';
    var a = $('<a>');
    a.attr({ href: fileUrl, download: 'new_format.xlsx' });
    $('body').append(a);
    a[0].click();
    a.remove();
  }

  $("#download_excel_format").click(function () {
    download_format();
  });

  $("#ue_form").on("submit", function (e) {
    e.preventDefault();

    if (file_element.get(0).files.length === 0) {
      showRedAlert("נא לבחור קובץ");
      return;
    }

    var formData = new FormData(this);

    $.ajax({
      url: 'action/upload_excel.php',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $("#excel_output").html(response).css("margin-top", "10px");
        showGreenAlert("הועלה בהצלחה");
      },
      error: function (xhr, status, err) {
        const msg = xhr && xhr.responseText ? xhr.responseText : (status + " / " + err);
        showRedAlert("שגיאה בהעלאת הקובץ: " + msg);
      }
    });
  });
});
