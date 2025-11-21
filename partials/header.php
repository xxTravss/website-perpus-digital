<?php
if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Perpustakaan Digital</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="/perpus/style.css">

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f0f4f8;
}

.layout {
    display: flex;
    min-height: 100vh;
}

.content-area {
    flex-grow: 1;
    padding: 30px;
}
</style>

</head>
<body>

<div class="layout">