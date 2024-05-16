<?php

session_start();

$_SESSION['admin'] = [
  'b2b_id' => 1,
  'b2b_email' => 'user1@example.com',
  'b2b_name' => '關勞阪',
  'fk_b2b_job_id' => 1,
];

header('Location: b2b_list.php');
