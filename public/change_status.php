<?php

define('IN_PROJECT', true);
require_once('./config.php');
require_once('./utils.php');

$client_id     = isset($_POST['client_id'])     ? trim($_POST['client_id'])     : '';
$client_status = isset($_POST['client_status']) ? trim($_POST['client_status']) : '';

$client_statuses = array('unavailable' => 1, 'rejected' => 1, 'registered' => 1);

$data = array('status' => 'ERROR');

if($client_id && preg_match("/^[1-9]+[0-9]*$/", $client_id) && $client_status && $client_statuses[$client_status]) {
  $db_conn = get_db_conn();

  $stmt = $db_conn->prepare('UPDATE `clients` SET `status` = ? WHERE `id` = ?');
  $stmt->bind_param('si', $client_status, $client_id);
  $stmt->execute();
  $stmt->close();

  $db_conn->close();
  $data['status'] = 'OK';
}

header('Content-Type: application/json');
echo json_encode($data);
