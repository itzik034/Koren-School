<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/classes.css">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <script src="assets/lib/jquery.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/lib/fontawesome/js/all.js" crossorigin="anonymous"></script>
    <title>מכינת קורן</title>
    <?php 

        include_once("app/config/connection.php");
        session_start();

    ?>
</head>
<body>
    <div class="header_fill">
        <?php include_once("app/views/components/header.php"); ?>
    </div>
    
    <div class="content">
        <?php
        
        if(isset($_GET['page']) && !empty($_GET['page']))
        {
            $page = $_GET['page'];
            if(file_exists('app/views/pages/'.$page.'.php'))
            {
                include_once('app/views/pages/' . $page . '.php');
            }
            else
            {
                include_once('app/views/errors/404.php');
            }
        }
        else
        {
            include_once('app/views/pages/main.php');
        }
        
        ?>
    </div>

    <?php include_once("app/views/components/footer.php"); ?>
</body>
</html>

<!--  Responsive style  -->
<link rel="stylesheet" href="css/res/styles.css">