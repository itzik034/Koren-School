<?php

if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if(isset($_SESSION['user_id']) && isset($_SESSION['user_rank']))
{
	header("Location: ?page=records");
}

?>

<link rel="stylesheet" href="assets/css/pages/login.css">
<script src="assets/js/functions.js"></script>
<script src="assets/js/login.js"></script>
<script src="assets/js/pages/login-eye.js"></script>

<div class="login_page_fill">

<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="#" class="login_form" id="su_form">
			<h1 class="login_titles">הרשמה</h1>
			<div class="su_frm_name_spl">
                <input class="login_inputs" id="s_f_name" type="text" placeholder="שם פרטי" />
                <input class="login_inputs" id="s_l_name" type="text" placeholder="שם משפחה" />
            </div>
			<input class="login_inputs" id="s_email" type="email" placeholder="Email" />
			<input class="login_inputs" id="s_phone" type="tel" placeholder="מספר טלפון">
			<input class="login_inputs" id="s_pass" type="password" placeholder="סיסמה" />
			<div class="su_err_msg_fill">
				<div class="su_err_msg_text"></div>
			</div>
			<button class="login_btns">הירשם</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="#" class="login_form" id="li_form">
			<h1 class="login_titles">התחברות</h1>
			<input class="login_inputs" id="l_email" type="email" placeholder="Email" />
            <div class="login_fill_">
                <button type="button" id="togglePassword" class="fa fa-eye"></button>
                <input class="login_inputs" id="l_pass" type="password" placeholder="סיסמה" />
            </div>
            <div class="fail_login_text_fill">
                <span class="fail_login_text"></span>
            </div>
			<a href="#" class="forgot_pass_link">שכחת את הסיסמה?</a>
			<button class="login_btns">התחבר</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1 class="login_titles">ברוכים הבאים!</h1>
				<p class="login_par">אם אנחנו כבר מכירים אתם יכולים להתחבר ממש כאן</p>
				<button class="ghost login_btns" id="signIn">התחברות</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1 class="login_titles">שלום לך</h1>
				<p class="login_par">עדיין לא חלק מהצוות? מלא מספר פרטים זריזים והצטרף אלינו!</p>
				<button class="ghost login_btns" id="signUp">הרשמה</button>
			</div>
		</div>
	</div>
</div>


</div>