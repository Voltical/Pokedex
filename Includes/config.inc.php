<?php
    session_start();
    header("Cache-Control: no-cache, must-revalidate");

    require_once($root . "Includes/database.inc.php");

    function checkPost() {
        if(isset($_POST)) {
            foreach($_POST as $key => $value) {
                $_POST[$key] = trim(htmlentities(strip_tags($value)));
            }
        }
    }

    function checkGet() {
        if(isset($_GET)) {
            foreach($_GET as $key => $value) {
                $_GET[$key] = trim(htmlentities(strip_tags($value)));
            }
        }
    }

    checkPost();
    checkGet();