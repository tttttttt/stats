<?php

define('IN_PROJECT', true);
require_once('./config.php');
require_once('./utils.php');

no_cache_headers();

$db_conn = get_db_conn();
$tpl     = get_template();

$period_num = isset($_POST['period']) ? trim($_POST['period']) : 1;
if(!preg_match("/^[1-9]+[0-9]*$/", $period_num)) {
  $period_num = 1;
}

$date_range = $db_conn->query('SELECT MIN(DATE(`added`)) AS `min_date`, MAX(DATE(`added`)) AS `max_date` FROM `clients`')->fetch_assoc();

$date_from = new DateTime($date_range['min_date']);
$date_till = new DateTime($date_range['max_date']);

$curr_period = clone $date_from;

if($period_num > 1) {
  $curr_period->sub(new DateInterval('P1D'));
}

while($curr_period <= $date_till) {
  $prev_period = clone $curr_period;

  $last = 0;

  if($period_num > 1) {
    $curr_period->add(new DateInterval('P' . $period_num . 'D'));

    if($curr_period >= $date_till) {
      $curr_period = clone $date_till;
      $last = 1;
    }
  }

  $stmt = $db_conn->prepare('SELECT count(*) AS `total_cnt` FROM `clients` WHERE `added` <= ?');
  $curr_period_str = $curr_period->format('Y-m-d') . ' ' . '23:59:59';
  $stmt->bind_param('s', $curr_period_str);
  $stmt->execute();
  $stmt->bind_result($total_cnt);
  $stmt->fetch();
  $stmt->close();

  $stmt = $db_conn->prepare('SELECT count(*) FROM `clients` WHERE `added` BETWEEN ? AND ?');
  $prev_period_str = $prev_period->format('Y-m-d') . ' ' . '00:00:00';
  $curr_period_str = $curr_period->format('Y-m-d') . ' ' . '23:59:59';
  $stmt->bind_param('ss', $prev_period_str, $curr_period_str);
  $stmt->execute();
  $stmt->bind_result($part_cnt);
  $stmt->fetch();
  $stmt->close();

  echo($curr_period->format('Y-m-d') . " day: $part_cnt total: $total_cnt conversion: " . round($part_cnt / $total_cnt, 2) . '<br />');

  if($last) {
    break;
  }

  if($period_num == 1) {
    $curr_period->add(new DateInterval('P1D'));
  }
}

$db_conn->close();

$tpl->display('charts.tpl');
