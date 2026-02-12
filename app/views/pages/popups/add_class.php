<link rel="stylesheet" href="assets/css/popups/add_class.css">
<script src="assets/js/popups/add_class.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.css">


<div class="ac_background">
    <div class="ac_popup_fill">
        <div class="close_ac_fill">
            <span class="close_ac_btn">סגור</span>
        </div>
        <div class="ac_title_fill">
            <h1>הוספת כיתה</h1>
        </div>
        <form id="add_class_form">
            <input type="text" id="ac_class_name_field" placeholder="שם הכיתה">
            <select id="ac_select_course">
                <option>בחר קורס...</option>
            </select>
            <select id="ac_select_teach">
                <option>בחר מורה...</option>
            </select>
            <input type="text" id="ac_class_loc_field" placeholder="מיקום הכיתה">
            <label for="ac_class_date1" style="width:100%;font-weight:bold;">תאריך התחלה - </label>
            <input type="date" id="ac_class_date1">
            <label for="ac_class_date2" style="width:100%;font-weight:bold;">תאריך סיום - </label>
            <input type="date" id="ac_class_date2">
            <!-- <label for="ac_class_picture" style="width:100%;font-weight:bold;">תמונה - </label>
            <input type="file" id="class_picture" name="class_picture"> -->
            <button id="ac_update_class_data_btn">שמירה</button>
        </form>
    </div>
</div>