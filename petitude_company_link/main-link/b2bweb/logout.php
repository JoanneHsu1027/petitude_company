<?php

session_start();

unset($_SESSION['admin']);

header('Location: b2b_list.php');
