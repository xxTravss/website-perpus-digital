<?php

function base_url($path = '') {
    return "http://localhost/perpustakaan/" . $path;
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        redirect("../auth/login.php");
    }
}