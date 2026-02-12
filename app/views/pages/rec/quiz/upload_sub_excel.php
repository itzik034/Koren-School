<link rel="stylesheet" href="assets/css/quiz/upload_excel.css">
<script src="assets/js/quiz/upload_sub_excel.js"></script>

<div id="ue_content">
    <h2 class="exl_ttl">העלאת נושאים מתוך קובץ Excel</h2>
    <div class="download_format_button_fill">
        <button id="download_excel_sub_format"><i class="fa-solid fa-file-arrow-down"></i>הורדת קובץ פורמט</button>
    </div>
    <form id="use_form">
        <div class="ue_form_split">
            <div class="ue_form_split_top">
                <label for="excel_sub_file">בחר קובץ להעלאה</label>
                <input type="file" name="excel_sub_file" id="excel_sub_file">
            </div>
        </div>
        <input type="submit" value="העלאה ועדכון">
    </form>
    <div id="excel_sub_output"></div>
</div>