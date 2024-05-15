<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/class-admin.php';
} else {
  include __DIR__ . '/class-no-admin.php';
}