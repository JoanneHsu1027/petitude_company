<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/order-list-admin.php';
} else {
  include __DIR__ . '/order-list-no-admin.php';
};
