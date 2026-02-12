<link rel="stylesheet" href="assets/css/main.css">

<div class="first-slide">
    <div class="fs1">
        <div class="fs-text-div">
            <h2 class="fs-title">ברוכים הבאים לאתר הרשמי של מכינת קורן</h2>
            <p class="fs-text">
                אני איליי קורן סטודנט מצטיין לביולוגיה באוניברסיטת בן גוריון, איש חינוך ולימוד בנפש.
                &nbsp;<br>
                מכינת קורן פועלת בקרית גת באר שבע וראשון לציון. מכינה אשר שמה למטרה להכין את התלמידים לחטיבת הביניים והתיכון. להרבה תלמידים זה יכול להיות הלם לא קטן המעבר בין בית ספר יסודי-לחטיבת ביניים ובין חטיבת הביניים-לתיכון. בשביל זה אנחנו כאן על מנת לעזור לתלמידים לנחות נחיתה רכה לחטיבת הביניים והתיכון על ידי הקניית כלים מתמטיים חישוביים ותיאורטים. 
            </p>
        </div>
        <div class="fs-img-div">
            <img src="assets/img/pic3.webp" class="fs-img1">
        </div>
    </div>
    <div class="fs2">
        <div id="the-slider">
            <div id="slider-right"><img src="assets/img/right.png" class="arrows"></div>
            <div id="pic-slider">
    <img class="slider-images-class" src="assets/img/slider/pic1.jpg">
            </div>
            <div id="slider-left"><img src="assets/img/left.png" class="arrows"></div>
        </div>
    </div>
            </div>
            <div class="video-fill">
    <h1>סרטון הסבר</h1>
    <video src="assets/vid/vid1.mp4" controls></video>
            </div>
            <div class="slide4">
    <div class="rec-students">
        <h1 class="sr_title">תלמידים ממליצים</h1>
        <img src="assets/img/students/1.jpg" class="sr_pic">
        <span class="sr_name">אביה</span>
        <p class="sr_text">
            בתחילת הקורס היה לי דיי קשה בלימודים שהגעתי לקורס של איליי התקדמתי ולמדתי המון דברים באנגלית וחשבון למדתי את לוח הכפל ושיטות לפתור תרגילים ממליץ מאוד.
        </p>
    </div>
    <div class="rec-parents">
        <h1 class="pr_title">הורים ממליצים</h1>
        <img src="assets/img/par.png" class="pr_pic">
        <span class="pr_name">שרית</span>
        <p class="pr_text">
            ממליצה בחום 
            איליי יודע לגשת לכל אחת ואחד מהילדים ולתת להם את הכלים המתאימים להם.
            הוא לא רק מלמד אותם פתרונות הוא יוצר איתם דרך חדשה להגיע בכוחות עצמם לפתרונות והצלחות .
        </p>
    </div>
            </div>
            <div class="slide5">
    <h1>הצוות המנצח שלנו</h1>
    <p>צוות המורים שלנו מורכב מסטודנטים שנבחרו בקפידה ועברו תהליך מיון נרחב שבוחן יכולות מנהיגות עמידה מול קהל וכמובן חתירה למצויינות. אנו מאמינים בצוות החינוכי שלנו בלב שלם ובטוחים שהם עושים ויעשו עבודה נפלאה בתור המורים של הילדים שלכם.</p>
    <div class="team-fill">
        <div class="arrows2" id="left-arrow2"><</div>
        <div class="our-team" id="ot">
            <?php
            
            $sql = "SELECT * FROM teachers WHERE id = '1'";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) >= 0)
            {
                while($row = mysqli_fetch_array($query))
                {
                    echo '
                        <div class="team-pic-fill">
                            <img src="assets/img/teachers/' . $row['pic'] . '" class="team-pics">
                            <span>' . $row['name'] .'</span>
                        </div>
                    ';
                }
            }
            else
            {
                echo "<h1>* עדיין לא עודכנה רשימת המורים *</h1>";
            }
            
            ?>
            
            
        </div>
        <div class="arrows2" id="right-arrow2">></div>
    </div>
</div>