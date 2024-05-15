<?php
session_start();

if (isset($_SESSION['admin'])) {
  include __DIR__ . '/article-admin.php';
} else {
  include __DIR__ . '/article-admin.php';
}