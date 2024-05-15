<?php
session_start();

if (isset($_SESSION['admin'])) {
    include __DIR__ . '/project-admin.php';
} else {
    include __DIR__ . '/project-no-admin.php';
}
