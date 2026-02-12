<link rel="stylesheet" href="assets/css/rec/add_course.css">
<script src="assets/js/rec/add_course.js"></script>

<div class="popup_add_course_close_btn_fill">
    <div class="popup_add_course_close_btn">סגור</div>
</div>
<div class="add_course_countent">
    <div class="add_course_tb">
        <h2>הוספת קורס</h2>
        <div class="course_rb">סל המיחזור</div>
    </div>
    <div class="add_course_fill">
        <form id="add_course_form">
            <div class="course_name_field_fill">
                <label for="course_name_field">שם הקורס</label>
                &nbsp;
                <input type="text" name="course_name_field" id="course_name_field" class="basic_field">
            </div>
            <div class="select_level_fill">
                <label for="select_level">מרמה</label>
                &nbsp;
                <select id="create_course_select_level" name="select_level" class="basic_field pointer">
                    <option value="1">כיתה א'</option>
                    <option value="2">כיתה ב'</option>
                    <option value="3">כיתה ג'</option>
                    <option value="4">כיתה ד'</option>
                    <option value="5">כיתה ה'</option>
                    <option value="6">כיתה ו'</option>
                    <option value="7">כיתה ז'</option>
                    <option value="8">כיתה ח'</option>
                    <option value="9">כיתה ט'</option>
                    <option value="10">כיתה י'</option>
                    <option value="11">כיתה י"א</option>
                    <option value="12">כיתה י"ב</option>
                </select>
            </div>
            <div class="select_level_fill">
                <label for="select_level">עד רמה</label>
                &nbsp;
                <select id="create_course_select_level2" name="select_level2" class="basic_field pointer">
                    <option value="1">כיתה א'</option>
                    <option value="2">כיתה ב'</option>
                    <option value="3">כיתה ג'</option>
                    <option value="4">כיתה ד'</option>
                    <option value="5">כיתה ה'</option>
                    <option value="6">כיתה ו'</option>
                    <option value="7">כיתה ז'</option>
                    <option value="8">כיתה ח'</option>
                    <option value="9">כיתה ט'</option>
                    <option value="10">כיתה י'</option>
                    <option value="11">כיתה י"א</option>
                    <option value="12">כיתה י"ב</option>
                </select>
            </div>
            <input type="submit" value="צור קורס" class="submit">
        </form>
    </div>
    <div class="course_table_fill">
        <table id="course_table">
            <tr class="ct_row ct_first_row">
                <th class="ct_col ct_fr_col">ID</th>
                <th class="ct_col ct_fr_col">קורס</th>
                <th class="ct_col ct_fr_col">פעולות</th>
            </tr>
        </table>
    </div>


    <?php /*
    <div class="mng_crs_fill">
        <div class="mnc_ttl_fill">
            <h2 class="mnc_title">הקורס המנוהל כעת: <span class="mnc_ttl_crs">קורס PHP</span></h2>
        </div>
        <div class="course_students_fill">
            students in this course
        </div>
        <div class="course_classes_fill">
            classes of this course
        </div>
        <div class="course_teachers_fill">
            teachers of this course
        </div>
    </div>
    */ ?>
</div>