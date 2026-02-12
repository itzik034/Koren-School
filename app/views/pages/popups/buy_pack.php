<?php

if(!isset($_GET['pack_id'])){die('error');}

$pack_id = $_GET['pack_id'];

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

?>

<link rel="stylesheet" href="assets/css/popups/buy_pack.css">

<div class="buy_pack_fill">
    <div class="bp_text_fill">
        <span class="bp_text">
            <b>החבילה שבחרת: </b><?php echo pack_text($pack_id); ?>
        </span>
    </div>
    <div class="bp_buy">
        קנה חבילה
    </div>
</div>