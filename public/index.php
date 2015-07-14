<?php

define('IN_PROJECT', true);
require_once('./config.php');
require_once('./utils.php');

no_cache_headers();

$db_conn = get_db_conn();
$tpl     = get_template();

if(isset($_POST['submit'])) {
  $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
  $last_name  = isset($_POST['last_name'])  ? trim($_POST['last_name'])  : '';
  $phone      = isset($_POST['phone'])      ? trim($_POST['phone'])      : '';

  if($first_name && $last_name && $phone) {
    $status = 'new';
    $stmt = $db_conn->prepare('INSERT INTO `clients` (`added`, `first_name`, `last_name`, `status`, `phone`) VALUES (NOW(), ?, ?, ?, ?)');
    $stmt->bind_param('ssss', $first_name, $last_name, $status, $phone);
    $stmt->execute();
    $stmt->close();
  }
}

$all_clients = $db_conn->query('SELECT `id`, `added`, `first_name`, `last_name`, `status`, `phone` FROM `clients` ORDER BY `first_name` ASC, `last_name` ASC');
$result = array();
while ($row = $all_clients->fetch_assoc()) {
  $result[] = $row;
}

$db_conn->close();

if(count($result) > 0) {
  $tpl->assign('result', $result);
}

$tpl->display('index.tpl');
