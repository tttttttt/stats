<?php

require_once('./config.php');
require_once('Smarty.class.php');

function no_cache_headers() {
  header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
  header('Cache-Control: post-check=0, pre-check=0', false);
  header('Pragma: no-cache');
}

function get_db_conn() {
  // mysqli_report(MYSQLI_REPORT_ALL);

  $db_conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if($db_conn->connect_errno) {
    die('mysql connect failed: ' . $db_conn->connect_errno);
  }

  $db_conn->set_charset('UTF-8');

  return $db_conn;
}

function get_template() {
  $tpl = new Smarty();
  $tpl->template_dir = BASEDIR . '/../templates/';
  $tpl->compile_dir  = BASEDIR . '/../templates_c/';
  $tpl->config_dir   = BASEDIR . '/../configs/';
  $tpl->cache_dir    = BASEDIR . '/../cache/';

  if(DEBUG_TEMPLATE) {
    $tpl->debugging = true;
  }

  return $tpl;
}

