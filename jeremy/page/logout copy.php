<?php
session_start();

unset($_SESSION["admin"]);
# session_destroy(); # 如果用這個會清除所有的 session 資料

header("Location: index_.php");
# php的轉向(redirect)
