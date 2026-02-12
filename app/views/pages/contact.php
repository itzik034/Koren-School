<link rel="stylesheet" href="assets/css/pages/contact.css">

<?php

if(isset($_GET['send']) && $_GET['send'] == 1)
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message_input = $_POST['message'];

    // Change the receiver email //
    $to = "mail@mail.this";
    echo $to;
    $subject = "הודעת צור קשר חדשה";

    $message = "<div style='direction:rtl;font-size: 18px;'>";
    $message .= "<b>שם: </b>".$name."<br>";
    $message .= "<b>מייל: </b>".$email."<br>";
    $message .= "<b>טלפון: </b>".$phone."<br><br>";
    $message .= "<b>הודעה: </b>".$message_input;
    $message .= "</div>";

    // Change the sender email //
    $headers = "From: Koren.School@mail.this\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if(mail($to, $subject, $message, $headers))
    {
        echo '<span class="sent_ok">הטופס נשלח בהצלחה! נחזור אליכם בהקדם האפשרי</span>';
    } 
    else 
    {
        echo '<span class="sent_fail">שגיאה בשליחת הטופס. אנא נסו שוב במועד מאוחר יותר.</span>';
    }
    die();
}

?>

<header>
    <h1 class="page-title">יצירת קשר</h1>
</header>
<main>
    <div class="before_form_fill">
        <p>השאירו פרטים ונחזור אליכם בהקדם האפשרי. נעשה את מיטב מאמצינו על מנת לתת לכם את השירות הטוב ביותר ואת שיעורי המתמטיקה הטובים ביותר לילדיכם.</p>
    </div>
    <div class="contact-form-container">
        <form action="?page=contact&send=1" method="POST" class="contact-form">
            <div class="form-group">
                <label for="name" class="form-label">שם</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">טלפון</label>
                <input type="phone" id="phone" name="phone" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="message" class="form-label">הודעה</label>
                <textarea id="message" name="message" class="form-textarea" rows="4" required></textarea>
            </div>
            <button type="submit" class="submit-button">שליחה</button>
        </form>
    </div>
</main>