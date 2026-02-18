<?php
// Cek apakah user sudah login
// session_start() sudah dipanggil di file yang memanggil auth.php

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
