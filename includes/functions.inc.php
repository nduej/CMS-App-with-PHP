<?php
function secure()
{
    if (!isset($_SESSION['id'])) {
        set_message("Login to view this page!");
        header('Location: /PHP%20CMS%20APP');
        die();
    }
}

function set_message($message)
{
    $_SESSION['message'] = $message;
}

function get_message()
{
    if (isset($_SESSION['message'])) {
        echo "<script type='text/javascript'> 
        showToast('" . $_SESSION['message'] . "', 'top right', 'success')</script>";
        unset($_SESSION['message']);
    }
}







