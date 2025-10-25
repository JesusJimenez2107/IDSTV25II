<?php

$email = $_POST['email'];
$password = $_POST['password'];

if ($email == "jesus@example.com") {
    if ($password == "1234") {
        header(header: 'Location: ../home.html');
    }
} else
    header(header: 'Location: ../index.html');

?>