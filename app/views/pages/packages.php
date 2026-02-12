<link rel="stylesheet" href="assets/css/pages/packages.css">
<script src="assets/js/pages/packages.js"></script>

<?php

include_once("app/config/connection.php");
include_once("app/helpers/function.php");

// Start session if isn't started yet
if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

// Check if the user login
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user_pack WHERE user_id = '$user_id' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        // The user have pack
        $row = $query -> fetch_assoc();

        $start_date = $row['pack_start_date'];
        $end_date = $row['pack_end_date'];
        $today_date = date('Y-m-d H:i:s');

        $start_datetime = new DateTime($start_date);
        $end_datetime = new DateTime($end_date);
        $today_datetime = new DateTime($today_date);

        // The current date and time is within the pack period
        if($today_datetime < $start_datetime && !isset($_GET['p1']))
        {
            // "עדיין לא הגיע הזמן להתחלת החבילה";
            ?>
            <script>
                window.location.replace('?page=packages&p1');
            </script>
            <?php
        }
        else if($today_datetime > $end_datetime)
        {
            // "פג תוקף החבילה ב" . $end_date;
            ?>
            <div class="you_have_pack_fill">
                <span class="yhp_text">
                    <b>פג תוקף החבילה שלך ב: </b><?php echo $end_date; ?>
                </span>
                <?php if(!isset($_GET['p1']) && false){ ?>
                <a href="?page=packages&p1" class="another_pack_btn">לרכישת חבילה נוספת</a>
                <?php } ?>
            </div>
            <?php
        }
        else
        {
            if($today_datetime < $start_datetime)
            {
                $start_color = '1';
                $start_text = '<br><span style="color:#fff;background-color:#111;padding:2px 5px;border-radius:5px;"> שים לב שהחבילה שלך עדיין לא התחילה </span>';
            }
            else
            {$start_color='2';$start_text='';}
            ?>
            <div class="you_have_pack_fill">
                <span class="yhp_text">
                    <b>החבילה שלך: </b><?php echo pack_text($row['pack_name']); ?>
                    <br>
                    <b class="start_color_<?php echo $start_color; ?>">תאריך התחלה: </b><?php echo $start_date; ?>
                    <br>
                    <b>תאריך סיום: </b><?php echo $end_date; ?>
                    <?php echo $start_text; ?>
                </span>
                <?php if(!isset($_GET['p1']) && false){ ?>
                <a href="?page=packages&p1" class="another_pack_btn">לרכישת חבילה נוספת</a>
                <?php } ?>
            </div>
            <?php
        }
        
        if(!isset($_GET['p1'])){ die(); }
    }
}

?>

<div class="packages_page_fill">
    <div class="the_3_packs_fill t3p2">
        <div class="plan_fill">
            <div class="plan_top">
                <div class="ptd_fill">
                    <div class="plan_top_dot"></div>
                </div>
                <div class="plan_title_fill">
                    <span class="plan_title">קורס פרונטלי</span>
                </div>
                <div class="plan_subtitle_fill">
                    <span class="plan_subtitle">
                        בקורס פרונטלי תקבלו גם גישה לקורס שלכם בגרסה הדיגיטלית.
                    </span>
                </div>
            </div>
            <div class="plan_bottom">
                <div class="plan_price_fill">
                    <span class="plan_price">₪100</span>
                    <span class="after_price">לחודש</span>
                </div>
                <div class="plan_button_fill">
                    <button class="plan_button" id="1">
                        לבחירת התכנית
                    </button>
                </div>
                <div class="plan_checks_fill">
                    <ul class="plan_checks">
                        <li class="plan_check">גישה לקורס אליו נרשמתם</li>
                        <li class="plan_check">גישה לקורסים ברמה נמוכה משלכם</li>
                        <li class="plan_check">השיעור זמין 24/7 (דיגיטלי)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="plan_fill plan_2">
            <div class="plan_top">
                <div class="plan_tag_fill">
                    <span class="plan_tag">
                        הכי פופולארי
                    </span>
                </div>
                <div class="ptd_fill">
                    <div class="plan_top_dot"></div>
                </div>
                <div class="plan_title_fill">
                <span class="plan_title">קורס דיגיטלי</span>
                </div>
                <div class="plan_subtitle_fill">
                    <span class="plan_subtitle">
                        בקורס דיגיטלי תוכלו לקבל גישה גם לקורסים ברמה נמוכה יותר.
                    </span>
                </div>
            </div>
            <div class="plan_bottom">
                <div class="plan_price_fill">
                    <span class="plan_price">₪200</span>
                    <span class="after_price">לחודש</span>
                </div>
                <div class="plan_button_fill">
                    <button class="plan_button" id="2">
                        לבחירת התכנית
                    </button>
                </div>
                <div class="plan_checks_fill">
                    <ul class="plan_checks">
                        <li class="plan_check">גישה לקורס אליו נרשמתם</li>
                        <li class="plan_check">גישה לקורסים ברמה נמוכה משלכם</li>
                        <li class="plan_check">השיעור זמין 24/7 (דיגיטלי)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="plan_fill">
            <div class="plan_top">
                <div class="ptd_fill">
                    <div class="plan_top_dot"></div>
                </div>
                <div class="plan_title_fill">
                    <span class="plan_title">שיעורים פרטיים</span>
                </div>
                <div class="plan_subtitle_fill">
                    <span class="plan_subtitle">
                        שיעור פרטי 1 על 1.
                    </span>
                    <br><br>
                </div>
            </div>
            <div class="plan_bottom">
                <div class="plan_price_fill">
                    <span class="plan_price">₪300</span>
                    <span class="after_price">לחודש</span>
                </div>
                <div class="plan_button_fill">
                    <button class="plan_button" id="3">
                        לבחירת התכנית
                    </button>
                </div>
                <div class="plan_checks_fill">
                    <ul class="plan_checks">
                        <li class="plan_check">גישה לקורס אליו נרשמתם</li>
                        <li class="plan_check">גישה לקורסים ברמה נמוכה משלכם</li>
                        <li class="plan_check">השיעור זמין 24/7 (דיגיטלי)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>